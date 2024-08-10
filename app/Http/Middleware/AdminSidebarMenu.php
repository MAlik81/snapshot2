<?php

namespace App\Http\Middleware;

use App\Utils\ModuleUtil;
use Closure;
use Menu;

class AdminSidebarMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->ajax()) {
            return $next($request);
        }

        Menu::create('admin-sidebar-menu', function ($menu) {
            $enabled_modules = !empty (session('business.enabled_modules')) ? session('business.enabled_modules') : [];

            $common_settings = !empty (session('business.common_settings')) ? session('business.common_settings') : [];
            $pos_settings = !empty (session('business.pos_settings')) ? json_decode(session('business.pos_settings'), true) : [];

            $is_admin = auth()->user()->hasRole('Admin#' . session('business.id')) ? true : false;
            //Home
            $menu->url(action([\App\Http\Controllers\HomeController::class, 'index']), __('home.home'), ['icon' => 'fa fas fa-tachometer-alt', 'active' => request()->segment(1) == 'home'])->order(5);

            //User management dropdown
            if (auth()->user()->can('user.view') || auth()->user()->can('user.create') || auth()->user()->can('roles.view')) {
                $menu->dropdown(
                    __('user.user_management'),
                    function ($sub) {
                        if (auth()->user()->can('user.view')) {
                            $sub->url(
                                action([\App\Http\Controllers\ManageUserController::class, 'index']),
                                __('user.users'),
                                ['icon' => 'fa fas fa-user', 'active' => request()->segment(1) == 'users']
                            );
                        }
                        if (auth()->user()->can('roles.view')) {
                            $sub->url(
                                action([\App\Http\Controllers\RoleController::class, 'index']),
                                __('user.roles'),
                                ['icon' => 'fa fas fa-briefcase', 'active' => request()->segment(1) == 'roles']
                            );
                        }
                        // if (auth()->user()->can('user.create')) {
                        //     $sub->url(
                        //         action([\App\Http\Controllers\SalesCommissionAgentController::class, 'index']),
                        //         __('lang_v1.sales_commission_agents'),
                        //         ['icon' => 'fa fas fa-handshake', 'active' => request()->segment(1) == 'sales-commission-agents']
                        //     );
                        // }
                    },
                    ['icon' => 'fa fas fa-users']
                )->order(10);
            }




            if (auth()->user()->can('event.view')) {
                $menu->url(action([\App\Http\Controllers\EventManagementController::class, 'index']), 'Event Management', ['icon' => 'fa fas fa-envelope', 'active' => request()->segment(1) == 'event-management'])->order(10);
            }

            $administrator_list = config('constants.administrator_usernames');
            if (!empty(auth()->user()) && in_array(strtolower(auth()->user()->username), explode(',', strtolower($administrator_list)))) {
                $menu->url(action([\App\Http\Controllers\WithdrawalController::class, 'withdrawlRequests']), 'Withdrawals Requests', ['icon' => 'fa fa-share', 'active' => request()->segment(1) == 'withdrawl-requests'])->order(10);
            }else{
                
                if (auth()->user()->can('manage_withdrawals')) {
                    $menu->url(action([\App\Http\Controllers\WithdrawalController::class, 'index']), 'Withdrawals', ['icon' => 'fa fas fa-money-bill', 'active' => request()->segment(1) == 'withdrawals'])->order(10);
                }
            }

            //Settings Dropdown
            if (
                auth()->user()->can('business_settings.access') ||
                auth()->user()->can('barcode_settings.access') ||
                auth()->user()->can('invoice_settings.access') ||
                auth()->user()->can('tax_rate.view') ||
                auth()->user()->can('tax_rate.create') ||
                auth()->user()->can('access_package_subscriptions')
            ) {
                $menu->dropdown(
                    __('business.settings'),
                    function ($sub) use ($enabled_modules) {
                        if (auth()->user()->can('business_settings.access')) {
                            $sub->url(
                                action([\App\Http\Controllers\BusinessController::class, 'getBusinessSettings']),
                                __('business.business_settings'),
                                ['icon' => 'fa fas fa-cogs', 'active' => request()->segment(1) == 'business', 'id' => 'tour_step2']
                            );

                        }

                    },
                    ['icon' => 'fa fas fa-cog', 'id' => 'tour_step3']
                )->order(85);
            }

                $menu->url('#', 'Help & Support', ['icon' => 'fa fas fa-info-circle', 'active' => request()->segment(1) == 'help'])->order(100);
        });

        //Add menus from modules
        $moduleUtil = new ModuleUtil;
        $moduleUtil->getModuleData('modifyAdminMenu');

        return $next($request);
    }
}
