@extends('layouts.app')
@section('title', __('user.roles'))

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Withdrawals
            <small>Manage Withdrawals</small>
        </h1>
        <!-- <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
            <li class="active">Here</li>
        </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">
        @component('components.widget', ['class' => 'box-primary', 'title' => 'All Withdraw requests'])
            @slot('tool')
                <div class="box-tools">
                    <a class="btn btn-block btn-primary"
                        href="{{ action([\App\Http\Controllers\WithdrawalController::class, 'requestCreate']) }}">
                        <i class="fa fa-plus"></i>Request Withdrawal</a>
                </div>
            @endslot
            <div class="row">

                <div class="col-md-2">
                    <div class="form-group card-body">
                        {!! Form::label('last_name', 'Total Sales') !!}
                        <div class="form-control">${{ $total_amount ? round($total_amount, 2) : 0 }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group card-body">
                        {!! Form::label('last_name', 'Approved Withdrawals($)') !!}
                        <div class="form-control">${{ $total_withdrawn ? round($total_withdrawn, 2) : 0 }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group card-body">
                        {!! Form::label('last_name', 'Pending Withdrawals($)') !!}
                        <div class="form-control">${{ $pending_withdrawals ? round($pending_withdrawals, 2) : 0 }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group card-body">
                        {!! Form::label('last_name', 'Total Remaing Amount($)(available for withdrawals)') !!}
                        <div class="form-control">
                            ${{ $total_amount - $total_withdrawn - $pending_withdrawals ? round($total_amount - $total_withdrawn - $pending_withdrawals, 2) : 0 }}
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped" id="vendors_withdrawal_table">
                <thead>
                    <tr>
                        <th>Id</th>
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
                            <td>{{ $withdrawal->requested_amount }}</td>
                            <td>{{ $withdrawal->request_date }}</td>
                            <td>{{ $withdrawal->approval_date }}</td>
                            <td>
                                @if ($withdrawal->status == 'pending')
                                    <span class="label label-warning">Pending</span>
                                @elseif ($withdrawal->status == 'approved')
                                    <span class="label label-success">Approved</span>
                                    @if (!empty($withdrawal->proof_path))
                                        <a href="<?= asset('uploads/proofs/'.basename($withdrawal->proof_path)) ?>" target="_blank">View Proof</a>
                                    @endif
                                @elseif ($withdrawal->status == 'declined')
                                    <span class="label label-danger">Declined</span>
                                    @if (!empty($withdrawal->decline_reason))
                                        <button type="button" class="btn btn-link" data-toggle="modal"
                                            data-target="#declineReasonModal{{ $withdrawal->id }}">View Reason</button>
                                        <div class="modal fade" id="declineReasonModal{{ $withdrawal->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="declineReasonModalLabel{{ $withdrawal->id }}">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"
                                                            id="declineReasonModalLabel{{ $withdrawal->id }}">Decline Reason
                                                        </h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{ $withdrawal->decline_reason }}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
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
        //Roles table
    </script>
@endsection
