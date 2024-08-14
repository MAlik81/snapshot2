<?php

// app/Http/Controllers/EventManagementController.php

namespace App\Http\Controllers;

use App\Event;
use App\EventPhotoDiscount;
use App\Utils\ModuleUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Eventalbums;
use App\User;
use App\Withdrawals;
use App\PhotosSalesRecord;
use App\FrontUserPhotos;
use App\EventAlbumPhotos;
use App\EventCollaborators;

use App\OverlayImage;
use App\EventFreeLanceUsers;
use App\EventAffiliateUsers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Superadmin\Entities\Subscription;



class EventManagementController extends Controller
{
    public function index()
    {
        session()->forget('event_id');
        // dd(auth()->user()->can('affiliate'),auth()->user()->can('business_settings.access'));
        // dd(session()->get('user.id'));
        // session()->get('user.id');
        $business_id = session()->get('user.business_id');


        if (request()->ajax()) {
            $events = Event::where('events.business_id', $business_id);

            $user = auth()->user();
            $role_name = $user->roles[0]->name;
            if ($role_name == 'Collaborator#' . $business_id) {
                $events->leftJoin('event_collaborator', 'event_collaborator.event_id', '=', 'events.id')
                    ->where('event_collaborator.user_id', $user->id)
                    ->whereNotNull('event_collaborator.user_id');
            }
            $events->select([
                'events.id',
                'events.name',
                'events.location',
                'events.start_date',
                'events.end_date',
                'events.status',
                'events.created_at', // Assuming your Event model has a 'created_at' timestamp
            ]);
            // dd($events->toSql());
            return DataTables::of($events)
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('event.update')) {
                        $html = '<a type="button" class="btn btn-primary btn-xs" href="' . action([\App\Http\Controllers\EventManagementController::class, 'edit'], [$row->id]) . '">'
                            . __('Edit') . '</a>  ';
                    }
                    if (auth()->user()->can('event.delete')) {
                        $html .= '<button type="button" class="btn btn-danger btn-xs delete-event" data-event-id="' . $row->id . '">'
                            . __('Delete') . '</button> ';
                    }
                    if ($row->status == 'active') {
                        $html .= '<a type="button" class="btn btn-success btn-xs" href="' . action([\App\Http\Controllers\EventManagementController::class, 'show'], [$row->id]) . '">'
                            . __('Manage Event') . '</a>  ';

                        $html .= '<a type="button" class="btn btn-default btn-xs" target="_blank" href="' . route('event-photos', ['event_id' => $row->id, 'album_id' => 0]) . '">'
                            . 'Event Preview' . '</a>';

                    }
                    // Add other action buttons as needed
                    return $html;
                })
                ->filterColumn('start_date', function ($query, $keyword) {
                    // Implement custom filter for start_date
                    $query->whereRaw("DATE_FORMAT(start_date, '%Y-%m-%d') like ?", ["%$keyword%"]);
                })
                ->filterColumn('location', function ($query, $keyword) {
                    // Implement custom filter for location
                    $query->where('location', 'like', "%$keyword%");
                })
                ->editColumn('start_date', function ($row) {
                    return date('Y-m-d', strtotime($row->start_date));
                })
                ->editColumn('created_at', function ($row) {
                    return date('Y-m-d H:i:s', strtotime($row->created_at));
                })
                ->editColumn('status', function ($row) {
                    return '<span class="badge ' . ($row->status == 'active' ? 'bg-green' : 'bg-red') . '">'
                        . strtoupper($row->status) . '</span>';
                    // strtoupper($row->status);
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('event_management.index');
    }

    public function create()
    {
        $business_id = session()->get('user.business_id');
        $active = Subscription::active_subscription($business_id);
        // dd($business_id,$active);
        if (!$active) {
            return redirect()->back()->with('status', ['success' => 0, 'msg' => 'No active subscription found!']);
        }
        // Logic for displaying the event creation form
        return view('event_management.create');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust maximum file size as needed
        ]);

        if ($request->file('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            return 'Image uploaded successfully: ' . Storage::url($imagePath);
        } else {
            return 'No image selected.';
        }
    }

    public function store(Request $request)
    {
        try {
            $business_id = session()->get('user.business_id');
            $active = Subscription::active_subscription($business_id);
            // dd($business_id,$active);
            if (!$active) {
                return redirect()->back()->with('status', ['success' => 0, 'msg' => 'No active subscription found!']);
            }
            $old_data = $request->all();
            unset($old_data['_token']);
            unset($old_data['event_cover_selector']);
            session()->put('old_data', $old_data);
            // Validate the request
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'timezone' => 'required|string|max:255',
                'event_type' => 'required|string|max:255',
                'photo_option' => 'required|in:sell,free',
                'per_photo_price' => ($request->photo_option == 'sell') ? 'required|numeric' : '', // Only validate per_photo_price if selling photos
                'low_quality_per_photo_price' => ($request->photo_option == 'sell') ? 'required|numeric' : '', // Only validate per_photo_price if selling photos
                'low_quality' => ($request->photo_option == 'sell') ? 'required|numeric' : '', // Only validate per_photo_price if selling photos
                'event_cover' => 'required',
                'status' => 'in:active,inactive',
            ]);
            $imagePath = $validatedData['event_cover'];

            $event = new Event([
                'business_id' => $business_id,
                'name' => $validatedData['name'],
                'location' => $validatedData['location'],
                'country' => $validatedData['country'],
                'start_date' => date('Y-m-d', strtotime($validatedData['start_date'])),
                'end_date' => date('Y-m-d', strtotime($validatedData['end_date'])),
                'timezone' => $validatedData['timezone'],
                'event_type' => $validatedData['event_type'],
                'photo_option' => $validatedData['photo_option'],
                'event_cover' => $imagePath,
                'per_photo_price' => $validatedData['per_photo_price'] ?? null,
                'low_quality_per_photo_price' => $validatedData['low_quality_per_photo_price'] ?? null,
                'low_quality' => $validatedData['low_quality'] ?? null,
                'status' => $validatedData['status'] ?? 'inactive',
            ]);

            // Save the event to the database
            $event->save();
            $old_data = $request->all();
            unset($old_data['_token']);
            unset($old_data['event_cover_selector']);
            session()->put('old_data', $old_data);
            // Redirect to the index page with a success message
            return redirect()->route('event-management.index')->with('status', ['success' => 1, 'msg' => 'Event created successfully!']);
        } catch (\Exception $e) {
            $old_data = $request->all();
            unset($old_data['_token']);
            unset($old_data['event_cover_selector']);
            session()->put('old_data', $old_data);
            return redirect()->back()->with('status', ['success' => 0, 'msg' => $e->getMessage()]);
        }

    }
    public function edit($id)
    {
        $business_id = session()->get('user.business_id');
        $active = Subscription::active_subscription($business_id);
        // dd($business_id,$active);
        if (!$active) {
            return redirect()->back()->with('status', ['success' => 0, 'msg' => 'No active subscription found!']);
        }
        $event = Event::where('business_id', $business_id)->findOrFail($id);
        // dd($event);
        return view('event_management.edit', compact('event'));
    }
    public function update(Request $request, $id)
    {
        try {
            $business_id = session()->get('user.business_id');

            // Validate the request
            $data_sent = $request->all();
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'timezone' => 'required|string|max:255',
                'event_type' => 'required|string|max:255',
                'photo_option' => 'required|in:sell,free',
                'per_photo_price' => ($request->photo_option == 'sell') ? 'required|numeric' : '', // Only validate per_photo_price if selling photos
                'low_quality_per_photo_price' => ($request->photo_option == 'sell') ? 'required|numeric' : '', // Only validate per_photo_price if selling photos
                'low_quality' => ($request->photo_option == 'sell') ? 'required|numeric' : '', // Only validate per_photo_price if selling photos
                'event_cover' => 'required',
                'status' => 'in:active,inactive',
            ]);

            // Find the Event by ID
            $event = Event::where('business_id', $business_id)->findOrFail($id);
            $imagePath = $validatedData['event_cover'];

            // dd(Storage::url($imagePath));
            // Update the Event instance with the validated data
            $event->update([
                'name' => $validatedData['name'],
                'location' => $validatedData['location'],
                'country' => $validatedData['country'],
                'start_date' => date('Y-m-d', strtotime($validatedData['start_date'])),
                'end_date' => date('Y-m-d', strtotime($validatedData['end_date'])),
                'timezone' => $validatedData['timezone'],
                'event_type' => $validatedData['event_type'],
                'photo_option' => $validatedData['photo_option'],
                'event_cover' => $imagePath,
                'per_photo_price' => $validatedData['per_photo_price'] ?? null,
                'low_quality_per_photo_price' => $validatedData['low_quality_per_photo_price'] ?? null,
                'low_quality' => $validatedData['low_quality'] ?? null,
                'status' => $validatedData['status'] ?? 'inactive',
            ]);
            return redirect()->route('event-management.index')->with('status', ['success' => 1, 'msg' => 'Event updated successfully!']);
        } catch (\Exception $e) {
            return redirect()->back()->with('status', ['success' => 0, 'msg' => $e->getMessage()]);
        }

    }

    public function show($id)
    {
        try {
            $business_id = session()->get('user.business_id');
            $active = Subscription::active_subscription($business_id);
            // dd($business_id,$active);
            if (!$active) {
                return redirect()->back()->with('status', ['success' => 0, 'msg' => 'No active subscription found!']);
            }
            session()->put('event_id', $id);
            $event = Event::where('business_id', $business_id)->findOrFail($id);
            $albums = Eventalbums::where('event_albums.business_id', $business_id)
                ->where('event_albums.event_id', $id)
                ->leftJoin('event_album_photos', 'event_album_photos.album_id', '=', 'event_albums.id')
                ->leftJoin('user_photos', 'user_photos.photo_id', '=', 'event_album_photos.id')
                ->select('event_albums.*', \DB::raw('count(event_album_photos.id) as photo_count,SUM(amount_paid) AS amount_paid'))
                ->groupBy('event_albums.id')
                ->get();

            $photoDiscountSetting = EventPhotoDiscount::where('business_id', $business_id)->where('event_id', $id)->first();
            $overlay = OverlayImage::where('business_id', $business_id)->where('event_id', $id)->first();

            $all_collaborators = array();
            $all_collaborators_raw = User::role('Collaborator#' . $business_id)
                ->whereNotIn('id', function ($query) use ($id) {
                    $query->select('user_id')
                        ->from('event_collaborator')
                        ->where('event_id', $id);
                })
                ->select('id', 'first_name', 'last_name', 'surname')
                ->get();
            if ($all_collaborators_raw) {
                foreach ($all_collaborators_raw as $key => $value) {
                    $all_collaborators[$value->id] = $value->first_name . ' ' . $value->last_name;
                }
               
            }
            $event_free_lancers = EventCollaborators::where('event_id', $id)->where('event_collaborator.user_type', 'free_lancer')
                ->join('users', 'users.id', '=', 'event_collaborator.user_id')
                ->select('event_collaborator.*', 'users.first_name', 'users.last_name', 'users.surname')
                ->get();
            $event_get_what_you_sell_member = EventCollaborators::where('event_collaborator.event_id', $id)
                ->join('users', 'users.id', '=', 'event_collaborator.user_id')
                ->leftJoin('collaborators_commissions', 'collaborators_commissions.collaborator_id', '=', 'event_collaborator.user_id')
                ->where('event_collaborator.user_type', 'get_what_you_sell_member')
                ->select('event_collaborator.*', 'users.first_name', 'users.last_name', 'users.surname', DB::raw('SUM(collaborators_commissions.platform_share) as platform_share'), DB::raw('SUM(collaborators_commissions.collaborator_profit) as collaborator_profit'))
                ->groupBy('event_collaborator.user_id')
                ->get();
            $event_commission_based_member = EventCollaborators::where('event_collaborator.event_id', $id)
                ->join('users', 'users.id', '=', 'event_collaborator.user_id')
                ->leftJoin('collaborators_commissions', 'collaborators_commissions.collaborator_id', '=', 'event_collaborator.user_id')
                ->where('event_collaborator.user_type', 'commission_based_member')
                ->select('event_collaborator.*', 'users.first_name', 'users.last_name', 'users.surname', DB::raw('SUM(collaborators_commissions.collaborator_profit) as collaborator_profit'))
                ->groupBy('event_collaborator.user_id')
                ->get();
                $platform_share_data = EventCollaborators::where('event_collaborator.event_id', $id)
                ->join('users', 'users.id', '=', 'event_collaborator.user_id')
                ->leftJoin('collaborators_commissions', 'collaborators_commissions.collaborator_id', '=', 'event_collaborator.user_id')
                ->where('event_collaborator.user_type', 'commission_based_member')
                ->select(DB::raw('SUM(collaborators_commissions.platform_share) as platform_share'),DB::raw('SUM(collaborators_commissions.collaborator_profit) as collaborator_profit'))
                
                ->get();
            $user_event_permisions = ['upload_images', 'delete_images', 'protected_images', 'manage_albums', 'manage_overlay', 'manage_promotions', 'manage_discounts', 'get_what_you_sell', 'commission_based'];
            $event_collaborator = EventCollaborators::where('event_id', $id)->where('user_id', auth()->user()->id)->first();
            if ($event_collaborator) {
                $user_event_permisions = explode(',', $event_collaborator->user_permissions);
            }
            $used_commission = EventCollaborators::where('event_id', $id)->where('event_collaborator.user_type', 'commission_based_member')->sum('commission');
            $remaining_commission = 100 - $used_commission;
            $own_branding = isset($active->package_details['own_branding']) ? $active->package_details['own_branding'] : 0;
            return view('event_management.show', compact('event', 'albums', 'photoDiscountSetting', 'overlay', 'event_free_lancers', 'event_get_what_you_sell_member', 'event_commission_based_member', 'all_collaborators', 'own_branding', 'user_event_permisions', 'event_collaborator', 'remaining_commission','platform_share_data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('status', ['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
    public function destroy($id)
    {
        try {
            $business_id = session()->get('user.business_id');
            $all_photos = EventAlbumPhotos::where('business_id', $business_id)
                ->where('event_id', $id)
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
                EventAlbumPhotos::findOrFail($photo->id)->delete();

            }
            Eventalbums::where('business_id', $business_id)->where('event_id',$id)->delete();
            EventPhotoDiscount::where('business_id', $business_id)->where('event_id',$id)->delete();
            EventCollaborators::where('business_id', $business_id)->where('event_id',$id)->delete();
            OverlayImage::where('business_id', $business_id)->where('event_id',$id)->delete();
            $event = Event::where('business_id', $business_id)->findOrFail($id);
            $event->delete();
            return response()->json(['success' => 1, 'msg' => 'Event deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => 'Failed to delete event!']);
        }
    }
    public function storePhotoDiscountSetting(Request $request)
    {
        try {
            $event_id = session()->get('event_id');
            $business_id = session()->get('user.business_id');
            // Validate the request
            $validatedData = $request->validate([
                'discount_type' => 'required|in:percentage,selfie_bundle',
                'event_id' => 'nullable|integer',
                'x_photos' => 'nullable|integer',
                'percentage_discount' => 'nullable|numeric',
                'total_amount' => 'nullable|numeric',
                'selfie_bundle_amount' => 'nullable|numeric',
                'discount_start_date' => 'nullable|date',
                'discount_end_date' => 'nullable|date|after_or_equal:discount_start_date',
            ]);
            $id = $request->input('discount_id');
            // Check if $id is present to determine store or update operation
            if ($id === null) {
                // Store operation
                $photoDiscountSetting = new EventPhotoDiscount([
                    'business_id' => $business_id,
                    'event_id' => $event_id,
                    'discount_type' => $validatedData['discount_type'],
                    'x_photos' => $validatedData['x_photos'],
                    'percentage_discount' => $validatedData['percentage_discount'],
                    'total_amount' => $validatedData['total_amount'],
                    // 'selfie_bundle_amount' => $validatedData['selfie_bundle_amount'],
                    'discount_start_date' => $validatedData['discount_start_date'],
                    'discount_end_date' => $validatedData['discount_end_date'],
                ]);

                $message = 'Photo discount setting saved successfully!';
            } else {
                // Update operation
                $photoDiscountSetting = EventPhotoDiscount::findOrFail($id);
                $photoDiscountSetting->update([
                    'discount_type' => $validatedData['discount_type'],
                    'x_photos' => $validatedData['x_photos'],
                    'percentage_discount' => $validatedData['percentage_discount'],
                    'total_amount' => $validatedData['total_amount'],
                    // 'selfie_bundle_amount' => $validatedData['selfie_bundle_amount'],
                    'discount_start_date' => $validatedData['discount_start_date'],
                    'discount_end_date' => $validatedData['discount_end_date'],
                ]);

                $message = 'Photo discount setting updated successfully!';
            }

            // Save the photo discount setting to the database
            $photoDiscountSetting->save();

            // Redirect back or to a specific route
            return redirect()->back()->with('status', ['success' => 1, 'msg' => $message]);
        } catch (\Exception $e) {
            return redirect()->back()->with('status', ['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
    public function addFreelancer(Request $request)
    {
        try {
            // dd($request);
            $event_id = session()->get('event_id');
            $business_id = session()->get('user.business_id');
            // Validate the request used_commission
            $validatedData = $request->validate([
                'free_lancer' => 'required|integer',
                'event_id' => 'nullable|integer',
                'event_commission' => 'nullable|integer',
                'used_commission' => 'nullable',
            ]);
            if (($validatedData['used_commission'] + $validatedData['event_commission']) > 100) {
                return redirect()->back()->with('status', ['success' => 0, 'msg' => 'Total photographers commission can not be more than 100%']);
            }
            $EventFreeLanceUsers = new EventFreeLanceUsers([
                'event_id' => $validatedData['event_id'],
                'user_id' => $validatedData['free_lancer'],
                'commission' => ($validatedData['event_commission']) ? $validatedData['event_commission'] : 0,
            ]);


            // Save the photo discount setting to the database
            $EventFreeLanceUsers->save();

            // Redirect back or to a specific route
            $message = 'Added and invitation sent';
            return redirect()->back()->with('status', ['success' => 1, 'msg' => $message]);
        } catch (\Exception $e) {
            return redirect()->back()->with('status', ['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
    public function addAffiliate(Request $request)
    {
        try {
            $event_id = session()->get('event_id');
            $business_id = session()->get('user.business_id');
            // Validate the request
            $validatedData = $request->validate([
                'affiliate' => 'required|integer',
                'event_id' => 'nullable|integer',
                'used_commission' => 'nullable',
            ]);
            $cmmsn_percent = User::where('id', $validatedData['affiliate'])->first()->cmmsn_percent;
            if (($validatedData['used_commission'] + $cmmsn_percent) > 100) {
                return redirect()->back()->with('status', ['success' => 0, 'msg' => 'Total photographers commission can not be more than 100%']);
            }
            $EventAffiliateUsers = new EventAffiliateUsers([
                'event_id' => $validatedData['event_id'],
                'user_id' => $validatedData['affiliate'],
                'commission' => 0,
            ]);


            // Save the photo discount setting to the database
            $EventAffiliateUsers->save();

            // Redirect back or to a specific route
            $message = 'Invitation sent!';
            return redirect()->back()->with('status', ['success' => 1, 'msg' => $message]);
        } catch (\Exception $e) {
            return redirect()->back()->with('status', ['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
    // public function uploadCover(Request $request)
    // {
    //     if ($request->hasFile('event_cover')) {
    //         $cover = $request->file('event_cover');
    //         $filename = time() . '.' . $cover->getClientOriginalExtension();

    //         // Store the file in the 'public' disk, under the 'images' directory
    //         $path = $cover->storeAs('uploads', $filename, 'public');

    //         // Generate the full URL of the image
    //         $imageUrl = asset('storage/images/' . $filename);

    //         // Now you have your file in storage/app/public/images folder
    //         // You can return a response here
    //         return response()->json(['message' => 'File uploaded successfully', 'filename' => $filename, 'url' => $imageUrl]);
    //     }

    //     return response()->json(['message' => 'No file uploaded']);
    // }
    public function uploadCover(Request $request)
    {
        if ($request->hasFile('event_cover') && $request->file('event_cover')->isValid()) {
            $cover = $request->file('event_cover');

            // Optional: Add file type and size validation here if needed
            // if ($cover->getClientMimeType() != 'image/jpeg') {
            //     return response()->json(['message' => 'Invalid file type']);
            // }

            $filename = time() . '.' . $cover->getClientOriginalExtension();

            try {
                $cover->move(public_path('uploads'), $filename);

                // Generate the full URL of the image
                $imageUrl = asset('uploads/' . $filename);

                return response()->json(['message' => 'File uploaded successfully', 'filename' => $filename, 'url' => $imageUrl]);
            } catch (\Exception $e) {
                return response()->json(['message' => 'File upload failed', 'error' => $e->getMessage()]);
            }
        }

        return response()->json(['message' => 'No file uploaded']);
    }
    public function addCollaborator(Request $request)
    {
        try {
            if ($request->event_collaborator_id == '') {
                $validatedData = $request->validate([
                    'collaborator_id' => 'required|integer',
                    'user_type' => 'required|string',
                    'event_id' => 'required|integer',
                    'user_permissions' => 'required|array',
                ]);
                $user_permissions = implode(',', $validatedData['user_permissions']);
                $commission = 0.0;
                if ($request->commission) {
                    $commission = $request->commission;
                }
                $EventCollaborators = new EventCollaborators([
                    'business_id' => session()->get('user.business_id'),
                    'event_id' => $validatedData['event_id'],
                    'user_type' => $validatedData['user_type'],
                    'user_permissions' => $user_permissions,
                    'user_id' => $validatedData['collaborator_id'],
                    'commission' => $commission,
                ]);
                $EventCollaborators->save();
                return redirect()->back()->with('status', ['success' => 1, 'msg' => 'Collaborator added successfully!']);
            } else {
                $validatedData = $request->validate([
                    'event_collaborator_id' => 'required|integer',
                    'event_id' => 'required|integer',
                    'user_permissions' => 'required|array',
                ]);
                $EventCollaborators = EventCollaborators::where('business_id', session()->get('user.business_id'))
                    ->where('event_id', $validatedData['event_id'])
                    ->where('id', $validatedData['event_collaborator_id'])
                    ->first();
                $user_permissions = implode(',', $request->user_permissions);
                $commission = 0.0;
                if ($request->commission) {
                    $commission = $request->commission;
                }
                $EventCollaborators->update([
                    'user_permissions' => $user_permissions,
                    'commission' => $commission,
                ]);
                return redirect()->back()->with('status', ['success' => 1, 'msg' => 'Collaborator updated successfully!']);
            }
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->with('status', ['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
    // removeCollaborator
    public function removeCollaborator($event_id, $user_id)
    {
        try {
            // dd($event_id,$collaborator_id);
            $business_id = session()->get('user.business_id');
            $EventCollaborators = EventCollaborators::where('business_id', $business_id)
                ->where('event_id', $event_id)
                ->where('id', $user_id)
                ->first();
            if ($EventCollaborators->user_type != 'get_what_you_sell_member') {
                $EventCollaborators->delete();
                return redirect()->back()->with('status', ['success' => 1, 'msg' => 'Collaborator removed successfully!']);
            } else {
                $col_id = $EventCollaborators->user_id;
                $all_photos = EventAlbumPhotos::where('business_id', $business_id)
                    ->where('event_id', $event_id)
                    ->where('created_by', $col_id)
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
                    EventAlbumPhotos::findOrFail($photo->id)->delete();

                }


                $EventCollaborators->delete();
                return redirect()->back()->with('status', ['success' => 1, 'msg' => 'Collaborator removed successfully!']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('status', ['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
    public function getCollaborator($event_id, $user_id)
    {
        $business_id = session()->get('user.business_id');
        $collaborator = EventCollaborators::where('business_id', $business_id)
            ->where('event_id', $event_id)
            ->where('id', $user_id)->first();

        // Return the collaborator details as JSON
        return response()->json([
            'collaborator' => $collaborator,
            'permissions' => explode(',', $collaborator->user_permissions),
        ]);
    }

}


