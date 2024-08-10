<!-- resources/views/event-management/create.blade.php -->

@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>Create new album</h1>
    </section>

    <section class="content">
        @component('components.widget', ['class' => 'box-primary'])
            {!! Form::model($eventalbum, [
                'route' => ['event-albums.update', $eventalbum->id],
                'method' => 'put',
                'id' => 'event-albums',
            ]) !!}

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('name', 'Album Name:*') !!}
                        {!! Form::text('name', $eventalbum->name, ['class' => 'form-control', 'required', 'placeholder' => 'Event Name']) !!}
                    </div>
                </div>
            </div>


            <button type="submit" class="btn btn-primary">Save</button>
            <a type="button" class="btn  btn-default"
                href="{{ action([\App\Http\Controllers\EventManagementController::class, 'show'], [session()->get('event_id')]) }}">Back</a>

            {!! Form::close() !!}
        @endcomponent
    </section>
@endsection

@section('javascript')
   
@endsection
