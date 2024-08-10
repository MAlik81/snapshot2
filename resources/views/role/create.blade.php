@extends('layouts.app')
@section('title', __('role.add_role'))

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>@lang('role.add_role')</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        @php
            $pos_settings = !empty(session('business.pos_settings')) ? json_decode(session('business.pos_settings'), true) : [];
        @endphp
        @component('components.widget', ['class' => 'box-primary'])
            {!! Form::open([
                'url' => action([\App\Http\Controllers\RoleController::class, 'store']),
                'method' => 'post',
                'id' => 'role_add_form',
            ]) !!}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('name', __('user.role_name') . ':*') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('user.role_name')]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label>@lang('user.permissions'):</label>
                </div>
            </div>

            <hr>
            <div class="row check_group">
                <div class="col-md-3">
                    <h4>@lang('role.user')</h4>
                </div>
                <div class="col-md-2">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="check_all input-icheck"> {{ __('role.select_all') }}
                        </label>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'user.view', false, ['class' => 'input-icheck']) !!} {{ __('role.user.view') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'user.create', false, ['class' => 'input-icheck']) !!} {{ __('role.user.create') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'user.update', false, ['class' => 'input-icheck']) !!} {{ __('role.user.update') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'user.delete', false, ['class' => 'input-icheck']) !!} {{ __('role.user.delete') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>


            <hr>
            <div class="row check_group">
                <div class="col-md-3">
                    <h4>@lang('user.roles')</h4>
                </div>
                <div class="col-md-2">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="check_all input-icheck"> {{ __('role.select_all') }}
                        </label>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'roles.view', false, ['class' => 'input-icheck']) !!} {{ __('lang_v1.view_role') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'roles.create', false, ['class' => 'input-icheck']) !!} {{ __('role.add_role') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'roles.update', false, ['class' => 'input-icheck']) !!} {{ __('role.edit_role') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'roles.delete', false, ['class' => 'input-icheck']) !!} {{ __('lang_v1.delete_role') }}
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
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event.view', false, ['class' => 'input-icheck']) !!} View
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event.create', false, ['class' => 'input-icheck']) !!} Add
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event.update', false, ['class' => 'input-icheck']) !!} Edit
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event.delete', false, ['class' => 'input-icheck']) !!} Delete
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event.manage', false, ['class' => 'input-icheck']) !!} Manage Event Settings
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
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event_albums.view', false, ['class' => 'input-icheck']) !!} View
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event_albums.create', false, ['class' => 'input-icheck']) !!} Add
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event_albums.update', false, ['class' => 'input-icheck']) !!} Edit
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event_albums.delete', false, ['class' => 'input-icheck']) !!} Delete
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
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event_photos.view', false, ['class' => 'input-icheck']) !!} View
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event_photos.create', false, ['class' => 'input-icheck']) !!} Add
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event_photos.update', false, ['class' => 'input-icheck']) !!} Edit
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'event_photos.delete', false, ['class' => 'input-icheck']) !!} Delete
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
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'minor_photos.view', false, ['class' => 'input-icheck']) !!} View
                            </label>
                        </div>
                    </div>
                  
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'minor_photos.delete', false, ['class' => 'input-icheck']) !!} Delete
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
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'view_all_sales', false, ['class' => 'input-icheck']) !!} View All sales
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'view_event_sales', false, ['class' => 'input-icheck']) !!} View Event sales
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'view_own_sales', false, ['class' => 'input-icheck']) !!} View Own sales
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
                    <div class="col-md-32">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'manage_withdrawals', false, [
                                    'class' => 'input-icheck',
                                ]) !!} Manage Withdrawals
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            @if (!empty($pos_settings['enable_sales_order']))
                <div class="row check_group">
                    <div class="col-md-3">
                        <h4>@lang('lang_v1.sales_order')</h4>
                    </div>
                    <div class="col-md-2">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="check_all input-icheck"> {{ __('role.select_all') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="col-md-9">
                            <div class="checkbox">
                                <label>
                                    {!! Form::radio('radio_option[so_view]', 'so.view_all', false, ['class' => 'input-icheck']) !!} {{ __('lang_v1.view_all_so') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="checkbox">
                                <label>
                                    {!! Form::radio('radio_option[so_view]', 'so.view_own', false, ['class' => 'input-icheck']) !!} {{ __('lang_v1.view_own_so') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="checkbox">
                                <label>
                                    {!! Form::checkbox('permissions[]', 'so.create', false, ['class' => 'input-icheck']) !!} {{ __('lang_v1.create_so') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="checkbox">
                                <label>
                                    {!! Form::checkbox('permissions[]', 'so.update', false, ['class' => 'input-icheck']) !!} {{ __('lang_v1.edit_so') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="checkbox">
                                <label>
                                    {!! Form::checkbox('permissions[]', 'so.delete', false, ['class' => 'input-icheck']) !!} {{ __('lang_v1.delete_so') }}
                                </label>
                            </div>
                        </div>

                    </div>
                </div>


                <hr>
            @endif
           
            
            <div class="row check_group">
                <div class="col-md-3">
                    <h4>@lang('role.settings')</h4>
                </div>
                <div class="col-md-2">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="check_all input-icheck"> {{ __('role.select_all') }}
                        </label>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'business_settings.access', false, ['class' => 'input-icheck']) !!} {{ __('role.business_settings.access') }}
                            </label>
                        </div>
                    </div>
                    {{-- <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'barcode_settings.access', false, ['class' => 'input-icheck']) !!} {{ __('role.barcode_settings.access') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'invoice_settings.access', false, ['class' => 'input-icheck']) !!} {{ __('role.invoice_settings.access') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'access_printers', false, ['class' => 'input-icheck']) !!}
                                {{ __('lang_v1.access_printers') }}
                            </label>
                        </div>
                    </div> --}}
                </div>
            </div>
            @if (in_array('expenses', $enabled_modules))
                <hr>
                <div class="row check_group">
                    <div class="col-md-3">
                        <h4>@lang('lang_v1.expense')</h4>
                    </div>
                    <div class="col-md-2">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="check_all input-icheck"> {{ __('role.select_all') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="col-md-9">
                            <div class="checkbox">
                                <label>
                                    {!! Form::radio('radio_option[expense_view]', 'all_expense.access', false, ['class' => 'input-icheck']) !!} {{ __('lang_v1.access_all_expense') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="checkbox">
                                <label>
                                    {!! Form::radio('radio_option[expense_view]', 'view_own_expense', false, ['class' => 'input-icheck']) !!}
                                    {{ __('lang_v1.view_own_expense') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="checkbox">
                                <label>
                                    {!! Form::checkbox('permissions[]', 'expense.add', false, ['class' => 'input-icheck']) !!} {{ __('expense.add_expense') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="checkbox">
                                <label>
                                    {!! Form::checkbox('permissions[]', 'expense.edit', false, ['class' => 'input-icheck']) !!} {{ __('expense.edit_expense') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="checkbox">
                                <label>
                                    {!! Form::checkbox('permissions[]', 'expense.delete', false, ['class' => 'input-icheck']) !!} {{ __('lang_v1.delete_expense') }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            @endif


            <hr>
            <div class="row check_group">
                <div class="col-md-3">
                    <h4>@lang('role.dashboard') @show_tooltip(__('tooltip.dashboard_permission'))</h4>
                </div>
                <div class="col-md-7">
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'dashboard.data', true, ['class' => 'input-icheck']) !!} {{ __('role.dashboard.data') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>


            <hr>
            <div class="row check_group" style="display: none;">
                <div class="col-md-3">
                    <h4>@lang('account.account')</h4>
                </div>
                <div class="col-md-7">
                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'account.access', false, ['class' => 'input-icheck']) !!} {{ __('lang_v1.access_accounts') }}
                            </label>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'edit_account_transaction', false, ['class' => 'input-icheck']) !!} {{ __('lang_v1.edit_account_transaction') }}
                            </label>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'delete_account_transaction', false, ['class' => 'input-icheck']) !!} {{ __('lang_v1.delete_account_transaction') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>


           

            @include('role.partials.module_permissions')
            <div class="row">
                <div class="col-md-32 text-center">
                    <button type="submit" class="btn btn-primary btn-big">@lang('messages.save')</button>
                </div>
            </div>

            {!! Form::close() !!}
        @endcomponent
    </section>
    <!-- /.content -->
@endsection
