<?php

namespace App\Http\Controllers;

use App\Eventalbums;
use Illuminate\Http\Request;
use App\Event;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
use Modules\Superadmin\Entities\Subscription;
use Modules\Superadmin\Entities\Package;
use App\EventAlbumPhotos;
use App\EventCollaborators;

class EventalbumsController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $business_id = session()->get('user.business_id');
        $event_id = session()->get('event_id');
        $event = Event::findOrFail($event_id);
        $albums = Eventalbums::where('business_id', $business_id)->where('event_id', $event_id)->get();

        return view('event_albums.index', compact('albums', 'event'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        $business_id = session()->get('user.business_id');
        $active = Subscription::active_subscription($business_id);
        // dd($business_id,$active);
        if (!$active) {
            return redirect()->back()->with('status', ['success' => 0, 'msg' => 'No active subscription found!']);
        }
        return view('event_albums.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $business_id = session()->get('user.business_id');
        $active = Subscription::active_subscription($business_id);
        // dd($business_id,$active);
        if (!$active) {
            return redirect()->back()->with('status', ['success' => 0, 'msg' => 'No active subscription found!']);
        }
        $event_id = session()->get('event_id');
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        // dd(date('Y-m-d',strtotime($validatedData['start_date'])));
        // Create a new Event instance
        $Eventalbums = new Eventalbums([
            'business_id' => $business_id,
            'event_id' => $event_id,
            'name' => $validatedData['name'],
            'status' => 'active',
        ]);

        // Save the event to the database
        $Eventalbums->save();

        return redirect()->route('event-management.show', $event_id)->with('status', ['success' => 1, 'msg' => 'Event album created successfull!']);

        // Redirect to the index page with a success message
        // return redirect()->back()->with('success', 'Event album created successfully');
    }

    // Display the specified resource.
    public function show($eventalbum)
    {
        $business_id = session()->get('user.business_id');
        $package = Subscription::active_subscription($business_id);

        if (empty($package)) {
            return redirect()->back()->with('status', ['success' => 0, 'msg' => 'No active subscription found!']);
        }

        // dd($package);

        $used_storage = EventAlbumPhotos::where('business_id', $business_id)->sum('size');


        // dd($package);
        $album_data = Eventalbums::findOrFail($eventalbum);

        $event = Event::findOrFail($album_data->event_id);
        // Specify the S3 folder path
        $folderPath = 'event-photos/event-' . $album_data->event_id . '/album-' . $album_data->id . '/thumbnails';
        // Initialize S3 client
        $s3Client = new S3Client([
            'region' => config('filesystems.disks.s3.region'),
            'version' => 'latest',
            'credentials' => [
                'key' => config('filesystems.disks.s3.key'),
                'secret' => config('filesystems.disks.s3.secret'),
            ],
        ]);

        // List objects in the specified folder
        $objects = $s3Client->listObjects([
            'Bucket' => config('filesystems.disks.s3.bucket'),
            'Prefix' => $folderPath,
        ]);

        // Generate pre-signed URLs for images
        $imageUrls = [];
        if ($objects['Contents']) {
            foreach ($objects['Contents'] as $key => $object) {
                $fileName = basename($object['Key']);

                $fileSizeBytes = EventAlbumPhotos::where('thumbnail_path', $folderPath . '/' . $fileName)->first();

                $command = $s3Client->getCommand('GetObject', [
                    'Bucket' => config('filesystems.disks.s3.bucket'),
                    'Key' => $object['Key'],
                ]);

                $request = $s3Client->createPresignedRequest($command, '+20 minutes');
                // dd($request);
                $preSignedUrl = (string) $request->getUri();
                if ($fileSizeBytes) {
                    if ($fileSizeBytes->id) {
                        $imageUrls[$fileName] = [
                            'url' => $preSignedUrl,
                            'size' => $fileSizeBytes->size,
                            'sku' => $fileSizeBytes->id,
                            'folderPath' => $folderPath,
                        ];
                    }

                }
            }
        }
        $user_event_permisions = ['upload_images', 'delete_images', 'protected_images', 'manage_albums', 'manage_overlay', 'manage_promotions', 'manage_discounts', 'get_what_you_sell', 'commission_based'];
        $event_collaborator = EventCollaborators::where('event_id', $album_data->event_id)->where('user_id', auth()->user()->id)->first();
        if ($event_collaborator) {
            $user_event_permisions = explode(',', $event_collaborator->user_permissions);
        }

        return view('event_albums.show', compact('album_data', 'event', 'imageUrls', 'package', 'used_storage', 'user_event_permisions'));
    }




    // Show the form for editing the specified resource.
    public function edit($event_album_id)
    {
        $business_id = session()->get('user.business_id');
        $active = Subscription::active_subscription($business_id);
        // dd($business_id,$active);
        if (!$active) {
            return redirect()->back()->with('status', ['success' => 0, 'msg' => 'No active subscription found!']);
        }
        $eventalbum = Eventalbums::findOrFail($event_album_id);
        // dd($eventalbum);
        return view('event_albums.edit', compact('eventalbum'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {

        $business_id = session()->get('user.business_id');
        $active = Subscription::active_subscription($business_id);
        // dd($business_id,$active);
        if (!$active) {
            return redirect()->back()->with('status', ['success' => 0, 'msg' => 'No active subscription found!']);
        }
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $album_data = Eventalbums::findOrFail($id);
        // Update the Eventalbum instance with the new data
        $album_data->update(['name' => $validatedData['name']]);

        // Redirect to the index page with a success message
        return redirect()->route('event-management.show', $album_data->event_id)->with('status', ['success' => 1, 'msg' => 'Event album updated successfully']);
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        try {
            $business_id = session()->get('user.business_id');
            $event_id = session()->get('event_id');
            // Delete the Eventalbum instance
            $album_id = $id;
            $all_photos = EventAlbumPhotos::where('business_id', $business_id)
                ->where('event_id', $event_id)
                ->where('album_id', $album_id)
                ->whereNotIn('id', function ($query) {
                    $query->select('photo_id')
                        ->from('user_photos');
                })->get();
            foreach ($all_photos as $key => $photo) {
                $orignal_path = $photo->path;
                $thumbnail_path = $photo->thumbnail_path;
                $low_quality_path = $photo->low_quality_path;
    
                Storage::disk('s3')->delete($orignal_path);
                Storage::disk('s3')->delete($thumbnail_path);
                Storage::disk('s3')->delete($low_quality_path);
                // Delete the record from the database
                EventAlbumPhotos::find($photo->id)->delete();
    
            }
            Eventalbums::find($album_id)->delete();
            return response()->json(['success' => 1, 'msg' => 'Event album deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => 'Error deleting event album']);

        }

    }
}

