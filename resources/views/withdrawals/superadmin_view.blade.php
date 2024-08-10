@extends('layouts.app')
@section('title', __('user.roles'))

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Withdraw requests from all vendors
            <small>Manage withdraw requests from all vendors</small>
        </h1>
        <!-- <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                    <li class="active">Here</li>
                </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">
        @component('components.widget', ['class' => 'box-primary', 'title' => 'All Withdraw requests'])
            <div class="row">

                <div class="col-md-2">
                    <div class="form-group card-body">
                        {!! Form::label('last_name', 'Total Platform Sales') !!}
                        <div class="form-control">${{ $total_platform_sales ? round($total_platform_sales, 2) : 0 }}</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group card-body">
                        {!! Form::label('last_name', 'Total Platform Share') !!}
                        <div class="form-control">${{ $total_platform_share ? round($total_platform_share, 2) : 0 }}</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group card-body">
                        {!! Form::label('last_name', 'Total Vendors Share') !!}
                        <div class="form-control">${{ $total_vendors_share ? round($total_vendors_share, 2) : 0 }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group card-body">
                        {!! Form::label('last_name', 'Approved Withdrawals') !!}
                        <div class="form-control">${{ $total_withdrawn ? round($total_withdrawn, 2) : 0 }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group card-body">
                        {!! Form::label('last_name', 'Pending Withdrawals') !!}
                        <div class="form-control">${{ $pending_withdrawals ? round($pending_withdrawals, 2) : 0 }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group card-body">
                        {!! Form::label('last_name', 'Total Remaing Amount(available for withdrawals)') !!}
                        <div class="form-control">
                            ${{ $total_vendors_share - $total_withdrawn ? round($total_vendors_share - $total_withdrawn, 2) : 0 }}
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped" id="vendors_withdrawal_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Action</th>
                        <th>Business</th>
                        <th>Amount</th>
                        <th>Request Date</th>
                        <th>Aproval Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($withdrawns as $key => $withdrawal)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                {{-- <a href="{{ route('withdrawals.show', $withdrawal->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> View</a> --}}
                                @if ($withdrawal->status == 'pending')
                                    <button class="btn btn-danger btn-xs decline_withdrawal"
                                        data-id="{{ $withdrawal->id }}">Decline</button>
                                    <button class="btn btn-success btn-xs approve_withdrawal"
                                        data-id="{{ $withdrawal->id }}">Approve</button>
                                @endif
                            </td>
                            <td>{{ $withdrawal->business_name }}({{ $withdrawal->business_id }})</td>
                            <td>{{ $withdrawal->requested_amount }}</td>
                            <td>{{ $withdrawal->request_date }}</td>
                            <td>{{ $withdrawal->approval_date }}</td>
                            <td>
                                @if ($withdrawal->status == 'pending')
                                    <span class="label label-warning">Pending</span>
                                @elseif ($withdrawal->status == 'approved')
                                    <span class="label label-success">Approved</span>
                                @elseif ($withdrawal->status == 'declined')
                                    <span class="label label-danger">Rejected</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        @endcomponent
    </section>
    <!-- /.content -->
@stop
@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#vendors_withdrawal_table').DataTable({
                responsive: true,
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.decline_withdrawal').click(function() {
                console.log('clicked');
                var id = $(this).data('id');
                var url = '{{ route('withdrawals.decline', ['id' => '']) }}' + id;
                var confirm_msg = 'Are you sure you want to decline this withdrawal?';

                swal({
                    title: "Confirmation",
                    text: confirm_msg,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDecline) => {
                    if (willDecline) {
                        // Open popup modal with textarea input
                        swal({
                            title: "Reason for Decline",
                            text: "Enter reason here:",
                            content: {
                                element: "input",
                                attributes: {
                                    placeholder: "Enter reason here",
                                    type: "text",
                                    id: "reason-textarea"
                                },
                            },
                            buttons: {
                                cancel: true,
                                confirm: {
                                    text: "Submit",
                                    closeModal: false,
                                }
                            }
                        }).then((willSubmit) => {
                            if (willSubmit) {
                                const reason = document.getElementById('reason-textarea')
                                    .value;
                                if (!reason) {
                                    swal("Please enter a reason");
                                    return;
                                }
                                console.log(reason);
                                // Send reason along with the request
                                $.ajax({
                                    url: url,
                                    type: 'POST',
                                    data: {
                                        reason: reason
                                    },
                                    success: function(data) {
                                        swal("Success", data.msg, "success");
                                        setTimeout(function() {
                                            location.reload();
                                        }, 2000);
                                    },
                                    error: function(data) {
                                        swal("Error", data.msg,
                                            "error");
                                        setTimeout(function() {
                                            location.reload();
                                        }, 2000);
                                    }
                                });
                            }
                        });

                    }
                });
            });

            $('.approve_withdrawal').click(function() {
    console.log('clicked');
    var id = $(this).data('id');
    var url = '{{ route('withdrawals.approve', ['id' => '']) }}' + id;
    var confirm_msg = 'Are you sure you want to approve this withdrawal?';

    swal({
        title: "Confirmation",
        text: confirm_msg,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willApprove) => {
        if (willApprove) {
            // Open popup modal with file input
            swal({
                title: "Proof of Delivery",
                content: {
                    element: "input",
                    attributes: {
                        type: "file",
                        accept: ".jpg, .jpeg, .png, .pdf",
                        id: "proof_file_input"
                    }
                },
                buttons: {
                    cancel: true,
                    confirm: {
                        text: "Submit",
                        closeModal: false,
                    }
                },
            }).then((willSubmit) => {
                if (willSubmit) {
                    var formData = new FormData();
                    var fileInput = document.getElementById('proof_file_input');
                    var file = fileInput.files[0];

                    if (file) {
                        formData.append('proof_file', file);
                    }

                    // Send the request
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            swal("Success", data.msg, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        },
                        error: function(data) {
                            swal("Error", data.msg, "error");
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        }
                    });
                }
            });
        }
    });
});

        });
    </script>
@endsection
