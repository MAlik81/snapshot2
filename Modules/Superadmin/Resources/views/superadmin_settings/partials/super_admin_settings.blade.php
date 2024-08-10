<div class="pos-tab-content active">
    <div class="row">
    	<div class="col-md-4 col-xs-12">
            <div class="form-group">
                {!! Form::label('invoice_business_name', __('business.business_name') . ':') !!}
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-suitcase"></i>
                    </span>
                {!! Form::text('invoice_business_name', $settings["invoice_business_name"], ['class' => 'form-control','placeholder' => __('business.business_name'), 'required']); !!}
            </div>
            </div>
        </div>

        <div class="col-md-4 col-xs-12">
            <div class="form-group">
                {!! Form::label('email', __('business.email'). ':')!!}
                <div class="input-group">
                    <span class="input-group-addon">
                    <i class="fa fa-envelope"></i>
                    </span>
                {!! Form::email('email',$settings["email"], ['class'=>'form-control', 'placeholder'=> __('business.email')])!!}
                </div>
            </div>
        </div>
        <input type="hidden" type="hidden" name="app_currency_id" value="2">
        <input type="hidden" type="hidden" name="invoice_business_landmark" value="234">
        <input type="hidden" type="hidden" name="invoice_business_zip" value="2345">
        <input type="hidden" type="hidden" name="invoice_business_state" value="234">
        <input type="hidden" type="hidden" name="invoice_business_city" value="234">
        <input type="hidden" type="hidden" name="invoice_business_country" value="abc">
       
        <div class="col-md-4 col-xs-12">
            <div class="form-group">
                 {!! Form::label('package_expiry_alert_days', __('superadmin::lang.package_expiry_alert_days') . ':') !!}
                <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-exclamation-triangle"></i>
                </span>
                {!! Form::number('package_expiry_alert_days', $settings["package_expiry_alert_days"], ['class' => 'form-control','placeholder' => __('superadmin::lang.package_expiry_alert_days'), 'required']); !!}
            </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="col-md-4 col-xs-12">
            <div class="form-group">
                <label>
                    {!! Form::checkbox('enable_business_based_username', 1, (int)$settings["enable_business_based_username"] , 
                    [ 'class' => 'input-icheck']); !!} {{ __( 'superadmin::lang.enable_business_based_username' ) }}
                </label>
                <p class="help-block">@lang('superadmin::lang.business_based_username_help')</p>
            </div>
        </div>

        {{-- <div class="col-xs-12">
            <p class="help-block"><i>{!! __('superadmin::lang.version_info', ['version' => $superadmin_version]) !!}</i></p>
        </div> --}}
    </div>
</div>