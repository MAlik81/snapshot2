<?php

// app/Http/Controllers/EventphotosController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Event;

use App\Eventalbums;
use App\EventAlbumPhotos;

use App\Product;
use Illuminate\Support\Facades\DB;
use App\Events\ProductsCreatedOrModified;
use App\Unit;
use App\Utils\ModuleUtil;
use App\Utils\ProductUtil;
use Intervention\Image\ImageManager;
use Aws\S3\S3Client;
use Modules\Superadmin\Entities\Subscription;
use Modules\Superadmin\Entities\Package;
use Aws\Rekognition\RekognitionClient;
use App\Services\RekognitionService;
use Illuminate\Support\Str;

class EventphotosController extends Controller
{
    protected $rekognitionService;
    protected $collectionId = 'snap.shot.collection.1.1711304506';
    public function __construct(RekognitionService $rekognitionService)
    {
        $this->rekognitionService = $rekognitionService;
    }

    public function createCollection()
    {
        $collectionId = 'snap.shot.collection.1.' . strtotime('now'); // Define your collection ID here
        $result = $this->rekognitionService->createCollection($collectionId);
        dd($result);
        if ($result) {
            return response()->json(['success' => true, 'message' => 'Collection created successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to create collection']);
        }
    }
    public function upload(Request $request, $album_id)
    {
        try {
            $business_id = session()->get('user.business_id');
            $active = Subscription::active_subscription($business_id);
            // dd($business_id,$active);
            if (!$active) {
                return redirect()->back()->with('status', ['success' => 0, 'msg' => 'No active subscription found!']);
            }
            $user_id = session()->get('user.id');
            if (!checkIfDataRemaining($business_id)) {
                throw new \Exception("You have exceeded your allowed storage. Please contact support.", 1);
            }

            // Validate the incoming request
            $validator = Validator::make($request->all(), [
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            ]);
            $meta_data = $request->input('meta_data');
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 400);
            }
            $album_data = Eventalbums::findOrFail($album_id);
            $event = Event::findOrFail($album_data->event_id);
            $low_quality = $event->low_quality;
            if (!$low_quality) {
                $low_quality = 50;
            }
            // Store the uploaded image to Amazon S3
            $path_full = 'event-photos/event-' . $album_data->event_id . '/album-' . $album_data->id;
            $filename = Str::random(20) . time() . '_' . $request->file('file')->getClientOriginalName();
            $path_original = $request->file('file')->storeAs($path_full, $filename, 's3');

