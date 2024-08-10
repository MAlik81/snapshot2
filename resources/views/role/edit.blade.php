@extends('layouts.app')
@section('title', __('role.edit_role'))

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>@lang('role.edit_role')</h1>
    </section>

    <!-- Main content -->
    <section class="content">

        @component('components.widget', ['class' => 'box-primary'])
            {!! Form::open([
                'url' => action([\App\Http\Controllers\RoleController::class, 'update'], [$role->id]),
                'method' => 'PUT',
                'id' => 'role_form',
            ]) !!}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('name', __('user.role_name') . ':*') !!}
                        {!! Form::text('name', str_replace('#' . auth()->user()->business_id, '', $role->name), [
                            'class' => 'form-control',
                            'required',
                            'placeholder' => __('user.role_name'),
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label>@lang('user.permissions'):</label>
                </div>
            </div>

            <div class="row check_group">
                <div class="col-md-1">
                    <h4>@lang('lang_v1.others')</h4>
                </div>
                <div class="col-md-2">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="check_all input-icheck"> {{ __('role.select_all') }}
                        </label>
                    </div>
                </div>
                <div class="col-md-9">
                    @if (in_array('service_staff', $enabled_modules))
                        <div class="col-md-12">
                            <div class="checkbox">
                                <label>
                                    {!! Form::checkbox('is_service_staff', 1, $role->is_service_staff, ['class' => 'input-icheck']) !!} {{ __('restaurant.service_staff') }}
                                </label>
                                @show_tooltip(__('restaurant.tooltip_service_staff'))
                            </div>
                        </div>
                    @endif

                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'view_export_buttons', in_array('view_export_buttons', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} {{ __('lang_v1.view_export_buttons') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>



            <hr>
            <div class="row check_group">
                <div class="col-md-1">
                    <h4>@lang('role.user')</h4>
                </div>
                <div class="col-md-2">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="check_all input-icheck"> {{ __('role.select_all') }}
                        </label>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'user.view', in_array('user.view', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} {{ __('role.user.view') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'user.create', in_array('user.create', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} {{ __('role.user.create') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'user.update', in_array('user.update', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} {{ __('role.user.update') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'user.delete', in_array('user.delete', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} {{ __('role.user.delete') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>


            <hr>
            <div class="row check_group">
                <div class="col-md-1">
                    <h4>@lang('user.roles')</h4>
                </div>
                <div class="col-md-2">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="check_all input-icheck"> {{ __('role.select_all') }}
                        </label>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'roles.view', in_array('roles.view', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} {{ __('lang_v1.view_role') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'roles.create', in_array('roles.create', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} {{ __('role.add_role') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'roles.update', in_array('roles.update', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} {{ __('role.edit_role') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'roles.delete', in_array('roles.delete', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} {{ __('lang_v1.delete_role') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>



            <hr>
            <div class="row check_group">
                <div class="col-md-3">
                    <h4>Events</h4>
                </div>
                <div class="col-md-2">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="check_all input-icheck"> {{ __('role.select_all') }}
                        </label>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event.view', in_array('event.view', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} View
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event.create', in_array('event.create', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} Add
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event.update', in_array('event.update', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} Edit
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event.delete', in_array('event.delete', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} Delete
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event.manage', in_array('event.manage', $role_permissions), ['class' => 'input-icheck']) !!} Manage Event Settings
                            </label>
                        </div>
                    </div>

                </div>
            </div>



            <hr>
            <div class="row check_group">
                <div class="col-md-3">
                    <h4>Event Albums</h4>
                </div>
                <div class="col-md-2">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="check_all input-icheck"> {{ __('role.select_all') }}
                        </label>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event_albums.view', in_array('event_albums.view', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} View
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event_albums.create', in_array('event_albums.create', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} Add
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event_albums.update', in_array('event_albums.update', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} Edit
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event_albums.delete', in_array('event_albums.delete', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} Delete
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <div class="row check_group">
                <div class="col-md-3">
                    <h4>Event Photos</h4>
                </div>
                <div class="col-md-2">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="check_all input-icheck"> {{ __('role.select_all') }}
                        </label>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event_photos.view', in_array('event_photos.view', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} View
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event_photos.create', in_array('event_photos.create', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} Add
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event_photos.update', in_array('event_photos.update', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} Edit
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event_photos.delete', in_array('event_photos.delete', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} Delete
                            </label>
                        </div>
                    </div>
                </div>
            </div>




            <hr>
            <div class="row check_group">
                <div class="col-md-3">
                    <h4>Minor / Protected Photos</h4>
                </div>
                <div class="col-md-2">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="check_all input-icheck"> {{ __('role.select_all') }}
                        </label>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'minor_photos.view', in_array('minor_photos.view', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} View
                            </label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'minor_photos.delete', in_array('minor_photos.delete', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} Delete
                            </label>
                        </div>
                    </div>
                </div>
            </div>


            <hr>
            <div class="row check_group">
                <div class="col-md-3">
                    <h4>@lang('sale.sale') @show_tooltip(__('lang_v1.sell_permissions_tooltip'))</h4>
                </div>
                <div class="col-md-2">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="check_all input-icheck"> {{ __('role.select_all') }}
                        </label>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'view_all_sales', in_array('view_all_sales', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} View All sales
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'view_event_sales', in_array('view_event_sales', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} View Event sales
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'view_own_sales', in_array('view_own_sales', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} View Own sales
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <div class="row check_group">
                <div class="col-md-3">
                    <h4>Withdrawals</h4>
                </div>
                <div class="col-md-2">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="check_all input-icheck"> {{ __('role.select_all') }}
                        </label>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'manage_withdrawals', in_array('manage_withdrawals', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} Manage Withdrawals
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <hr>



            <div class="row check_group">
                <div class="col-md-1">
                    <h4>@lang('role.settings')</h4>
                </div>
                <div class="col-md-2">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="check_all input-icheck"> {{ __('role.select_all') }}
                        </label>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox(
                                    'permissions[]',
                                    'business_settings.access',
                                    in_array('business_settings.access', $role_permissions),
                                    ['class' => 'input-icheck'],
                                ) !!} {{ __('role.business_settings.access') }}
                            </label>
                        </div>
                    </div>

                </div>
            </div>




            <hr>
            <div class="row">
                <div class="col-md-3">
                    <h4>@lang('role.dashboard')</h4>
                </div>
                <div class="col-md-9">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'dashboard.data', in_array('dashboard.data', $role_permissions), [
                                    'class' => 'input-icheck',
                                ]) !!} {{ __('role.dashboard.data') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>



            @include('role.partials.module_permissions')
            <div class="row">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary btn-big">@lang('messages.update')</button>
                </div>
            </div>

            {!! Form::close() !!}
        @endcomponent
    </section>
    <!-- /.content -->
@endsection
