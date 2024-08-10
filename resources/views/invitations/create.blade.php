
@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>Invite a collaborator</h1>
    </section>

    <section class="content">
        @component('components.widget', ['class' => 'box-primary'])
            {!! Form::open([
                'url' => route('invitations.store'),
                'method' => 'post',
                'id' => 'event_form',
            ]) !!}


            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('email', 'Collaborator Email') !!}
                            {!! Form::text('email', null, ['class' => 'form-control', 'required', 'placeholder' => 'Photographer Email']) !!}
                        </div>
                    </div>
                   <input type="hidden" name="event_id" value="{{$event_id}}">
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <a type="button" class="btn  btn-default" href="javascript:history.back()">Back</a>
            </div>

            {!! Form::close() !!}
        @endcomponent
    </section>
   

    
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $('#event_form').validate({
            rules: {
                name: 'required',
                location: 'required',
                country: 'required',
                start_date: 'required',
                end_date: 'required',
                timezone: 'required',
                event_type: 'required',
            },
            messages: {
                // Add custom error messages if needed
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });
    });
</script>
<!-- Add this script after including jQuery -->
<script>
    $(document).ready(function() {
        // Initially hide the Per Photo Price section
        $('#per_photo_price_section').hide();

        // Add change event to radio buttons
        $('input[name="photo_option"]').change(function() {
            var selectedOption = $(this).val();

            // Show/hide Per Photo Price based on the selected option
            if (selectedOption === 'sell') {
                $('#per_photo_price_section').show();
            } else {
                $('#per_photo_price_section').hide();
            }
        });
    });
    $('#start_date,#end_date').datetimepicker({
        format: moment_date_format + ' ' + moment_time_format,
        ignoreReadonly: true,
    });
</script>

@endsection