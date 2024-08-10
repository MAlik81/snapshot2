

<div class="pos-tab-content">
    <div class="row">
        @component('components.widget', [
            'class' => 'box-primary',
            'title' => 'Manage images overlay',
        ])
        {{-- Settings Form --}}
        {!! Form::open(['url' => route('overlay.upload'), 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
        <input type="hidden" name="event_id" value="{{ $event->id }}">
        <input type="hidden" name="overlay_id" value="{{ ($overlay)?$overlay->id:null }}">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('overlay_image', 'Overlay Image') !!}
                {!! Form::file('overlay_image', ['class' => 'form-control', 'accept' => 'image/*', 'required']) !!}
            </div>
        </div>
        <input type="hidden" name="position" id="position" value="center">
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('enabled', 'Enable Overlay') !!}
                {!! Form::checkbox('enabled', 2, ($overlay)?$overlay->enabled:false,) !!}
            </div>
        </div>
        <div class="form-group col-md-3">
            {!! Form::submit('Upload and Save Settings', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
        @endcomponent
    </div>

    {{-- Display Image --}}
    <div class="col-md-12">
        <img src="https://t4.ftcdn.net/jpg/05/49/86/39/360_F_549863991_6yPKI08MG7JiZX83tMHlhDtd6XLFAMce.jpg" alt="" 
        style="width: 100%;border-radius:20px;overflow:hidden;margin:0 auto;">
    <div id="overlay_div" style="border-radius:20px;overflow:hidden;margin:0 auto;position: absolute;width:98%;height:100%;top:0px;opacity: 0.2;background-size: 300px;background-repeat: repeat;" ></div>
    </div>
</div>
<!-- resources/views/overlay.blade.php -->


{{-- Display Image --}}

