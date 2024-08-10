@extends('layouts.app')
@section('title', __('home.home'))

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header content-header-custom">
        <h1>{{ __('home.welcome_message', ['name' => Session::get('user.first_name')]) }}
        </h1>
    </section>
    <!-- Main content -->
    <section class="content content-custom no-print">
        <br>
        @if (auth()->user()->can('dashboard.data'))
            @if ($is_super_admin)
                
            <div class="row">
                <!-- /.col -->
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12 col-custom">
                    <div class="info-box info-box-new-style">
                        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-cart-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Platform Sales</span>
                            <span class="info-box-number"> {{$currency->symbol}}  {{round($platform_total_amount,2)}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12  col-custom">
                    <div class="info-box info-box-new-style">
                        <span class="info-box-icon bg-yellow">
                            <i class="fa fa-wallet"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Platform Profit</span>
                            <span class="info-box-number" > {{$currency->symbol}} {{round($platform_net_amount,2)}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12  col-custom">
                    <div class="info-box info-box-new-style">
                        <span class="info-box-icon bg-navy">
                            <i class="fa fas fa-share"></i>

                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Vendors Withdrawn Amount</span>
                            <span class="info-box-number"> {{$currency->symbol}} {{round($platform_total_withdrawn,2)}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12  col-custom">
                    <div class="info-box info-box-new-style">
                        <span class="info-box-icon bg-green">
                            <i class="fa fas fa-money-bill"></i>

                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Vendor Withdraw Remaining</span>
                            <span class="info-box-number"> {{$currency->symbol}} {{round(($vendors_net_amount-$platform_total_withdrawn),2)}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

                <!-- /.col -->
            </div>
            <br>
            @endif
            @if ($is_admin || $is_super_admin)
                <div class="row">
                   
                    {{-- <div class="col-md-8 col-xs-12">
                        <div class="form-group pull-right">
                            <div class="input-group">
                                <button type="button" class="btn btn-primary" id="dashboard_date_filter">
                                    <span>
                                        <i class="fa fa-calendar"></i> {{ __('messages.filter_by_date') }}
                                    </span>
                                    <i class="fa fa-caret-down"></i>
                                </button>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <br>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12  col-custom">
                        <div class="info-box info-box-new-style">
                            <span class="info-box-icon bg-blue"><i class="ion ion-ios-cart-outline"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ __('home.total_sell') }}</span>
                                <span class="info-box-number">{{$currency->symbol}} {{round($vendor_total_amount,2)}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12  col-custom">
                        <div class="info-box info-box-new-style">
                            <span class="info-box-icon bg-red">
                                <i class="fa fa-share"></i>

                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">Platform Share</span>
                                <span class="info-box-number net">{{$currency->symbol}} {{round($vendor_platform_share,2)}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12  col-custom">
                        <div class="info-box info-box-new-style">
                            <span class="info-box-icon bg-aqua">
                                <i class="fa fa-wallet"></i>

                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">Net Profit</span>
                                <span class="info-box-number net">{{$currency->symbol}} {{round($vendor_net_amount,2)}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12  col-custom">
                        <div class="info-box info-box-new-style">
                            <span class="info-box-icon bg-yellow">
                                <i class="fa fas fa-share"></i>

                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">withdrawn Amount</span>
                                <span class="info-box-number net">{{$currency->symbol}} {{round($vendor_total_withdrawn,2)}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12  col-custom">
                        <div class="info-box info-box-new-style">
                            <span class="info-box-icon bg-black">
                                <i class="fa fas fa-money-bill"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">Remaining Amount</span>
                                <span class="info-box-number net">{{$currency->symbol}} {{round($vendor_net_amount-$vendor_total_withdrawn,2)}}</span>
                                
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 col-12  col-custom">
                        <div class="info-box info-box-new-style">
                            <span class="info-box-icon bg-black">
                                <i class="fa fas fa-money-bill"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">Events</span>
                                <span class="info-box-number net">{{$events}}</span>

                                <a class="btn btn-warning btn-xs pull-right" style="margin-right: 5px;" href="{{ action([\App\Http\Controllers\EventManagementController::class, 'index'])}}">
                                    
                                    <span class="info-box-number text-right"  style="font-size: 12px;" ><i class="fa fa-eye"></i></span>
                                </a>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    
                </div>

            @endif
            <!-- end is_admin check -->
            @if (auth()->user()->can('sell.view') ||
                    auth()->user()->can('direct_sell.view'))
                @if (!empty($all_locations))
                    <!-- sales chart start -->
                    <div class="row">
                        <div class="col-sm-12">
                            @component('components.widget', ['class' => 'box-primary', 'title' => __('home.sells_last_30_days')])
                                {!! $sells_chart_1->container() !!}
                            @endcomponent
                        </div>
                    </div>
                @endif
                @if (!empty($widgets['after_sales_last_30_days']))
                    @foreach ($widgets['after_sales_last_30_days'] as $widget)
                        {!! $widget !!}
                    @endforeach
                @endif
                
            @endif
            @if ($is_super_admin)
                
            @component('components.widget', ['class' => 'box-primary', 'title' => 'Sales Stats(per business)'])
                <table class="table table-bordered table-striped" id="sales_stats">
                    <thead>
                        <tr>
                            <th>Business Id</th>
                            <th>Business Name</th>
                            <th>Total Sale</th>
                            <th>Platform Share</th>
                            <th>Business Share</th>
                            <th>Approved Withdraws</th>
                            <th>Pending Withdraws</th>
                            <th>Remaining</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales_stats as $key => $value)
                            <tr>
                                <td>{{ $value['id'] }}</td>
                                <td>{{ $value['name'] }}</td>
                                <td>{{$currency->symbol}} {{ round($value['total_net_amount'],2) }}</td>
                                <td>{{$currency->symbol}} {{ round($value['total_platform_share'],2) }}</td>
                                <td>{{$currency->symbol}} {{ round($value['total_vendor_share'],2) }}</td>
                                <td>{{$currency->symbol}} {{ round($value['approved_requested_amount'],2) }}</td>
                                <td>{{$currency->symbol}} {{ round($value['pending_requested_amount'],2) }}</td>
                                <td>{{$currency->symbol}} {{ round($value['remaining_with_vendor_share'],2) }}</td>
                            </tr>
                            
                        @endforeach
                    </tbody>
                </table>
            @endcomponent
            @endif
            {{-- @if (auth()->user()->can('so.view_all') ||
                    auth()->user()->can('so.view_own'))
                <div class="row" @if (!auth()->user()->can('dashboard.data')) style="margin-top: 190px !important;" @endif>
                    <div class="col-sm-12">
                        @component('components.widget', ['class' => 'box-warning'])
                            @slot('icon')
                                <i class="fas fa-list-alt text-yellow fa-lg" aria-hidden="true"></i>
                            @endslot
                            @slot('title')
                                {{ __('lang_v1.sales_order') }}
                            @endslot
                            <div class="row">
                                @if (count($all_locations) > 1)
                                    <div class="col-md-4 col-sm-6 col-md-offset-8 mb-10">
                                        {!! Form::select('so_location', $all_locations, null, [
                                            'class' => 'form-control select2',
                                            'placeholder' => __('lang_v1.select_location'),
                                            'id' => 'so_location',
                                        ]) !!}
                                    </div>
                                @endif
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped ajax_view" id="sales_order_table">
                                            <thead>
                                                <tr>
                                                    <th>@lang('messages.action')</th>
                                                    <th>@lang('messages.date')</th>
                                                    <th>@lang('restaurant.order_no')</th>
                                                    <th>@lang('sale.customer_name')</th>
                                                    <th>@lang('lang_v1.contact_no')</th>
                                                    <th>@lang('sale.location')</th>
                                                    <th>@lang('sale.status')</th>
                                                    <th>@lang('lang_v1.shipping_status')</th>
                                                    <th>@lang('lang_v1.quantity_remaining')</th>
                                                    <th>@lang('lang_v1.added_by')</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endcomponent
                    </div>
                </div>
            @endif --}}

           



        @endif
        <!-- can('dashboard.data') end -->
    </section>
    <!-- /.content -->
    <div class="modal fade payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>
    <div class="modal fade edit_pso_status_modal" tabindex="-1" role="dialog"></div>
    <div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>
@stop
@section('javascript')
{{-- @dd($response_array) --}}
    @if ($response_array['success'] != 1)
        <script>
            $(document).ready(function() {
                
                toastr.error("<?= $response_array['msg'] ?>");
            });
        </script>
        
    @endif
    <script src="{{ asset('js/home.js?v=' . $asset_v) }}"></script>
    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
    @includeIf('sales_order.common_js')
    @includeIf('purchase_order.common_js')
    @if (!empty($all_locations))
        {!! $sells_chart_1->script() !!}
        {!! $sells_chart_2->script() !!}
    @endif
    <script type="text/javascript">
        $(document).ready( function(){
            $('#sales_stats').DataTable({
                responsive: true,
            });
        });
    </script>
@endsection
