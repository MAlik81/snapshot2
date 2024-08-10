@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | ' . __('superadmin::lang.packages'))

@section('content')
@include('superadmin::layouts.nav')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('superadmin::lang.packages') <small>@lang('superadmin::lang.edit_package')</small></h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>


<!-- Main content -->
<section class="content">
    {!! Form::open(['route' => ['packages.update', $packages->id], 'method' => 'put', 'id' => 'edit_package_form']) !!}

    <div class="box box-solid">
        <div class="box-body">
            <div class="row">

                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('name', __('lang_v1.name').':') !!}
                        {!! Form::text('name', $packages->name, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('description', __('superadmin::lang.description').':') !!}
                        {!! Form::textarea('description', $packages->description, ['class' => 'form-control', 'required', 'rows' => 3]) !!}
                    </div>
                </div>

                <div class="clearfix"></div>
                <input type="hidden" name="location_count" value="0" />
                <input type="hidden" name="user_count" value="0" />
                <input type="hidden" name="product_count" value="0" />
                <input type="hidden" name="invoice_count" value="0" />
                <input type="hidden" name="trial_days" value="0" />
                <input type="hidden" name="businesses[]" value="" />

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('interval', __('superadmin::lang.interval').':') !!}

                        {!! Form::select('interval', $intervals, $packages->interval, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'required']); !!}
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('interval_count ', __('superadmin::lang.interval_count').':') !!}
                        {!! Form::number('interval_count', $packages->interval_count, ['class' => 'form-control', 'required', 'min' => 1]); !!}
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('aws_storage', 'AWS Storage:') !!}
                        {!! Form::number('aws_storage', $packages->aws_storage, ['class' => 'form-control', 'placeholder' => '0', 'required']); !!}
                        <span class="help-block">
                            0 = Unlimited Storage
                        </span>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('platform_commission', 'Platform Commission:') !!}
                        {!! Form::number('platform_commission', $packages->platform_commission, ['class' => 'form-control', 'required', 'min' => 1]); !!}
                    </div>
                </div>
                <div class="clearfix"></div>


                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('price', __('superadmin::lang.price').':') !!}
                        @show_tooltip(__('superadmin::lang.tooltip_pkg_price'))

                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon3"><b>AUD-$</b></span>
                            {!! Form::text('price', $packages->price, ['class' => 'form-control input_number', 'required']); !!}
                        </div>
                        <span class="help-block">
                            0 = @lang('superadmin::lang.free_package')
                        </span>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('sort_order ', __('superadmin::lang.sort_order').':') !!}
                        {!! Form::number('sort_order', $packages->sort_order, ['class' => 'form-control', 'required']); !!}
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('event_data_duration', 'Delete event data after last sale of event:') !!}
                        {!! Form::number('event_data_duration', $packages->event_data_duration, ['class' => 'form-control', 'required']) !!}
                        <span class="help-block">
                            Months
                        </span>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="col-sm-3">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('own_branding', 1, $packages->own_branding, ['class' => 'input-icheck']); !!}
                            Allow own branding
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('is_active', 1, $packages->is_active, ['class' => 'input-icheck']); !!}
                            {{__('superadmin::lang.is_active')}}
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('mark_package_as_popular', 1, $packages->mark_package_as_popular, ['class' => 'input-icheck']); !!}
                            {{__('superadmin::lang.mark_package_as_popular')}}
                        </label>
                    </div>
                </div>
            </div>

            <div class="row text-center">
                <button type="submit" class="btn btn-primary btn-big">@lang('messages.save')</button>
            </div>

        </div>
    </div>

    {!! Form::close() !!}
</section>

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {
        $('form#edit_package_form').validate();
    });
    $('#enable_custom_link').on('ifChecked', function(event) {
        $("div#custom_link_div").removeClass('hide');
    });
    $('#enable_custom_link').on('ifUnchecked', function(event) {
        $("div#custom_link_div").addClass('hide');
    });

</script>
@endsection
