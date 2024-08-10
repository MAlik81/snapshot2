@extends('layouts.app')
@section('title', 'Albums')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}">Home</a></li>
                <li><a href="{{ action([\App\Http\Controllers\EventManagementController::class, 'index']) }}">Events</a></li>
                <li><a href="{{action([\App\Http\Controllers\EventManagementController::class, 'show'], [$event->id])}}"> {{ $event->name }}</a></li>
                <li class="active">Event Albums</li>
            </ol>
        </div>
        <h1> &nbsp;&nbsp; {{ $event->name }} <small>(albums)</small></h1>

    </section>
    <div class="container">
        <!-- Main content -->
        <section class="content">

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Manage Albums</h3>
                    @can('event_albums.create')
                        <div class="box-tools">
                            <a type="button" class="btn btn-block btn-primary" href="{{ action([\App\Http\Controllers\EventalbumsController::class, 'create']) }}">
                                <i class="fa fa-plus"></i> @lang('messages.add')</a>
                        </div>
                    @endcan
                </div>
                <div class="box-body">
                    @foreach ($albums as $album)
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box info-box-new-style">
                            <span class="info-box-icon bg-blue"><i class="ion-ios-film-outline" style="font-size: 60px !important;"></i></span>

                            <div class="info-box-content">
                                <a href="{{ action([\App\Http\Controllers\EventalbumsController::class, 'show'], [$album->id]) }}">
                                    
                                    <span class="info-box-text">{{ $album->name }}</span>
                                </a>
                                <a class="btn btn-success btn-xs pull-right" style="margin-right: 5px;" href="{{ action([\App\Http\Controllers\EventalbumsController::class, 'show'], [$album->id]) }}">
                                    
                                    <span class="info-box-number text-right" style="font-size: 12px;" ><i class="fa fa-eye"></i></span>
                                </a>
                                <a class="btn btn-warning btn-xs pull-right" style="margin-right: 5px;" href="{{ action([\App\Http\Controllers\EventalbumsController::class, 'edit'], [$album->id]) }}">
                                    
                                    <span class="info-box-number text-right"  style="font-size: 12px;" ><i class="fa fa-edit"></i></span>
                                </a>
                                
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                       
                    @endforeach

                </div>
            </div>
        </section>
    </div>
@endsection
