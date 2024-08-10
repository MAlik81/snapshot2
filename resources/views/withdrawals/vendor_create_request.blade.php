@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>Create Withdrawal Request</h1>
    </section>

    <section class="content">
        @component('components.widget', ['class' => 'box-primary'])
            {!! Form::open([
                'url' => action([\App\Http\Controllers\WithdrawalController::class, 'requestStore']),
                'method' => 'post',
                'id' => 'card-form',
                'enctype' => 'multipart/form-data', // Add this line for multipart/form-data encoding
            ]) !!}
            <div class="modal-body">
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('requested_amount', 'Amount:*') !!}
                            {!! Form::number('requested_amount', null, [
                                'class' => 'form-control',
                                'required',
                                'placeholder' => '1000',
                                'min' => 50,
                                'max' => round($available_amount, 2),
                            ]) !!}
                            <small id="requested_amountHelp" class="form-text text-muted">You have ${{ round($available_amount, 2) }} in you accont to withdraw.</small>
                            <small id="requested_amountHelp" class="form-text text-muted">You can send the withdraw request for minunmum $50</small>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <a type="button" class="btn  btn-default"
                    href="{{ action([\App\Http\Controllers\EventManagementController::class, 'index']) }}">Back</a>
            </div>

            {!! Form::close() !!}
        @endcomponent
    </section>
@endsection