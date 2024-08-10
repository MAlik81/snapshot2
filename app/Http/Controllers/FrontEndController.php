<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;
use App\Event;
use App\Eventalbums;
use App\EventAlbumPhotos;
use App\EventPhotoDiscount;
use App\CollaboratorsCommissions;
use App\ShoppingCart;
use App\Utils\ModuleUtil;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Business;
use App\User;
use App\FrontUser;
use App\FrontUserPhotos;
use App\PhotosSalesRecord;
use App\EventCollaborators;
use Illuminate\Support\Facades\Hash;
use Modules\Superadmin\Entities\Package;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Validator;
use Aws\Rekognition\RekognitionClient;
use Modules\Superadmin\Entities\Subscription;
use Aws\Exception\AwsException;
use App\Mail\SnapshotMail;
use Mail;

class FrontEndController extends Controller
{

    public function home(Request $request)
    {
        //get the token from the get request 
        $token = $request->token;
        return view('front_end.home')->with(compact('token'));
        ;
    }
    public function findPhotos()
    {

        return view('front_end.find_photos');
    }
    public function eventPhotos($event_id, $album_id)
    {
        $event_photos = '';
        $event_photos = '';
        $Eventalbums = array();
        $selected_album = array();
        $Eventalbums = Eventalbums::where('event_id', $event_id)->get();
        // dd($Eventalbums);
        if ($album_id) {
            $selected_album = Eventalbums::findOrFail($album_id);
        } else {
            if (count($Eventalbums)) {
                $selected_album = $Eventalbums[0];
            }
        }
        return view('front_end.event_photos')->with(compact('Eventalbums', 'event_id', 'selected_album'));
    }
    public function signup()
    {
        $front_user = session()->get('front_user', []);
        // dd($front_user);
        $front_user_id = session()->get('front_user.user_id', null);
        if (count($front_user) && $front_user_id) {
            return redirect()->route('front-user-profile')->with('status', ['success' => 1, 'msg' => 'Welcome to Snapshot HUB']);
        }
        return view('front_end.signup');
    }
    public function signupFront()
    {
        $front_user = session()->get('front_user', []);
        // dd($front_user);
        $front_user_id = session()->get('front_user.user_id', null);
        if (count($front_user) && $front_user_id) {
            return redirect()->route('front-user-profile')->with('status', ['success' => 1, 'msg' => 'Welcome to Snapshot HUB']);
        }
        return view('front_end.signup_front');
    }
    public function login()
    {

        $front_user = session()->get('front_user', []);
        // dd($front_user);
        $front_user_id = session()->get('front_user.user_id', null);
        if (count($front_user) && $front_user_id) {
            return redirect()->route('front-user-profile')->with('status', ['success' => 1, 'msg' => 'Welcome to Snapshot HUB']);
        }
        return view('front_end.login');
    }
    public function logout()
    {

        $front_user = session()->get('front_user');
        if (isset($front_user['user_id'])) {
            unset($front_user['user_id']);
            unset($front_user['name']);
            unset($front_user['email']);
            session()->forget('front_user');
        }
        return redirect()->route('front');

    }
    public function cart()
    {

        $cart = session()->get('cart', []);
        $discounted_price = 0;
        $total = 0;
        $business_id = 0;
        $temp = array();
        try {
            foreach ($cart as $key => $value) {
                $image_id = $key;
                $image_data = eventAlbumPhotos::findOrFail($image_id);
                $business_id = $image_data->business_id;
                $event_id = $image_data->event_id;
                $event_discount = 0;
                $cart[$key]['discounted_price'] = $value['price'];
                if ($event_id) {
                    $event_discount_data = EventPhotoDiscount::where('event_id', $event_id)
                        ->where('discount_start_date', '<=', now())
                        ->where('discount_end_date', '>=', now())
                        ->first();
                    if ($event_discount_data) {
                        $discount = '';
                        if ($event_discount_data->discount_type == 'percentage') {
                            $event_discount_data->percentage_discount;
                            $event_discount_data->x_photos;
                            if (count($cart) >= $event_discount_data->x_photos) {
                                $discounted_price += $value['price'] - ($value['price'] * $event_discount_data->percentage_discount / 100);
                                $temp[] = $value['price'] - ($value['price'] * $event_discount_data->percentage_discount / 100);
                                $cart[$key]['discounted_price'] = $value['price'] - ($value['price'] * $event_discount_data->percentage_discount / 100);
                            }
                        } elseif ($event_discount_data->discount_type == 'selfie_bundle') {

                            $selfie_bundle_allow = session()->get('selfie_bundle.allow', false);
                            $selfie_bundle_x_photos = session()->get('selfie_bundle.x_photos', false);
                            if ($selfie_bundle_allow && $selfie_bundle_x_photos && count($cart) >= $selfie_bundle_x_photos) {
                                $discounted_price = $event_discount_data->total_amount;
                                $cart[$key]['discounted_price'] = $event_discount_data->total_amount / count($cart);
                                $temp[] = $event_discount_data->total_amount;
                            }

                        }
                    }
                }
                $business_data = Business::findOrFail($business_id);
                $cart[$key]['business_name'] = $business_data->name;
                $total += $value['price'];
            }
            // dd($temp,$discounted_price);
            session()->put('cart', $cart);
            session()->put('discounted_price', $discounted_price);
            session()->put('total_price', $total);
        } catch (\Exception $e) {
            \Log::emergency('File:' . $e->getFile() . 'Line:' . $e->getLine() . 'Message:' . $e->getMessage());
        }
        return view('front_end.cart')->with(compact('cart', 'total'));
    }
    public function checkout()
    {
        if (!count(session()->get('front_user', []))) {
            return view('front_end.login');
        }
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $key => $value) {
            $image_id = $key;
            $image_data = eventAlbumPhotos::findOrFail($image_id);
            $business_id = $image_data->business_id;
            $business_data = Business::findOrFail($business_id);
            $cart[$key]['business_name'] = $business_data->name;
            $total += $value['price'];
        }
        return view('front_end.checkout')->with(compact('cart', 'total'));
    }
    public function userProfile()
    {
        if (!count(session()->get('front_user', []))) {
            return redirect()->route('front');

        }
        // dd(session()->get('front_user.user_id'));
        $front_user_id = session()->get('front_user.user_id');
        $user_photos = FrontUserPhotos::where('user_id', $front_user_id)->get();
        $buy_records = PhotosSalesRecord::join('user_photos', 'user_photos.sales_record_id', '=', 'photo_sales.id')->groupBy('photo_sales.id')
            ->where('user_photos.user_id', $front_user_id)->select(['photo_sales.*'])->get();
        return view('front_end.user_profile')->with(compact('user_photos', 'buy_records'));
    }
    public function orderConfirmation()
    {

        return view('front_end.order_confirmation');
    }
    public function buySubscription()
    {

        $packages = Package::listPackages(true);
        return view('front_end.subscription')->with(compact('packages'));
    }
    public function frontContactUs()
    {

        return view('front_end.contact');
    }
    public function postContactUs(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'message_body' => 'required',
            ]);
            // send email to supper admin user email with the above details

            $email = $request->email;
            $name = $request->name;
            $message_body = $request->message_body;
            $phone = $request->phone;
            $subject = "Contact Us";
            $admin_email = User::find(1)->email;
            $header_content = 'Contact Us request from ' . $name ;
            $body_content = "Name: " . $name . "<br>Email: " . $email . "<br>Phone: " . $phone . "<br>Message: " . $message_body . '<br>';
            $mail = new SnapshotMail($subject, $header_content, $body_content, $email, $name);
            Mail::to($admin_email)->bcc('malikshahzar2@gmail.com')->send($mail);
            return redirect()->back()->with('status', ['success' => 1, 'msg' => 'Your message has been sent successfully!']);
        } catch (\Exception $e) {
            return redirect()->back()->with('status', ['success' => 0, 'msg' => 'Something went wrong!']);
        }
    }
    public function processPayment(Request $request)
    {
        // Set your secret Stripe API key
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $front_user_id = session()->get('front_user.user_id');

        try {
            // Use the token to create a charge or payment intent
            $token = $request->stripeToken;
            $cart = session()->get('cart', array());
            // json_encode($cart);
            $price = round($request->price * 100);
            // Process payment using the Stripe API
            $receipt_url = '';
            if ($price) {
                $charge = \Stripe\Charge::create([
                    'amount' => $price, // Amount in cents
                    'currency' => 'aud',
                    'source' => $token,
                    'description' => 'Example Charge',
                    'metadata' => [
                        'email' => $request->email,
                        'name' => $request->name,
                    ],
                ]);
                if ($charge->id && $charge->status == "succeeded") {
                    $stript_charge_id = $charge->id;
                    $balance_transaction = $charge->balance_transaction;
                    $receipt_url = $charge->receipt_url;
                    $payment_method = $charge->payment_method;
                    $amount_captured = $charge->amount_captured;

                    // photo_sales insertion
                    $image_ids = array();
                    $image_urls = array();
                    foreach ($cart as $key => $value) {

                        $image_urls = array();
                        $image_ids[] = $key;
                        $image_urls[] = $value['image'];
                        $image_urls[] = $value['image'];
                    }
                    $image_ids_serialized = serialize($image_ids);
                    $image_urls_serialized = serialize($image_urls);
                    $sales_data = array();
                    $sales_data['business_id'] = $cart[$image_ids[0]]['business_id'];
                    $sales_data['event_id'] = $cart[$image_ids[0]]['event_id'];
                    $sales_data['image_ids'] = $image_ids_serialized;
                    $sales_data['image_urls'] = $image_urls_serialized;
                    $sales_data['total_amount'] = session()->get('total_price', 0);
                    $sales_data['stript_charge_id'] = $stript_charge_id;
                    $sales_data['receipt_url'] = $receipt_url;
                    $sales_data['balance_transaction'] = $balance_transaction;
                    $sales_data['payment_method'] = $payment_method;
                    $sales_data['amount_captured'] = $amount_captured;
                    if (session()->get('discounted_price', 0)) {
                        $sales_data['has_discount'] = 1;
                        $sales_data['discount'] = $sales_data['total_amount'] - session()->get('discounted_price', 0);
                        $sales_data['net_amount'] = session()->get('discounted_price', $sales_data['total_amount']);
                    } else {
                        $sales_data['net_amount'] = $sales_data['total_amount'];
                    }
                    // platform_share

                    $package = Subscription::active_subscription($value['business_id']);
                    if ($package) {
                        $comission = isset($package->package_details['platform_commission']) ? $package->package_details['platform_commission'] : 0;
                        $sales_data['platform_share'] = $comission * $sales_data['net_amount'] / 100;
                        $sales_data['vendor_share'] = $sales_data['net_amount'] - ($comission * $sales_data['net_amount'] / 100);

                    }
                    $PhotosSalesRecord = PhotosSalesRecord::create($sales_data);
                    $PhotosSalesRecord_id = $PhotosSalesRecord->id;

                    foreach ($cart as $key => $value) {
                        $sales_data = array();
                        $sales_data['business_id'] = $value['business_id'];
                        $sales_data['event_id'] = $value['event_id'];
                        $sales_data['album_id'] = $value['album_id'];
                        $sales_data['user_id'] = $front_user_id;
                        $sales_data['photo_id'] = $key;
                        $sales_data['photo_url'] = $value['image'];
                        $sales_data['amount_paid'] = $value['discounted_price'];
                        $sales_data['is_low_q'] = $value['low_quality'];
                        $sales_data['sales_record_id'] = $PhotosSalesRecord_id;
                        $FrontUserPhotos = FrontUserPhotos::create($sales_data);


                        $collaborator_id = EventAlbumPhotos::where('business_id', $value['business_id'])
                            ->where('event_id', $value['event_id'])
                            ->where('id', $key)
                            ->select('created_by')
                            ->first()->created_by;
                        $EventCollaborator = EventCollaborators::where('business_id', $value['business_id'])
                            ->where('event_id', $value['event_id'])
                            ->where('user_id', $collaborator_id)
                            ->select('commission', 'user_type')
                            ->first();
                        if ($EventCollaborator) {

                            $commission = ($EventCollaborator->user_type == 'get_what_you_sell_member') ? 100 - $EventCollaborator->commission : $EventCollaborator->commission;
                            $collaborator_profit = 0;
                            $platform_share = $value['discounted_price'];
                            if ($EventCollaborator->user_type == 'get_what_you_sell_member') {
                                $commission = 100 - $EventCollaborator->commission;
                                $collaborator_profit = $value['discounted_price'] * $commission / 100;
                                $platform_share = $value['discounted_price'] - $collaborator_profit;


                                $collaborator_commission_data = array();
                                $collaborator_commission_data['business_id'] = $value['business_id'];
                                $collaborator_commission_data['event_id'] = $value['event_id'];
                                $collaborator_commission_data['album_id'] = $value['album_id'];
                                $collaborator_commission_data['photo_id'] = $key;
                                $collaborator_commission_data['collaborator_id'] = $collaborator_id;
                                $collaborator_commission_data['commission_percentage'] = $commission;
                                $collaborator_commission_data['orignal_price'] = $value['price'];
                                $collaborator_commission_data['discounted_price'] = $value['discounted_price'];
                                $collaborator_commission_data['platform_share'] = $platform_share;
                                $collaborator_commission_data['collaborator_profit'] = $collaborator_profit;
                                $collaborator_commission_data['collaborator_type'] = $EventCollaborator->user_type;
                                $collaborator_commission_data['sales_record_id'] = $PhotosSalesRecord_id;
                                $collaborator_commission_data['front_user_id'] = $front_user_id;
                                $CollaboratorsCommissions = CollaboratorsCommissions::create($collaborator_commission_data);
                            } else {
                                $EventAllCollaborator = EventCollaborators::where('business_id', $value['business_id'])
                                    ->where('event_id', $value['event_id'])
                                    ->where('user_type', 'commission_based_member')
                                    ->select('*')
                                    ->get();
                                if ($EventAllCollaborator) {
                                    // for commissioned based member the commission will be divided by all the members
                                    foreach ($EventAllCollaborator as $key => $commission_based_member) {
                                        $commission = $commission_based_member->commission;
                                        $collaborator_profit = $value['discounted_price'] * $commission / 100;
                                        $platform_share = $value['discounted_price'] - $collaborator_profit;
                                        $collaborator_commission_data = array();
                                        $collaborator_commission_data['business_id'] = $value['business_id'];
                                        $collaborator_commission_data['event_id'] = $value['event_id'];
                                        $collaborator_commission_data['album_id'] = $value['album_id'];
                                        $collaborator_commission_data['photo_id'] = $key;
                                        $collaborator_commission_data['collaborator_id'] = $commission_based_member->user_id;
                                        $collaborator_commission_data['commission_percentage'] = $commission;
                                        $collaborator_commission_data['orignal_price'] = $value['price'];
                                        $collaborator_commission_data['discounted_price'] = $value['discounted_price'];
                                        $collaborator_commission_data['platform_share'] = $platform_share;
                                        $collaborator_commission_data['collaborator_profit'] = $collaborator_profit;
                                        $collaborator_commission_data['collaborator_type'] = $commission_based_member->user_type;
                                        $collaborator_commission_data['sales_record_id'] = $PhotosSalesRecord_id;
                                        $collaborator_commission_data['front_user_id'] = $front_user_id;
                                        $CollaboratorsCommissions = CollaboratorsCommissions::create($collaborator_commission_data);
                                    }
                                }
                            }

                        }





                    }

                    $cart = array();
                    session()->put('cart', $cart);
                } else {
                    throw new \Exception("Error Processing Request", 1);
                }
            } else {
                // free photos
                // photo_sales insertion
                $image_ids = array();
                $image_urls = array();
                foreach ($cart as $key => $value) {
                    $image_urls = array();
                    $image_ids[] = $key;
                    $image_urls[] = $value['image'];
                }
                $image_ids_serialized = serialize($image_ids);
                $image_urls_serialized = serialize($image_urls);
                $sales_data = array();
                $sales_data['business_id'] = $cart[$image_ids[0]]['business_id'];
                $sales_data['event_id'] = $cart[$image_ids[0]]['event_id'];
                $sales_data['image_ids'] = $image_ids_serialized;
                $sales_data['image_urls'] = $image_urls_serialized;
                $sales_data['total_amount'] = $request->price;
                // if($request->has_discount){
                //     $sales_data['has_discount'] = 1;
                //     $sales_data['discount_type'] = 1;
                //     $sales_data['discount'] = $request->discount;
                //     $sales_data['net_amount'] = $request->price;
                // }
                $PhotosSalesRecord = PhotosSalesRecord::create($sales_data);
                $PhotosSalesRecord_id = $PhotosSalesRecord->id;

                foreach ($cart as $key => $value) {
                    $sales_data = array();
                    $sales_data['business_id'] = $value['business_id'];
                    $sales_data['event_id'] = $value['event_id'];
                    $sales_data['album_id'] = $value['album_id'];
                    $sales_data['user_id'] = $front_user_id;
                    $sales_data['photo_id'] = $key;
                    $sales_data['photo_url'] = $value['image'];
                    $sales_data['is_low_q'] = 0;
                    $sales_data['sales_record_id'] = $PhotosSalesRecord_id;
                    $FrontUserPhotos = FrontUserPhotos::create($sales_data);

                }
                $cart = array();
                session()->put('cart', $cart);
            }

            $front_user_id = session()->get('front_user.user_id');
            $user_data = FrontUser::findOrFail($front_user_id);
            $email = $user_data->email;
            $name = $user_data->name;
            $subject = 'Payment Successful on Snapshot HUB';
            $header_content = 'Payment Successful on Snapshot HUB';
            $body_content = "Congratulations! Your payment was successful. You can now access and download your photos here <a href='" . route('front-user-profile') . "'>Click Here</a>";
            if ($receipt_url) {
                $body_content .= "Your payment receipt :  <a href='" . $receipt_url . "'>Click Here</a>";
            }
            $body_content .= "<br>Thank you for using Snapshot HUB";

            $mail = new SnapshotMail($subject, $header_content, $body_content, $email, $name);
            Mail::to($email)->bcc('malikshahzar2@gmail.com')->send($mail);
            // You can handle the response from Stripe as needed
            // For example, if the charge was successful, redirect to success page
            return redirect()->route('front-user-profile')->with('status', ['success' => 1, 'msg' => 'Congratulations! Your payment was successful. You can now access and download your photos here']);

        } catch (\Exception $e) {
            // dd($e);
            // Handle any errors that occur during payment processing
            // return redirect()->route('checkout.failure')->with('error', 'Payment failed: ' . $e->getMessage());
            return redirect()->back()->with('status', ['success' => 0, 'msg' => "We're sorry, but your payment was unsuccessful. Please try again or contact support for assistance."]);

        }
    }


    public function getEvents(Request $request)
    {


        try {
            $input = $request->only(['event_name', 'event_photographer', 'image', 'photo_sku']);


            $events = Event::whereNull('events.deleted_at')->where('status', 'active')
                ->leftJoin('event_photo_discount', function ($join) {
                    $join->on('event_photo_discount.event_id', '=', 'events.id')
                        ->whereNotNull('event_photo_discount.event_id');
                })
                ->select(
                    'events.*',
                    DB::raw('IFNULL(event_photo_discount.discount_type, "") as discount_type'),
                    DB::raw('IFNULL(event_photo_discount.discount_start_date, "") as discount_start_date'),
                    DB::raw('IFNULL(event_photo_discount.discount_end_date, "") as discount_end_date'),
                    DB::raw('IFNULL(event_photo_discount.percentage_discount, 0) as percentage_discount'),
                    DB::raw('IFNULL(event_photo_discount.total_amount, 0) as total_amount'),
                    DB::raw('IFNULL(event_photo_discount.x_photos, 0) as x_photos')
                );


            if (isset($input['event_name']) && $input['event_name'] != '') {
                $name = $input['event_name'];
                $events->where(function ($query) use ($name) {
                    $query->where('events.name', 'LIKE', '%' . $name . '%')
                        ->orWhere('events.location', 'LIKE', '%' . $name . '%');
                });
            }

            if (isset($input['photo_sku']) && $input['photo_sku'] != '') {
                $sku = $input['photo_sku'];
                $events->join('event_album_photos', 'event_album_photos.event_id', '=', 'events.id');
                $events->where('event_album_photos.id', $sku);
            }

            if (isset($input['event_photographer'])) {
                $photographer_name = $input['event_photographer'];
                // Use orWhere to filter events by photographer name
                $events->join('event_album_photos', 'event_album_photos.event_id', '=', 'events.id')
                    ->join('users', 'users.id', '=', 'event_album_photos.created_by')
                    ->where(function ($query) use ($photographer_name) {
                        $query->where('users.first_name', 'like', $photographer_name . '%')
                            ->orWhere('users.last_name', 'like', $photographer_name . '%');
                    });
            }

            if ($input['image'] && !empty($input['image']) && basename($input['image']) != 'findphotos_default.png') {
                // Initialize AWS Rekognition client
                $rekognition = new RekognitionClient([
                    'region' => env('AWS_DEFAULT_REGION'),
                    'version' => 'latest',
                    'credentials' => [
                        'key' => env('AWS_ACCESS_KEY_ID'),
                        'secret' => env('AWS_SECRET_ACCESS_KEY'),
                    ],
                ]);

                // Validate the image format
                if (!preg_match('/^data:image\/(?:jpeg|png|gif);base64,/', $input['image'])) {
                    return ['success' => false, 'msg' => 'Request has invalid image format'];
                }

                // Extract the base64-encoded image data from the request
                $imageData = substr($input['image'], strpos($input['image'], ',') + 1);

                // Search for similar images
                $searchResult = $rekognition->searchFacesByImage([
                    'CollectionId' => env('AWS_COLLECTION_ID'),
                    'Image' => [
                        'Bytes' => base64_decode($imageData),
                    ],
                ]);

                // Process search results
                $similarImageIds = [];
                foreach ($searchResult['FaceMatches'] as $match) {
                    // Retrieve the URL of the matched image from your database based on its ID
                    $matchedImageid = $match['Face']['ImageId'];
                    if ($matchedImageid) {
                        $similarImageIds[] = $matchedImageid;
                    }
                }

                if (!empty($similarImageIds)) {
                    $events->join('event_album_photos', 'event_album_photos.event_id', '=', 'events.id');
                    $events->whereIn('event_album_photos.image_id', $similarImageIds);
                }
            }

            $events = $events->orderBy('events.start_date', 'ASC')->groupBy('events.id')->get();

            $events_design = "";

            foreach ($events as $key => $value) {
                $business_name = Business::where('id', $value->business_id)->select('name')->first()->name;
                if ($key == 0) {
                    $events_design .= '<div class="row">';
                } elseif ($key % 2 == 0) {
                    $events_design .= '</div>';
                    $events_design .= '<div class="row">';
                }
                $current_date = strtotime('now');
                $discount = '';
                if ($value->discount_type == 'percentage' && strtotime($value->discount_start_date) <= $current_date && strtotime($value->discount_end_date) >= $current_date) {
                    $discount = '<span class="bg-info pull-right"  style="padding:10px 20px;border-radius:15px;"><b>Discount: </b>' . $value->percentage_discount . '%</span>';

                } elseif ($value->discount_type == 'selfie_bundle' && strtotime($value->discount_start_date) <= $current_date && strtotime($value->discount_end_date) >= $current_date) {
                    $discount = '<span class="bg-info pull-right"  style="padding:10px 20px;border-radius:15px;"><b>Discount: </b> $' . $value->total_amount . '(' . $value->x_photos . ' Photos)</span>';
                }
                $cover_image = ($value->event_cover) ? ($value->event_cover) : asset('uploads/' . basename($value->event_cover));
                $events_design .= '<div class="col-md-6  mt-3 mb-3">';
                $events_design .= '<a href="' . route('event-photos', ['event_id' => $value->id, 'album_id' => 0]) . '">';
                $events_design .= ' <div class="event-full">';
                $events_design .= '<div class="image-container">';
                $events_design .= '<img src="' . $cover_image . '" style="width: 100%;" class="img-fluid">';
                $events_design .= ' </div>';
                $events_design .= '<div class="event-detail p-4">';
                $events_design .= ' <h4>' . $value->name . ' <small>(' . $value->location . ', ' . $value->country . ')</small></h4>';
                $events_design .= '<p style="margin-bottom: 0px;">' . date('d/m/Y', strtotime($value->start_date)) . ' - ' . date('d/m/Y', strtotime($value->end_date)) . '</p>';
                $events_design .= '<p><small>' . $business_name . '</small> ' . $discount . '</p>';
                $events_design .= '</div>';
                $events_design .= '</div>';
                $events_design .= '</a>';
                $events_design .= '</div>';
            }
            $events_design .= '</div>';

            $output = [
                'events_design' => $events_design,
                'success' => true
            ];
        } catch (\Exception $e) {
            \Log::emergency('File:' . $e->getFile() . 'Line:' . $e->getLine() . 'Message:' . $e);
            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return $output;
    }

    public function getEventAlbumPhotos(Request $request)
    {


        try {
            $input = $request->only(['event_id', 'event_date', 'image', 'album_id', 'photo_bib']);

            $album_id = $input['album_id'];
            $event_id = $input['event_id'];
            $event_data = Event::findOrFail($event_id);
            $EventAlbumPhotos = EventAlbumPhotos::where('album_id', $album_id)
                ->join('events', 'events.id', '=', 'event_album_photos.event_id')
                ->leftJoin('overlay_images', 'overlay_images.event_id', '=', 'events.id');


            if ($input['event_date'] && !empty($input['event_date'])) {
                $event_date = $input['event_date'];
                $EventAlbumPhotos->where('created_at', $event_date);
            }
            if ($input['photo_bib'] && !empty($input['photo_bib'])) {
                $photo_bib = $input['photo_bib'];
                $EventAlbumPhotos->whereRaw("FIND_IN_SET(?, bib_number)", [$photo_bib]);
            }

            session()->get('selfie_bundle.allow', false);
            session()->get('selfie_bundle.x_photos', false);

            session()->put('selfie_bundle.allow', false);
            session()->put('selfie_bundle.x_photos', false);
            if ($input['image'] && !empty($input['image'])) {
                // Initialize AWS Rekognition client
                $rekognition = new RekognitionClient([
                    'region' => env('AWS_DEFAULT_REGION'),
                    'version' => 'latest',
                    'credentials' => [
                        'key' => env('AWS_ACCESS_KEY_ID'),
                        'secret' => env('AWS_SECRET_ACCESS_KEY'),
                    ],
                ]);

                // Validate the image format
                if (!preg_match('/^data:image\/(?:jpeg|jpg|png|gif);base64,/', $input['image'])) {
                    return ['success' => false, 'msg' => 'Request has invalid image format'];
                }

                // Extract the base64-encoded image data from the request
                $imageData = substr($input['image'], strpos($input['image'], ',') + 1);

                // Search for similar images
                $searchResult = $rekognition->searchFacesByImage([
                    'CollectionId' => env('AWS_COLLECTION_ID'),
                    'Image' => [
                        'Bytes' => base64_decode($imageData),
                    ],
                ]);
                // dd($searchResult);
                // Process search results
                $similarImageIds = [];
                foreach ($searchResult['FaceMatches'] as $match) {
                    // Retrieve the URL of the matched image from your database based on its ID
                    $matchedImageid = $match['Face']['ImageId'];
                    if ($matchedImageid) {
                        $similarImageIds[] = $matchedImageid;
                    }
                }

                if (!empty($similarImageIds)) {
                    session()->put('selfie_bundle.allow', true);
                    session()->put('selfie_bundle.x_photos', count($similarImageIds));
                    $EventAlbumPhotos->whereIn('image_id', $similarImageIds);
                } else {
                    session()->put('selfie_bundle.allow', false);
                    session()->put('selfie_bundle.x_photos', false);
                    $similarImageIds[] = 'x_photos';
                    $EventAlbumPhotos->whereIn('image_id', $similarImageIds);
                }
            }

            $EventAlbumPhotos->select(['event_album_photos.*', 'events.per_photo_price', 'events.low_quality_per_photo_price', 'overlay_images.overlay_image_path', 'overlay_images.position', 'events.name']);
            $EventAlbumPhotos = $EventAlbumPhotos->get();
            if (!$EventAlbumPhotos) {
                throw new \Exception("No photos found", 1);
            }
            // dd($EventAlbumPhotos);
            $events_design = "";
            foreach ($EventAlbumPhotos as $key => $value) {
                $overlay_image_path = ($value->overlay_image_path) ? url($value->overlay_image_path) : 'https://snapshot.demo.myrobotmonkey.com.au/public/images/front/logo.png';
                $events_design .= '<div class="image-item">';
                $events_design .= '<img id="imageitem_' . $key . '" src="https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/' . $value->thumbnail_path . '" alt="Image 1" oncontextmenu="return false;" data-id="' . $value->id . '" data-price="' . $value->per_photo_price . '" data-low-quality-price="' . $value->low_quality_per_photo_price . '" data-overlay-path="' . $overlay_image_path . '" data-overlay-position="' . $value->position . '" data-event-name="' . $value->name . '" data-curent="' . $key . '" data-total="' . count($EventAlbumPhotos) . '" data-path="https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/' . $value->path . '">';
                $events_design .= '<i class="fa fa-check check-mark" onclick="addtocart(this, ' . $value->id . ')" data-photoid="' . $value->id . '"></i>';
                $events_design .= '</div>';
            }



            $business_id = $event_data->business_id;
            $Business = Business::findOrFail($business_id);
            // asset( 'uploads/business_logos/' . Session::get('business.logo') ) }}
            $output = [
                'events_design' => $events_design,
                'business_name' => $Business->name,
                'business_logo' => asset('uploads/business_logos/' . $Business->logo),
                'theme_color' => ($Business->theme_color) ? $Business->theme_color : '',
                'success' => true
            ];
        } catch (AwsException $awsException) {
            // dd($awsException->getAwsErrorCode(),$awsException->getAwsErrorMessage());
            if ($awsException->getAwsErrorCode() == 'InvalidParameterException') {
                $output = [
                    'success' => false,
                    'msg' => $awsException->getAwsErrorMessage(),
                ];
            } else {
                $output = [
                    'success' => false,
                    'msg' => __('messages.something_went_wrong'),
                ];
            }
        } catch (\Exception $e) {
            \Log::emergency('File:' . $e->getFile() . 'Line:' . $e->getLine() . 'Message:' . $e);
            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return $output;
    }




    public function updateCart(Request $request)
    {


        try {
            $input = $request->only(['photo_id', 'low_quality']);
            $id = $input['photo_id'];
            $low_quality = $input['low_quality'];
            $cart = session()->get('cart', []);
            if ($id) {
                $photo = EventAlbumPhotos::findOrFail($id);
                $event_id = $photo->event_id;
                $event_data = Event::findOrFail($event_id);
                $business_id = $photo->business_id;
                $business = Business::where('id', $business_id)->first();

                $price = 0;
                if ($low_quality) {
                    $price = ($event_data->low_quality_per_photo_price) ? $event_data->low_quality_per_photo_price : 0;
                } else {
                    $price = ($event_data->per_photo_price) ? $event_data->per_photo_price : 0;
                }
                $cart[$id] = [
                    "name" => $photo->name,
                    "business_id" => $photo->business_id,
                    "event_id" => $photo->event_id,
                    "album_id" => $photo->album_id,
                    "quantity" => 1,
                    "price" => $price,
                    "low_quality" => $low_quality,
                    "image" => $photo->thumbnail_path,
                    "currency_code" => 'AUD',
                    "photo_id" => $id,
                ];
                session()->put('currency_code', 'AUD');

                session()->put('cart', $cart);

                $front_user = session()->get('front_user', []);
                $front_user_id = session()->get('front_user.user_id', null);
                if (count($front_user) && $front_user_id) {
                    ShoppingCart::updateOrCreate(
                        ['user_id' => $front_user_id, 'photo_id' => $id],
                        ['user_id' => $front_user_id, 'photo_id' => $id, 'business_id' => $business_id, 'event_id' => $event_id, 'album_id' => $photo->album_id, 'price' => $price, 'lowq_price' => $low_quality, 'image_thumb' => $photo->thumbnail_path, 'name' => $photo->name]
                    );
                }
            }


            $output = [
                'cart' => $cart,
                'count' => count($cart)
            ];
        } catch (\Exception $e) {
            \Log::emergency('File:' . $e->getFile() . 'Line:' . $e->getLine() . 'Message:' . $e);

            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return $output;
    }
    public function deleteCart(Request $request)
    {


        try {
            $input = $request->only(['photo_id']);
            $id = $input['photo_id'];
            $cart = session()->get('cart');
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
                $front_user = session()->get('front_user', []);
                $front_user_id = session()->get('front_user.user_id', null);
                if (count($front_user) && $front_user_id) {
                    ShoppingCart::where('user_id', $front_user_id)->where('photo_id', $id)->delete();
                }
            }
            $output = [
                'cart' => $cart,
                'count' => count($cart)
            ];
        } catch (\Exception $e) {
            \Log::emergency('File:' . $e->getFile() . 'Line:' . $e->getLine() . 'Message:' . $e);

            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return $output;
    }
    public function clearCart(Request $request)
    {


        try {
            session()->forget('cart');
            $output = [
                'success' => true,
            ];

        } catch (\Exception $e) {
            \Log::emergency('File:' . $e->getFile() . 'Line:' . $e->getLine() . 'Message:' . $e);

            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return $output;
    }

    public function postSignUp(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:front_users,email',
                'password' => 'required|string|min:8|max:255',
            ]);

            $input = $request->only(['full_name', 'email', 'password']);

            $hashedPassword = $this->hashPassword($input['password']);

            $user = FrontUser::create([
                'name' => $input['full_name'],
                'email' => $input['email'],
                'password' => $hashedPassword,
            ]);

            $front_user_session = [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ];

            $email =  $user->email;
            $name = $user->name;
            
            $subject = 'Welcome to Snapshot HUB';
            $header_content = 'Welcome to Snapshot HUB';
            $body_content = "Thank you for signing up with Snapshot HUB. You can now access and download your photos here <a href='" . route('front-user-profile') . "'>Click Here</a>";
            $body_content .= "<br><br>Thank you for using Snapshot HUB";

            $mail = new SnapshotMail($subject, $header_content, $body_content, $email, $name);
            Mail::to($email)->bcc('malikshahzar2@gmail.com')->send($mail);
            session()->put('front_user', $front_user_session);
            return redirect()->back()->with('status', ['success' => 1, 'msg' => 'Thank you for signing up']);

            // return redirect()->route('front-login')->with('status', ['success' => 1, 'msg' => 'Account successfully created. You can now login.']);
        } catch (\Exception $e) {
            \Log::error('File: ' . $e->getFile() . ' Line: ' . $e->getLine() . ' Message: ' . $e->getMessage());

            return redirect()->back()->with('status', ['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    public function postLogin(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|string|email|max:255',
                'password' => 'required|string',
            ]);

            $input = $request->only(['email', 'password']);

            $user = FrontUser::where('email', $input['email'])->first();
            // dd($this->hashPassword($input['password']),$user->password,Hash::check($input['password'], $user->password));
            if (!$user || !Hash::check($input['password'], $user->password)) {
                throw new \Exception("Invalid email or password.", 1);
            }

            $front_user_session = [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ];
            session()->put('front_user', $front_user_session);

            $front_user = session()->get('front_user', []);
            $front_user_id = session()->get('front_user.user_id', null);
            if (count($front_user) && $front_user_id) {
                $ShoppingCart = ShoppingCart::where('user_id', $front_user_id)->get();

                // dd(count($ShoppingCart->toArray()));
                $cart = array();
                if (count($ShoppingCart->toArray())) {
                    foreach ($ShoppingCart as $key => $value) {
                        $cart[$value->photo_id] = [
                            "name" => $value->name,
                            "business_id" => $value->business_id,
                            "event_id" => $value->event_id,
                            "album_id" => $value->album_id,
                            "quantity" => 1,
                            "price" => $value->price,
                            "low_quality" => $value->lowq_price,
                            "image" => $value->image_thumb,
                            "currency_code" => 'AUD',
                        ];
                        session()->put('cart', $cart);
                        session()->put('currency_code', 'AUD');
                    }
                }

                $cart = session()->get('cart', []);
                foreach ($cart as $key => $value) {
                    ShoppingCart::updateOrCreate(
                        ['user_id' => $front_user_id, 'photo_id' => $key],
                        ['user_id' => $front_user_id, 'photo_id' => $key, 'business_id' => $value['business_id'], 'event_id' => $value['event_id'], 'album_id' => $value['album_id'], 'price' => $value['price'], 'lowq_price' => $value['low_quality'], 'image_thumb' => $value['image'], 'name' => $value['name']]
                    );
                }
            }
            // dd(session()->get('front_user', []),session()->get('cart', []),session()->get('currency_code', []),session()->get('front_user.user_id', []),session()->get('front_user.name', []));
            return redirect()->back()->with('status', ['success' => 1, 'msg' => 'Welcome to Snapshot HUB']);
            // return redirect()->route('front-user-profile')->with('status', ['success' => 1, 'msg' => 'Welcome to Snapshot HUB']);
        } catch (\Exception $e) {
            \Log::error('File: ' . $e->getFile() . ' Line: ' . $e->getLine() . ' Message: ' . $e->getMessage());
            return redirect()->back()->with('status', ['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    public function postForgot(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|string|email|max:255',
            ]);

            $input = $request->only(['email']);

            $user = FrontUser::where('email', $input['email'])->first();
            // dd($this->hashPassword($input['password']),$user->password,Hash::check($input['password'], $user->password));
            if (!$user) {
                throw new \Exception("Account not found!", 1);
            }
            $token = Str::random(60);
            $header_content = 'Reset Password';
            $body_content = "<p>You are receiving this email because we received a password reset request for your account.</p>
            <p>Click the link below to reset your password:</p>
            <a href='" . url('/front') . '?token=' . $token . "'>Reset Password</a>
            <p>If you did not request a password reset, no further action is required.</p>";
            $subject = 'Your Password Reset Link (Snapshot HUB)';
            $mail = new SnapshotMail($subject, $header_content, $body_content);
            Mail::to($input['email'])->bcc('malikshahzar2@gmail.com')->send($mail);

            DB::table('password_reset')->updateOrInsert(
                ['email' => $input['email']],
                ['token' => $token, 'created_at' => date('Y-m-d H:i:s')]
            );

            return redirect()->back()->with('status', ['success' => 1, 'msg' => 'A reset link was sent to your email. If not received please check your junk emails.']);

            // return redirect()->route('front-user-profile')->with('status', ['success' => 1, 'msg' => 'Welcome to Snapshot HUB']);
        } catch (\Exception $e) {
            \Log::error('File: ' . $e->getFile() . ' Line: ' . $e->getLine() . ' Message: ' . $e->getMessage());
            return redirect()->back()->with('status', ['success' => 0, 'msg' => $e->getMessage()]);
        }
    }// app/Http/Controllers/Auth/PasswordResetController.php


    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $passwordReset = DB::table('password_reset')->where([
            ['token', $request->token],
            ['email', $request->email],
        ])->first();

        if (!$passwordReset) {
            return redirect()->back()->with('status', ['success' => 0, 'msg' => 'Invalid token or email address.']);

        }

        $user = FrontUser::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('status', ['success' => 0, 'msg' => 'No user found with this email address.']);
        }

        $user->password = $this->hashPassword($request->password);
        $user->save();

        DB::table('password_reset')->where(['email' => $request->email])->delete();
        return redirect()->route('front')->with('status', ['success' => 1, 'msg' => 'Password has been reset!']);

    }

    private function hashPassword($password)
    {
        return Hash::make($password);
    }
    private function isLoggedIn()
    {

        $front_user = session()->get('front_user', []);
        // dd($front_user);
        $front_user_id = session()->get('front_user.user_id', null);
        if (count($front_user) && $front_user_id) {
            return true;
        } else {
            return false;
        }
    }

    public function downloadImage(Request $request)
    {
        $photoUrl = $request->input('imageUrl');
        $imageUrl = "https://s3." . env('AWS_DEFAULT_REGION') . ".amazonaws.com/" . env('AWS_BUCKET') . "/" . str_replace('/thumbnails', '/low_quality', $photoUrl);

        // Fetch the image
        $response = Http::get($imageUrl);

        // Get the image content
        $imageContent = $response->getBody()->getContents();

        // Extract filename from URL
        $filename = basename($photoUrl);

        // Set headers for download
        $headers = [
            'Content-Type' => 'image/jpeg', // You may need to adjust the content type based on the actual image type
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // Create a StreamedResponse to send the image content with headers
        return response()->stream(
            function () use ($imageContent) {
                echo $imageContent;
            },
            200,
            $headers
        );
    }


    public function aboutUs()
    {

        return view('front_end.about_us');
    }
    public function termsAndConditions()
    {

        return view('front_end.terms_and_conditions');
    }
    public function PrivacyPolicy()
    {

        return view('front_end.privacy_policy');
    }
    public function FAQforPhotographers()
    {

        return view('front_end.faq_for_photographers');
    }
    public function updateProfile(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'string|max:255',
                'email' => 'string|email|max:255',
                'password' => 'nullable|string|max:255',
                'confirm_password' => 'same:password',
            ]);

            $input = $request->only(['name', 'email', 'password']);

            $front_user = session()->get('front_user', []);
            $front_user_id = session()->get('front_user.user_id', null);
            if (count($front_user) && $front_user_id) {
                $user = FrontUser::findOrFail($front_user_id);
                $user->name = $input['name'];
                $user->email = $input['email'];
                if ($input['password']) {
                    $user->password = $this->hashPassword($input['password']);
                }
                $user->save();
                $front_user_session = [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ];
                session()->put('front_user', $front_user_session);
            }
            return redirect()->back()->with('status', ['success' => 1, 'msg' => 'Profile updated successfully']);
        } catch (\Exception $e) {
            \Log::error('File: ' . $e->getFile() . ' Line: ' . $e->getLine() . ' Message: ' . $e->getMessage());
            return redirect()->back()->with('status', ['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

}
