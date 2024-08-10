@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | Business')

@section('content')
    @include('superadmin::layouts.nav')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>@lang('superadmin::lang.view_business')
            <small> {{ $business->name }}</small>
        </h1>
        <!-- <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
            <li class="active">Here</li>
        </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">
        
        
        

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    <strong><i class="fa fa-refresh margin-r-5"></i>
                        @lang('superadmin::lang.package_subscription')</strong>
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class ="col-xs-12">
                        <!-- location table-->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Package Name</th>
                                    <th>Start Date</th>
                                    <th>Trail End Date</th>
                                    <th>End Date</th>
                                    <th>Paid Via</th>
                                    <th>Payment Transaction ID</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($business->subscriptions as $subscription)
                                    <tr>
                                        <td>{{ $subscription->package_details['name'] }}</td>
                                        <td>
                                            @if (!empty($subscription->start_date))
                                                {{ @format_date($subscription->start_date) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (!empty($subscription->trial_end_date))
                                                {{ @format_date($subscription->trial_end_date) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (!empty($subscription->end_date))
                                                {{ @format_date($subscription->end_date) }}
                                            @endif
                                        </td>
                                        <td>{{ $subscription->paid_via }}</td>
                                        <td>{{ $subscription->payment_transaction_id }}</td>
                                        <td>{{ $subscription->created_at }}</td>
                                        <td>
                                            @if (!empty($subscription->created_user))
                                                {{ $subscription->created_user->user_full_name }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @component('components.widget', ['class' => 'box-default', 'title' => __('user.all_users')])
            @can('user.view')
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="users_table">
                        <thead>
                            <tr>
                                <th>@lang('business.username')</th>
                                <th>@lang('user.name')</th>
                                <th>@lang('user.role')</th>
                                <th>@lang('business.email')</th>
                                <th>@lang('messages.action')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            @endcan
        @endcomponent

        @include('superadmin::business.update_password_modal')
    </section>
    <!-- /.content -->
@stop
@section('javascript')
    <script type="text/javascript">
        //Roles table
        $(document).ready(function() {
            var users_table = $('#users_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/superadmin/users/' + "{{ $business->id }}",
                columnDefs: [{
                    "targets": [4],
                    "orderable": false,
                    "searchable": false
                }],
                "columns": [{
                        "data": "username"
                    },
                    {
                        "data": "full_name"
                    },
                    {
                        "data": "role"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "action"
                    }
                ]
            });

        });

        $(document).on('click', '.update_user_password', function(e) {
            e.preventDefault();
            $('form#password_update_form, #user_id').val($(this).data('user_id'));
            $('span#user_name').text($(this).data('user_name'));
            $('#update_password_modal').modal('show');
        });

        password_update_form_validator = $('form#password_update_form').validate();

        $('#update_password_modal').on('hidden.bs.modal', function() {
            password_update_form_validator.resetForm();
            $('form#password_update_form')[0].reset();
        });

        $(document).on('submit', 'form#password_update_form', function(e) {
            e.preventDefault();
            $(this)
                .find('button[type="submit"]')
                .attr('disabled', true);
            var data = $(this).serialize();
            $.ajax({
                method: 'post',
                url: $(this).attr('action'),
                dataType: 'json',
                data: data,
                success: function(result) {
                    if (result.success == true) {
                        $('#update_password_modal').modal('hide');
                        toastr.success(result.msg);
                    } else {
                        toastr.error(result.msg);
                    }
                    $('form#password_update_form')
                        .find('button[type="submit"]')
                        .attr('disabled', false);
                },
            });
        });
    </script>
@endsection
