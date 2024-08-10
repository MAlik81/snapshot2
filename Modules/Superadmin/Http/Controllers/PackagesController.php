<?php

namespace Modules\Superadmin\Http\Controllers;

use App\Business;
use App\System;
use App\Utils\BusinessUtil;
use App\Utils\ModuleUtil;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Superadmin\Entities\Package;
use Modules\Superadmin\Entities\Subscription;
use Illuminate\Routing\Controller;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\Product;
use Stripe\Price;

class PackagesController extends Controller
{
    /**
     * All Utils instance.
     */
    protected $businessUtil;

    protected $moduleUtil;

    /**
     * Constructor
     *
     * @param  ProductUtils  $product
     * @return void
     */
    public function __construct(BusinessUtil $businessUtil, ModuleUtil $moduleUtil)
    {
        $this->businessUtil = $businessUtil;
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        $packages = Package::orderby('sort_order', 'asc')
            ->paginate(20);

        //Get all module permissions and convert them into name => label
        $permissions = $this->moduleUtil->getModuleData('superadmin_package');
        $permission_formatted = [];
        foreach ($permissions as $permission) {
            foreach ($permission as $details) {
                $permission_formatted[$details['name']] = $details['label'];
            }
        }

        return view('superadmin::packages.index')
            ->with(compact('packages', 'permission_formatted'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        $intervals = ['day' => __('lang_v1.days'), 'month' => __('lang_v1.months'), 'year' => __('lang_v1.years')];
        $currency = System::getCurrency();
        $businesses = Business::get()->pluck('name', 'id');

        $permissions = $this->moduleUtil->getModuleData('superadmin_package');

        return view('superadmin::packages.create')
            ->with(compact('intervals', 'currency', 'permissions', 'businesses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }


        try {
            $input = $request->only([
                'name',
                'description',
                'location_count',
                'user_count',
                'product_count',
                'invoice_count',
                'interval',
                'interval_count',
                'trial_days',
                'price',
                'sort_order',
                'is_active',
                'mark_package_as_popular',
                'custom_permissions',
                'is_private',
                'is_one_time',
                'enable_custom_link',
                'custom_link',
                'custom_link_text',
                'businesses',
                'aws_storage',
                'platform_commission',
                'event_data_duration',
                'own_branding'
            ]);
            $currency = System::getCurrency();

            $input['price'] = $this->businessUtil->num_uf($input['price'], $currency);
            $input['is_active'] = empty($input['is_active']) ? 0 : 1;
            $packages_details['own_branding'] = empty($packages_details['own_branding']) ? 0 : 1;
            $input['mark_package_as_popular'] = empty($input['mark_package_as_popular']) ? 0 : 1;
            $input['created_by'] = $request->session()->get('user.id');

            $input['is_private'] = empty($input['is_private']) ? 0 : 1;
            $input['is_one_time'] = empty($input['is_one_time']) ? 0 : 1;
            $input['enable_custom_link'] = empty($input['enable_custom_link']) ? 0 : 1;

            $input['custom_link'] = empty($input['enable_custom_link']) ? '' : $input['custom_link'];
            $input['custom_link_text'] = empty($input['enable_custom_link']) ? '' : $input['custom_link_text'];

            // $input['businesses'] = $input['businesses'] = empty($input['businesses']) ? null : json_encode($input['businesses']);
            $input['businesses'] = $input['businesses'] = empty($input['businesses']) ? null : null;




            // Set your Stripe secret key
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            // Create a product
            $product = Product::create([
                'name' => $input['name'],
                'type' => 'service', // or 'good' depending on your product type
                'description' => $input['description']
            ]);

            // Create a price associated with the product
            $price = Price::create([
                'product' => $product->id,
                'unit_amount' => $input['price'] * 100, // Replace with the amount in cents (e.g., $10.00 would be 1000)
                'currency' => 'aud',
                'recurring' => [
                    'interval' => $input['interval'],
                    'interval_count' => $input['interval_count']
                ] // Set the billing interval (e.g., 'month')
            ]);
            // dd($price);
            $input['product_id'] = $product->id;
            $input['price_id'] = $price->id;
            // Output the Product ID and Price ID
            // echo 'Product ID: ' . $product->id . "\n";
            // echo 'Price ID: ' . $price->id . "\n";





            $package = new Package;
            $package->fill($input);
            $package->save();

            $output = ['success' => 1, 'msg' => __('lang_v1.success')];
        } catch (\Exception $e) {
            \Log::emergency('File:' . $e->getFile() . 'Line:' . $e->getLine() . 'Message:' . $e->getMessage());
            dd($e);
            $output = [
                'success' => 0,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return redirect()
            ->action([\Modules\Superadmin\Http\Controllers\PackagesController::class, 'index'])
            ->with('status', $output);
    }

    /**
     * Show the specified resource.
     *
     * @return Response
     */
    public function show()
    {
        return view('superadmin::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit($id)
    {
        $packages = Package::where('id', $id)
            ->first();

        $intervals = ['day' => __('lang_v1.days'), 'month' => __('lang_v1.months'), 'year' => __('lang_v1.years')];

        $permissions = $this->moduleUtil->getModuleData('superadmin_package', true);
        $businesses = Business::get()->pluck('name', 'id');

        return view('superadmin::packages.edit')
            ->with(compact('packages', 'intervals', 'permissions', 'businesses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $packages_details = $request->only(['name', 'id', 'description', 'location_count', 'user_count', 'product_count', 'invoice_count', 'interval', 'interval_count', 'trial_days', 'price', 'sort_order', 'is_active', 'mark_package_as_popular', 'custom_permissions', 'is_private', 'is_one_time', 'enable_custom_link', 'custom_link', 'custom_link_text', 'businesses', 'aws_storage', 'platform_commission', 'event_data_duration','own_branding']);
           
            $packages_details['is_active'] = empty($packages_details['is_active']) ? 0 : 1;
            $packages_details['own_branding'] = empty($packages_details['own_branding']) ? 0 : 1;
            $packages_details['mark_package_as_popular'] = empty($packages_details['mark_package_as_popular']) ? 0 : 1;
            $packages_details['custom_permissions'] = empty($packages_details['custom_permissions']) ? null : $packages_details['custom_permissions'];

            $packages_details['is_private'] = empty($packages_details['is_private']) ? 0 : 1;
            $packages_details['is_one_time'] = empty($packages_details['is_one_time']) ? 0 : 1;
            $packages_details['enable_custom_link'] = empty($packages_details['enable_custom_link']) ? 0 : 1;
            $packages_details['custom_link'] = empty($packages_details['enable_custom_link']) ? '' : $packages_details['custom_link'];
            $packages_details['custom_link_text'] = empty($packages_details['enable_custom_link']) ? '' : $packages_details['custom_link_text'];

            $packages_details['businesses'] = null;

            $package = Package::where('id', $id)
                ->first();



            // Set your Stripe secret key
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            if ($packages_details['name'] != $package->name || $packages_details['description'] != $package->description) {
                // Create a product
                $product = Product::update($package->product_id, [
                    'name' => $packages_details['name'],
                    'description' => $packages_details['description']
                ]);
            }
            // dd($product);


            if ($packages_details['price'] != $package->price || $packages_details['interval'] != $package->interval || $packages_details['interval_count'] != $package->interval_count) {
                // Create a price associated with the product
                $price = Price::create([
                    'product' => $package->product_id,
                    'unit_amount' => $packages_details['price'] * 100, // Replace with the amount in cents (e.g., $10.00 would be 1000)
                    'currency' => 'aud',
                    'recurring' => [
                        'interval' => $packages_details['interval'],
                        'interval_count' => $packages_details['interval_count']
                    ] // Set the billing interval (e.g., 'month')
                ]);

                $packages_details['price_id'] = $price->id;
                Price::update($package->price_id, [
                    'active' => false
                ]);
            }
            $package->fill($packages_details);
            $package->save();
            // Create a price associated with the product

            if (!empty($request->input('update_subscriptions'))) {
                $package_details = [
                    'location_count' => $package->location_count,
                    'user_count' => $package->user_count,
                    'product_count' => $package->product_count,
                    'invoice_count' => $package->invoice_count,
                    'name' => $package->name,
                    'aws_storage' => $package->aws_storage,
                    'platform_commission' => $package->platform_commission,
                    'event_data_duration' => $package->event_data_duration,
                    'own_branding' => $package->own_branding,
                ];
                if (!empty($package->custom_permissions)) {
                    foreach ($package->custom_permissions as $name => $value) {
                        $package_details[$name] = $value;
                    }
                }

                //Update subscription package details
                $subscriptions = Subscription::where('package_id', $package->id)
                    ->whereDate('end_date', '>=', \Carbon::now())
                    ->update(['package_details' => json_encode($package_details)]);
            }

            $output = ['success' => 1, 'msg' => __('lang_v1.success')];
        } catch (\Exception $e) {
            \Log::emergency('File:' . $e->getFile() . 'Line:' . $e->getLine() . 'Message:' . $e->getMessage());
            // dd($e);
            $output = [
                'success' => 0,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return redirect()
            ->action([\Modules\Superadmin\Http\Controllers\PackagesController::class, 'index'])
            ->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            Package::where('id', $id)
                ->delete();

            $output = ['success' => 1, 'msg' => __('lang_v1.success')];
        } catch (\Exception $e) {
            \Log::emergency('File:' . $e->getFile() . 'Line:' . $e->getLine() . 'Message:' . $e->getMessage());

            $output = [
                'success' => 0,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return redirect()
            ->action([\Modules\Superadmin\Http\Controllers\PackagesController::class, 'index'])
            ->with('status', $output);
    }
}