            // Initialize AWS Rekognition client
            $rekognition = new RekognitionClient([
                'region' => env('AWS_DEFAULT_REGION'),
                'version' => 'latest',
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);

            // Index the uploaded image with AWS Rekognition
            $result = $rekognition->indexFaces([
                'CollectionId' => env('AWS_COLLECTION_ID'),
                'Image' => [
                    'S3Object' => [
                        'Bucket' => env('AWS_BUCKET'),
                        'Name' => $path_original,
                    ],
                ],
            ]);
            $imageId = null;
            // Check if faces were detected
            if (!empty($result['FaceRecords'])) {
                $imageId = $result['FaceRecords'][0]['Face']['ImageId'];
            }



            // Detect text in the uploaded image
            $textDetectionResult = $rekognition->detectText([
                'Image' => [
                    'S3Object' => [
                        'Bucket' => env('AWS_BUCKET'),
                        'Name' => $path_original,
                    ],
                ],
            ]);

            // Extract detected text
            $detectedText = [];
            foreach ($textDetectionResult['TextDetections'] as $textDetection) {
                $detectedText[] = $textDetection['DetectedText'];
            }
            $bib_number = '';
            $bib_number = implode(',', $detectedText);
            // Create a thumbnail of the image
            $thumbnail = $this->resize_image($request->file('file'), 200, 200);

            ob_start();
            imagejpeg($thumbnail, null, 80);
            $thumbnailData = ob_get_clean();
            $thumbnail_path = $path_full . '/thumbnails/' . $filename;
            $thumb_resp = Storage::disk('s3')->put($thumbnail_path, $thumbnailData, 'public');


            $low_quality_image  = $this->resize_image_by_percentage($request->file('file'), $low_quality, false);

            ob_start();
            imagejpeg($low_quality_image, null, 80);
            $low_qualityData = ob_get_clean();
            $low_quality_path = $path_full . '/low_quality/' . $filename;
            $thumb_resp = Storage::disk('s3')->put($low_quality_path, $low_qualityData, 'public');
            // Add metadata for both original and thumbnail
            $metadata = [
                'business_id' => $business_id,
                'event_id' => $album_data->event_id,
                'album_id' => $album_data->id,
                'name' => $filename,
                'size' => ($request->file('file')->getSize()) / 1024,
                'search_meta' => $meta_data
            ];

            // Store the image data in the database
            $photo_data = [
                'business_id' => $business_id,
                'event_id' => $album_data->event_id,
                'album_id' => $album_data->id,
                'created_by' => $user_id,
                'path' => $path_original,
                'thumbnail_path' => $thumbnail_path,
                'low_quality_path' => $low_quality_path,
                'name' => $filename,
                'meta' => $meta_data,
                'size' => ($request->file('file')->getSize()) / 1024,
                'rekognition_data' => json_encode($result->toArray()), // Store Rekognition response
                'image_id' => $imageId, // Store Rekognition image ID
                'bib_number' => $bib_number, // Store Rekognition image ID
            ];

            EventAlbumPhotos::create($photo_data);
            imagedestroy($thumbnail);
            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully!',
                'original_path' => $path_original,
                'thumbnail_path' => $thumbnail_path,
                'metadata' => $metadata,
            ], 200);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('S3 Upload Error: ' . $e);
            // dd($e);
            // Return an error response
            return response()->json(['error' => 'Error uploading thumbnail to S3'], 500);
        }
    }
    private function resize_image($file, $w, $h, $crop = FALSE)
    {
        // Ensure that the file is an uploaded file
        if (!is_uploaded_file($file)) {
            throw new \Exception("Uploaded file is not valid");
        }

        // Get image dimensions and type
        list($width, $height, $type) = getimagesize($file);
        $src = '';

        // Create image resource based on type
        switch ($type) {
            case IMAGETYPE_JPEG:
                $src = imagecreatefromjpeg($file);
                break;
            case IMAGETYPE_PNG:
                $src = imagecreatefrompng($file);
                break;
            case IMAGETYPE_GIF:
                $src = imagecreatefromgif($file);
                break;
            case IMAGETYPE_WEBP:
                $src = imagecreatefromwebp($file);
                break;
            default:
                throw new \Exception("Unsupported image type");
        }

        // Calculate new dimensions
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width - ($width * abs($r - $w / $h)));
            } else {
                $height = ceil($height - ($height * abs($r - $w / $h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w / $h > $r) {
                $newwidth = $h * $r;
                $newheight = $h;
            } else {
                $newheight = $w / $r;
                $newwidth = $w;
            }
        }

        // Create resized image
        $dst = imagecreatetruecolor($newwidth, $newheight);
        if (!$dst) {
            throw new \Exception("Failed to create destination image");
        }

        // Resize the image
        if (!imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height)) {
            throw new \Exception("Failed to resize image");
        }

        // Return the resized image resource
        return $dst;
    }
    private function resize_image_by_percentage($file, $percentage, $crop = FALSE)
    {
        // Ensure that the file is an uploaded file
        if (!is_uploaded_file($file)) {
            throw new \Exception("Uploaded file is not valid");
        }

        // Get image dimensions and type
        list($width, $height, $type) = getimagesize($file);
        $src = '';

        // Create image resource based on type
        switch ($type) {
            case IMAGETYPE_JPEG:
                $src = imagecreatefromjpeg($file);
                break;
            case IMAGETYPE_PNG:
                $src = imagecreatefrompng($file);
                break;
            case IMAGETYPE_GIF:
                $src = imagecreatefromgif($file);
                break;
            case IMAGETYPE_WEBP:
                $src = imagecreatefromwebp($file);
                break;
            default:
                throw new \Exception("Unsupported image type");
        }

        // Calculate new dimensions
        $newwidth = $width * $percentage / 100;
        $newheight = $height * $percentage / 100;

        // Create resized image
        $dst = imagecreatetruecolor($newwidth, $newheight);
        if (!$dst) {
            throw new \Exception("Failed to create destination image");
        }

        // Resize the image
        if (!imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height)) {
            throw new \Exception("Failed to resize image");
        }

        // Return the resized image resource
        return $dst;
    }

    public function createProduct($name, $event_id, $album_id, $path)
    {
        if (!auth()->user()->can('product.create')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $business_id = session()->get('user.business_id');
            $form_fields = ['name', 'brand_id', 'unit_id', 'category_id', 'tax', 'type', 'barcode_type', 'sku', 'alert_quantity', 'tax_type', 'weight', 'product_description', 'sub_unit_ids', 'preparation_time_in_minutes', 'product_custom_field1', 'product_custom_field2', 'product_custom_field3', 'product_custom_field4', 'product_custom_field5', 'product_custom_field6', 'product_custom_field7', 'product_custom_field8', 'product_custom_field9', 'product_custom_field10', 'product_custom_field11', 'product_custom_field12', 'product_custom_field13', 'product_custom_field14', 'product_custom_field15', 'product_custom_field16', 'product_custom_field17', 'product_custom_field18', 'product_custom_field19', 'product_custom_field20',];

            $module_form_fields = $this->moduleUtil->getModuleFormField('product_form_fields');
            if (!empty($module_form_fields)) {
                $form_fields = array_merge($form_fields, $module_form_fields);
            }

            $product_details = array();
            $product_details['business_id'] = $business_id;
            $product_details['name'] = $name;
            $product_details['product_custom_field1'] = $event_id;
            $product_details['product_custom_field2'] = $album_id;
            $product_details['image'] = $path;
            $product_details['created_by'] = session()->get('user.id');

            DB::beginTransaction();

            $product = Product::create($product_details);

            event(new ProductsCreatedOrModified($product_details, 'added'));

            $sku = $this->productUtil->generateProductSku($product->id);
            $product->sku = $sku;
            $product->save();

            $this->productUtil->createSingleProductVariation($product->id, $product->sku, 1, 1, 0, 1, 1, array());
            DB::commit();
            $output = [
                'success' => 1,
                'msg' => __('product.product_added_success'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency('File:' . $e->getFile() . 'Line:' . $e->getLine() . 'Message:' . $e->getMessage());

            $output = [
                'success' => 0,
                'msg' => __('messages.something_went_wrong'),
            ];

            return $output;
        }
        return $output;
    }
    public function destroy(Request $request)
    {
        $business_id = session()->get('user.business_id');
        $eventphoto = $request->input('eventphotoId');
        $eventphotoModel = EventAlbumPhotos::where('business_id', $business_id)->where('thumbnail_path', $eventphoto)
        ->whereNotIn('id', function ($query) {
            $query->select('photo_id')
                ->from('user_photos');
        })
        ->get();

        // Specify the key of the object to delete
        $key = $eventphoto;
        if ($eventphotoModel && count($eventphotoModel) > 0){
            // Delete the object from S3
            Storage::disk('s3')->delete($eventphotoModel[0]['path']);
            Storage::disk('s3')->delete($eventphotoModel[0]['thumbnail_path']);
            Storage::disk('s3')->delete($eventphotoModel[0]['low_quality_path']);
            // Delete the record from the database
            EventAlbumPhotos::findOrFail($eventphotoModel[0]['id'])->delete();
        }


        // Return a JSON response
        return response()->json(['message' => 'Image deleted successfully']);
    }
    public function deletePhotoById(Request $request)
    {
        $business_id = session()->get('user.business_id');
        $eventphotoId = $request->input('eventphotoId');
        $eventphotoModel = EventAlbumPhotos::where('business_id', $business_id)->where('id', $eventphotoId)
        ->whereNotIn('id', function ($query) {
            $query->select('photo_id')
                ->from('user_photos');
        })
        ->get();
        if ($eventphotoModel && count($eventphotoModel) > 0){
            // Delete the object from S3
            Storage::disk('s3')->delete($eventphotoModel[0]['path']);
            Storage::disk('s3')->delete($eventphotoModel[0]['thumbnail_path']);
            Storage::disk('s3')->delete($eventphotoModel[0]['low_quality_path']);
            // Delete the record from the database
            EventAlbumPhotos::findOrFail($eventphotoModel[0]['id'])->delete();
        }

        // Return a JSON response
        return response()->json(['message' => 'Image deleted successfully']);
    }
    public function searchSimilarImages(Request $request)
    {
        $business_id = session()->get('user.business_id');
        $active = Subscription::active_subscription($business_id);
        // dd($business_id,$active);
        if (!$active) {
            return response()->json(['error' => 'No active subscription found!'], 500);
        }
        try {
            // Validate the incoming request
            $validator = Validator::make($request->all(), [
                'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 400);
            }

            // Initialize AWS Rekognition client
            $rekognition = new RekognitionClient([
                'region' => env('AWS_DEFAULT_REGION'),
                'version' => 'latest',
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);

            // Extract features from the uploaded image
            $image = $request->file('file');
            $imageData = file_get_contents($image->getRealPath());
            $result = $rekognition->detectLabels([
                'Image' => [
                    'Bytes' => $imageData,
                ],
            ]);

            // Search for similar images
            $searchResult = $rekognition->searchFacesByImage([
                'CollectionId' => env('AWS_COLLECTION_ID'),
                'Image' => [
                    'Bytes' => $imageData,
                ],
            ]);
            // dd($searchResult);
            // Process search results
            $similarImages = [];
            foreach ($searchResult['FaceMatches'] as $match) {
                // Retrieve the URL of the matched image from your database based on its ID
                $matchedImage = EventAlbumPhotos::where('image_id', $match['Face']['ImageId'])->first();
                if ($matchedImage) {
                    $similarImages[] = [
                        'Similarity' => $match['Similarity'],
                        'ImageUrl' => Storage::disk('s3')->url($matchedImage->thumbnail_path),
                        'Image_id' => $matchedImage->id,
                        // You can retrieve additional metadata of the matched image from your database
                    ];
                }
            }
            // dd($similarImages,$searchResult);
            return response()->json([
                'success' => true,
                'message' => 'Similar images found successfully!',
                'similar_images' => $similarImages,
                'labels' => $result['Labels'], // Labels detected in the uploaded image
            ], 200);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Rekognition Search Error: ' . $e->getMessage());
            // Return an error response
            return response()->json(['error' => 'Error searching for similar images'], 500);
        }
    }

    function protectedImages($album_id)
    {
        $business_id = session()->get('user.business_id');
        $active = Subscription::active_subscription($business_id);
        // dd($business_id,$active);
        if (!$active) {
            return redirect()->back()->with('status', ['success' => 0, 'msg' => 'No active subscription found!']);
        }
        // dd($album_id);
        $album_data = Eventalbums::findOrFail($album_id);

        $event = Event::findOrFail($album_data->event_id);
        return view('event_albums.pretected_images', compact('album_id', 'album_data', 'event'));

    }

}
