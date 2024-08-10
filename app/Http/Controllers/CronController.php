<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Customer;
use Stripe\Stripe;
use App\Business;
use App\System;
use App\Currency;
use App\Utils\ModuleUtil;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Superadmin\Entities\Package;
use Modules\Superadmin\Entities\Subscription;
use Modules\Superadmin\Entities\SuperadminCoupon;
use Modules\Superadmin\Notifications\SubscriptionOfflinePaymentActivationConfirmation;
use Notification;
use Paystack;
use Pesapal;
use Razorpay\Api\Api;
use Srmklive\PayPal\Services\ExpressCheckout;
use Stripe\Charge;

use App\FrontUser;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Eventalbums;
use App\EventAlbumPhotos;
use Illuminate\Support\Facades\Storage;
use App\Event;
use App\FrontUserPhotos;

class CronController extends Controller
{

    public function subscriptionCron()
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            $subscriptions = \Stripe\Subscription::all();
            $subscription_data = array();
            foreach ($subscriptions['data'] as $key => $value) {
                $sub_id = $value['id'];
                $status = $value['status'];
                $current_period_start = date('Y-m-d', $value['current_period_start']);
                $current_period_end = date('Y-m-d', $value['current_period_end']);
                $subscription_data = Subscription::where('payment_transaction_id', $sub_id)->first();
                if ($subscription_data) {
                    $local_start = date('Y-m-d', strtotime($subscription_data->start_date));
                    $local_end = date('Y-m-d', strtotime($subscription_data->end_date));
                    if (($current_period_start != $local_start || $current_period_end != $local_end) && $status == 'active' && $subscription_data->status == 'approved' && $current_period_start > $local_end) {
                        // todo: update existing subscription status to renewed, and created new subscription with same data of old and status as approved and new start and end date
                        $subscription_data->status = 'renewed';
                        $subscription_data->save();
                        $new_subscription = new Subscription();
                        $new_subscription->business_id = $subscription_data->business_id;
                        $new_subscription->package_id = $subscription_data->package_id;
                        $new_subscription->payment_transaction_id = $subscription_data->payment_transaction_id;
                        $new_subscription->start_date = $current_period_start;
                        $new_subscription->end_date = $current_period_end;
                        $new_subscription->package_price = $subscription_data->package_price;
                        $new_subscription->original_price = $subscription_data->original_price;
                        $new_subscription->package_details = $subscription_data->package_details;
                        $new_subscription->created_id = $subscription_data->created_id;
                        $new_subscription->paid_via = $subscription_data->paid_via;
                        $new_subscription->paid_via = $subscription_data->paid_via;
                        $new_subscription->status = 'approved';
                        $new_subscription->save();

                    } elseif ($status == 'canceled' && $subscription_data->status == 'approved') {
                        $subscription_data->status = 'canceled';
                        $subscription_data->save();

                    }
                }

            }
            return response()->json(['status' => true, 'message' => 'Subscription cron run successfully']);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => 'Something went wrong']);
        }

    }
    function removeExpireSubscriptionData()
    {
        try {
            $all_business = Business::all();
            foreach ($all_business as $key => $value) {
                $business_id = $value->id;
                $active = Subscription::active_subscription($business_id);
                if ($active) {
                    continue;
                }
                $last_end_date = Subscription::where('business_id', $business_id)->max('end_date');
                if ($last_end_date) {
                    $last_end_date = date('Y-m-d', strtotime($last_end_date));
                    $three_months_ago = date('Y-m-d', strtotime('-3 months'));
                    if ($last_end_date < $three_months_ago) {
                        $all_photos = EventAlbumPhotos::where('business_id', $business_id)
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
                    }
                }
            }
            return response()->json(['status' => true, 'message' => 'Subscription cron run successfully']);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => 'Something went wrong']);
        }
    }
    function removeEventLastSaleData()
    {
        try {
            $all_business = Business::all();
            foreach ($all_business as $key => $value) {
                $business_id = $value->id;
                $active = Subscription::active_subscription($business_id);
                if ($active) {
                    $package = Package::find($active->package_id);
                    $event_data_duration = $package->event_data_duration;
                    $old_date = date('Y-m-d', strtotime('-' . $event_data_duration . ' months'));
                    $events = Event::where('business_id', $business_id)->get();
                    foreach ($events as $key => $event) {
                        $last_sale_date = FrontUserPhotos::where('event_id', $event->id)->where('business_id', $business_id)->max('created_at');
                        if ($last_sale_date) {
                            $last_sale_date = date('Y-m-d', strtotime($last_sale_date));
                            if ($last_sale_date < $old_date) {
                                $all_photos = EventAlbumPhotos::where('event_id', $event->id)
                                    ->whereNotIn('id', function ($query) {
                                        $query->select('photo_id')
                                            ->from('user_photos');
                                    })
                                    ->get();
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
                            }

                        }
                    }

                }
            }
            return response()->json(['status' => true, 'message' => 'Subscription cron run successfully']);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => 'Something went wrong']);
        }
    }
}


