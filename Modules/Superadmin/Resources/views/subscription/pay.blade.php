@extends($layout)

@section('title', __('superadmin::lang.subscription'))

@section('content')

    <!-- Main content -->
    <section class="content">

        @include('superadmin::layouts.partials.currency')

        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">@lang('superadmin::lang.pay_and_subscribe')</h3>
            </div>

            <div class="box-body">
                <div class="col-md-8">
                    <h3>
                        {{ $package->name }}

                        (<span class="display_currency" data-currency_symbol="true">{{ $package->price }}</span>

                        <small>
                            / {{ $package->interval_count }} {{ ucfirst($package->interval) }}
                        </small>)
                    </h3>
                    <ul>
                        <li>
                            @if ($package->aws_storage == 0)
                                @lang('superadmin::lang.unlimited')
                            @else
                                {{ $package->aws_storage }} GB
                            @endif

                            AWS Storage
                        </li>

                        <li>
                            @if ($package->platform_commission == 0)
                                No
                            @else
                                {{ $package->platform_commission }} %
                            @endif

                            Platform Comission
                        </li>

                        <li>

                            @if ($package->event_data_duration == 0)
                                Permanantly store data
                            @else
                                Delete data after {{ $package->event_data_duration }} Month(s) fromthe last sale of event
                            @endif
                        </li>

                        <li>

                            @if ($package->own_branding == 0)
                                Can not use your own branding
                            @else
                                Can use your own branding
                            @endif
                        </li>

                    </ul>
                    {{-- @php
				  if($coupon_status['status'] == 'success')	{
					$package->price =  number_format($package_price_after_discount , 2, '.', '');
				  }
				@endphp --}}

                    <ul class="list-group">
                        @foreach ($gateways as $k => $v)
                            <div class="list-group-item">
                                <b>@lang('superadmin::lang.pay_via', ['method' => $v])</b>
                                <div class="row" id="paymentdiv_{{ $k }}">
                                    @php
                                        $view = 'superadmin::subscription.partials.pay_' . $k;
                                    @endphp
                                    @includeIf($view)
                                </div>
                            </div>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
