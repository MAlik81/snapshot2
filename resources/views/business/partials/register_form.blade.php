{{-- @if (empty($is_admin))
    <h3>Account Details</h3>
@endif --}}
{!! Form::hidden('language', request()->lang) !!}

<style>
    .bg-custom-button {
        background-color: #D89623;
        color: #fff;
        padding: 10px 30px;
    }
</style>
<fieldset>
    <legend>Signup as an event manager:</legend>
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('name', __('business.business_name') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-suitcase"></i>
                </span>
                {!! Form::text('name', null, [
                    'class' => 'form-control',
                    'placeholder' => __('business.business_name'),
                    'required',
                ]) !!}
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('surname', __('business.prefix') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-info"></i>
                </span>
                {!! Form::text('surname', null, ['class' => 'form-control', 'placeholder' => __('business.prefix_placeholder')]) !!}
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('first_name', __('business.first_name') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-info"></i>
                </span>
                {!! Form::text('first_name', null, [
                    'class' => 'form-control',
                    'placeholder' => __('business.first_name'),
                    'required',
                ]) !!}
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('last_name', __('business.last_name') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-info"></i>
                </span>
                {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => __('business.last_name')]) !!}
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('username', __('business.username') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                </span>
                {!! Form::text('username', null, [
                    'class' => 'form-control',
                    'placeholder' => __('business.username'),
                    'required',
                ]) !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('email', __('business.email') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-envelope"></i>
                </span>
                {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('business.email'), 'required']) !!}
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('password', __('business.password') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-lock"></i>
                </span>
                {!! Form::password('password', [
                    'class' => 'form-control',
                    'placeholder' => __('business.password'),
                    'required',
                ]) !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('confirm_password', __('business.confirm_password') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-lock"></i>
                </span>
                {!! Form::password('confirm_password', [
                    'class' => 'form-control',
                    'placeholder' => __('business.confirm_password'),
                    'required',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('business_logo', __('business.upload_logo') . ':') !!}
            {!! Form::file('business_logo', ['accept' => 'image/*']) !!}
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('camera_details', 'Camera Details:*') !!}
            <div class="input-group">
                {!! Form::textArea('camera_details', null, ['class' => 'form-control', 'placeholder' => 'Camera Details', 'required']) !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        @if (!empty($system_settings['superadmin_enable_register_tc']))
            <div class="form-group">
                <label>
                    {!! Form::checkbox('accept_tc', 0, false, ['required', 'class' => 'input-icheck']) !!}
                    <u><a class="terms_condition cursor-pointer" data-toggle="modal" data-target="#tc_modal">
                            @lang('lang_v1.accept_terms_and_conditions') <i></i>
                        </a></u>
                </label>
            </div>
            @include('business.partials.terms_conditions')
        @endif
    </div>
    <div class="clearfix"></div>
    <div class="clearfix"></div>
    <div class="col-md-12">
        <button type="submit"  class="btn bg-custom-button btn-block"><strong>Register</strong></button>
    </div>
    <div class="clearfix"></div>
</fieldset>

