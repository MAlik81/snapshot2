<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Aws\Rekognition\RekognitionClient;
use App\Event;
use App\Eventalbums;
use App\EventAlbumPhotos;
use Illuminate\Support\Str;


class ProcessImageUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tempPath;
    protected $album_id;
    protected $metadata;

    public function __construct($tempPath, $album_id, $metadata)
    {
        $this->tempPath = $tempPath;
        $this->album_id = $album_id;
        $this->metadata = $metadata;
    }
    public function queue()
    {
        return 'processimageupload';
    }
    public function handle()
    {
        try {
            \Log::info('ProcessImageUpload Job started.');

            // Get the full path to the uploaded file in public directory
            $fullPath = public_path($this->tempPath);

            // Check if the file exists
            if (!file_exists($fullPath)) {
                throw new \Exception("Uploaded file not found at $fullPath.");
            }

            // Proceed with processing
            $album_data = Eventalbums::findOrFail($this->album_id);
            $event = Event::findOrFail($album_data->event_id);
            $low_quality = $event->low_quality ?? 50;

            // Generate filenames
            $filename = Str::random(20) . '_' . time() . '_' . basename($this->tempPath);
            $path_full = 'event-photos/event-' . $album_data->event_id . '/album-' . $album_data->id;
            $path_original = Storage::disk('s3')->putFileAs($path_full, new \Illuminate\Http\File($fullPath), $filename);

            // Initialize Rekognition client
            $rekognition = new RekognitionClient([
                'region' => env('AWS_DEFAULT_REGION'),
                'version' => 'latest',
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);

            // Index faces in the image
            $result = $rekognition->indexFaces([
                'CollectionId' => env('AWS_COLLECTION_ID'),
                'Image' => [
                    'S3Object' => [
                        'Bucket' => env('AWS_BUCKET'),
                        'Name' => $path_original,
                    ],
                ],
            ]);

            // Extract detected text
            $detectedText = [];
            $textDetectionResult = $rekognition->detectText([
                'Image' => [
                    'S3Object' => [
                        'Bucket' => env('AWS_BUCKET'),
                        'Name' => $path_original,
                    ],
                ],
            ]);
            foreach ($textDetectionResult['TextDetections'] as $textDetection) {
                $detectedText[] = $textDetection['DetectedText'];
            }
            $bib_number = implode(',', $detectedText);

            // Generate thumbnails
            $thumbnail = $this->resize_image($fullPath, 200, 200);
            ob_start();
            imagejpeg($thumbnail, null, 80);
            $thumbnailData = ob_get_clean();
            $thumbnail_path = $path_full . '/thumbnails/' . $filename;
            Storage::disk('s3')->put($thumbnail_path, $thumbnailData, 'public');

            // Generate low-quality images
            $low_quality_image = $this->resize_image_by_percentage($fullPath, $low_quality, false);
            ob_start();
            imagejpeg($low_quality_image, null, 80);
            $low_qualityData = ob_get_clean();
            $low_quality_path = $path_full . '/low_quality/' . $filename;
            Storage::disk('s3')->put($low_quality_path, $low_qualityData, 'public');

            // Clean up: delete the temporary file from public directory
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            // Store processed image data in database
            $resp = EventAlbumPhotos::create([
                'business_id' => session()->get('user.business_id'),
                'event_id' => $album_data->event_id,
                'album_id' => $album_data->id,
                'created_by' => session()->get('user.id'),
                'path' => $path_original,
                'thumbnail_path' => $thumbnail_path,
                'low_quality_path' => $low_quality_path,
                'name' => $filename,
                'meta' => $this->metadata,
                'size' => Storage::disk('s3')->size($path_original) / 1024,
                'rekognition_data' => json_encode($result->toArray()),
                'image_id' => !empty($result['FaceRecords']) ? $result['FaceRecords'][0]['Face']['ImageId'] : null,
                'bib_number' => $bib_number,
            ]);

            \Log::info('ProcessImageUpload Job completed successfully.');
        } catch (\Exception $e) {
            \Log::error('ProcessImageUpload Job Error: ' . $e->getMessage());
        }
    }

    private function resize_image($file, $w, $h, $crop = false)
    {
        list($width, $height, $type) = getimagesize($file);
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

        $dst = $this->get_resized_image($src, $width, $height, $w, $h, $crop);
        imagedestroy($src);

        return $dst;
    }

    private function resize_image_by_percentage($file, $percentage, $crop = false)
    {
        list($width, $height, $type) = getimagesize($file);
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

        $newwidth = $width * $percentage / 100;
        $newheight = $height * $percentage / 100;

        $dst = $this->get_resized_image($src, $width, $height, $newwidth, $newheight, $crop);
        imagedestroy($src);

        return $dst;
    }

    private function get_resized_image($src, $width, $height, $newwidth, $newheight, $crop)
    {
        $dst = imagecreatetruecolor($newwidth, $newheight);
        if ($crop) {
            $ratio = $width / $height;
            if ($width > $height) {
                $width = ceil($width - ($width * abs($ratio - $newwidth / $newheight)));
            } else {
                $height = ceil($height - ($height * abs($ratio - $newwidth / $newheight)));
            }
        }

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        return $dst;
    }
}