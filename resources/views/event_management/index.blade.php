@extends('layouts.app')

@section('title', 'Event Management | Events')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Event Management</h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">All Your events</h3>
                @can('event.create')
                    <div class="box-tools">
                        <a type="button" class="btn btn-block btn-primary"
                            href="{{ action([\App\Http\Controllers\EventManagementController::class, 'create']) }}">
                            <i class="fa fa-plus"></i> @lang('messages.add')</a>
                    </div>
                @endcan
            </div>
            <div class="box-body">

                <div style="width: 100%">
                    <table class="table table-bordered table-striped" id="event_table">
                        <thead>
                            <tr>
                                <th style="width: 15%;">Name</th>
                                <th style="width: 25%;">Location</th>
                                <th style="width: 10%;">Start Date</th>
                                <th style="width: 10%;">End Date</th>
                                <th style="width: 10%;">Created At</th>
                                <th style="width: 10%;">Status</th>
                                <th  style="width: 20%;">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#event_table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: true,
                ajax: {
                    url: "{{ action([\App\Http\Controllers\EventManagementController::class, 'index']) }}",
                },
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'location',
                        name: 'location'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
        });

        $(document).on('click', '.delete-event', function() {
            var id = $(this).data('event-id');
            console.log(id);
            var url = "<?=url('event-management') ?>" + '/' + id;
            var confirm_msg = 'Are you sure you want to delete this event?';

            swal({
                title: "Confirmation",
                text: confirm_msg,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(data) { 
                            if (data.success) {
                                swal("Success", data.msg, "success");
                            } else {
                                swal("Error", data.msg, "error");
                            }
                            $('#event_table').DataTable().ajax.reload();
                        }
                    });
                }

            });
        });
    </script>
@endsection
