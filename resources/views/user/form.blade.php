@php
  $custom_labels = json_decode(session('business.custom_labels'), true);
  $user_custom_field1 = !empty($custom_labels['user']['custom_field_1']) ? $custom_labels['user']['custom_field_1'] : __('lang_v1.user_custom_field1');
  $user_custom_field2 = !empty($custom_labels['user']['custom_field_2']) ? $custom_labels['user']['custom_field_2'] : __('lang_v1.user_custom_field2');
  $user_custom_field3 = !empty($custom_labels['user']['custom_field_3']) ? $custom_labels['user']['custom_field_3'] : __('lang_v1.user_custom_field3');
  $user_custom_field4 = !empty($custom_labels['user']['custom_field_4']) ? $custom_labels['user']['custom_field_4'] : __('lang_v1.user_custom_field4');
@endphp

<div class="form-group col-md-3">
    {!! Form::label('account_holder_name', __( 'lang_v1.account_holder_name') . ':') !!}
    {!! Form::text('bank_details[account_holder_name]', !empty($bank_details['account_holder_name']) ? $bank_details['account_holder_name'] : null , ['class' => 'form-control', 'id' => 'account_holder_name', 'placeholder' => __( 'lang_v1.account_holder_name') ]); !!}
</div>
<div class="form-group col-md-3">
    {!! Form::label('account_number', __( 'lang_v1.account_number') . ':') !!}
    {!! Form::text('bank_details[account_number]', !empty($bank_details['account_number']) ? $bank_details['account_number'] : null, ['class' => 'form-control', 'id' => 'account_number', 'placeholder' => __( 'lang_v1.account_number') ]); !!}
</div>
<div class="form-group col-md-3">
    {!! Form::label('bank_name', __( 'lang_v1.bank_name') . ':') !!}
    {!! Form::text('bank_details[bank_name]', !empty($bank_details['bank_name']) ? $bank_details['bank_name'] : null, ['class' => 'form-control', 'id' => 'bank_name', 'placeholder' => __( 'lang_v1.bank_name') ]); !!}
</div>
<div class="form-group col-md-3">
    {!! Form::label('bank_code', __( 'lang_v1.bank_code') . ':') !!} @show_tooltip(__('lang_v1.bank_code_help'))
    {!! Form::text('bank_details[bank_code]', !empty($bank_details['bank_code']) ? $bank_details['bank_code'] : null, ['class' => 'form-control', 'id' => 'bank_code', 'placeholder' => __( 'lang_v1.bank_code') ]); !!}
</div>
<div class="form-group col-md-3">
    {!! Form::label('branch', __( 'lang_v1.branch') . ':') !!}
    {!! Form::text('bank_details[branch]', !empty($bank_details['branch']) ? $bank_details['branch'] : null, ['class' => 'form-control', 'id' => 'branch', 'placeholder' => __( 'lang_v1.branch') ]); !!}
</div>
<div class="form-group col-md-3">
    {!! Form::label('tax_payer_id', __( 'lang_v1.tax_payer_id') . ':') !!}
    @show_tooltip(__('lang_v1.tax_payer_id_help'))
    {!! Form::text('bank_details[tax_payer_id]', !empty($bank_details['tax_payer_id']) ? $bank_details['tax_payer_id'] : null, ['class' => 'form-control', 'id' => 'tax_payer_id', 'placeholder' => __( 'lang_v1.tax_payer_id') ]); !!}
</div>