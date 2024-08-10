<!-- resources/views/event-management/create.blade.php -->

@extends('layouts.app')

@section('content')
    <style>
        .img-container {
            height: 500px;
            width: auto;
            overflow: hidden;
        }
    </style>
    <section class="content-header">
        <h1>Create new event</h1>
    </section>

    <section class="content">
        @component('components.widget', ['class' => 'box-primary'])
            {!! Form::open([
                'url' => action([\App\Http\Controllers\EventManagementController::class, 'store']),
                'method' => 'post',
                'id' => 'event_form',
                'enctype' => 'multipart/form-data', // Add this line for multipart/form-data encoding
            ]) !!}

            @php
                $old_data = session()->get('old_data', []);
                if ($old_data) {
                    session()->put('old_data', []);
                }
                // session()->put('old_data', []);
            @endphp

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('name', 'Event Name:*') !!}
                            {!! Form::text('name', $old_data ? $old_data['name'] : null, [
                                'class' => 'form-control',
                                'required',
                                'placeholder' => 'Event Name',
                            ]) !!}
                            <span class="help-block">Event name e.g. '5k trail run'</span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('location', 'Location:*') !!}
                            {!! Form::text('location', $old_data ? $old_data['location'] : null, [
                                'class' => 'form-control',
                                'required',
                                'id' => 'locationInput',
                                'placeholder' => 'Location',
                            ]) !!}
                            <span class="help-block">Google auto load location name.(City,Trail,Road etc.)</span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('country', 'Country:*') !!}
                            {!! Form::text('country', $old_data ? $old_data['country'] : null, [
                                'class' => 'form-control',
                                'required',
                                'placeholder' => 'Country',
                            ]) !!}
                            <span class="help-block">Country name where the event is being organized</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('start_date', 'Start Date:*') !!}
                            {!! Form::text('start_date', $old_data ? $old_data['start_date'] : null, [
                                'class' => 'form-control event_date',
                                'required',
                                'placeholder' => 'Start Date',
                                'readonly',
                            ]) !!}
                            <span class="help-block">Event starting date. (event will be displayed on marketplace after this
                                date)</span>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('end_date', 'End Date:*') !!}
                            {!! Form::text('end_date', $old_data ? $old_data['end_date'] : null, [
                                'class' => 'form-control event_date',
                                'required',
                                'placeholder' => 'End Date',
                                'readonly',
                            ]) !!}
                            <span class="help-block">Event ending date. (event will be displayed on marketplace till this
                                date)</span>

                        </div>
                    </div>
                    <input type="hidden" name="timezone" id="timezone" value="Australia/Sydney">
                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('timezone', 'Timezone:*') !!}
                            <select name="timezone" class="form-control" required>
                                @foreach (\DateTimeZone::listIdentifiers() as $tz)
                                    <option value="{{ $tz }}" @if (old('timezone') == $tz) selected @endif>{{ $tz }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}





                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('event_type', 'Type of Event:*') !!}
                            {!! Form::text('event_type', $old_data ? $old_data['event_type'] : null, [
                                'class' => 'form-control',
                                'required',
                                'placeholder' => 'Type of Event',
                            ]) !!}
                            <span class="help-block">Cycling, marathon, Trail Run, Hiking etc.</span>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('status', 'Event Status') !!}
                            {!! Form::select(
                                'status',
                                [
                                    'active' => 'Active',
                                    'inactive' => 'Inactive',
                                ],
                                null,
                                ['class' => 'form-control', 'required'],
                            ) !!}
                        </div>
                    </div>

                    <!-- Inside the modal-body div -->
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('photo_option', 'Photo Option:*') !!}
                            {!! Form::select(
                                'photo_option',
                                [
                                    'sell' => 'Sell Photos',
                                    'free' => 'Share Photos for Free',
                                ],
                                $old_data ? $old_data['photo_option'] : 'free',
                                ['class' => 'form-control', 'required'],
                            ) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div id="per_photo_price_section">
                            <!-- Per Photo Price -->
                            <div class="col-md-4" class="per_photo_price_section">
                                <div class="form-group">
                                    {!! Form::label('per_photo_price', 'Per Photo Price:*') !!}
                                    {!! Form::text('per_photo_price', null, [
                                        'class' => 'form-control input_number',
                                        'placeholder' => '0.00',
                                        'pattern' => '[0-9]+(\.[0-9]{1,2})?',
                                    ]) !!}
                                    <span class="help-block">For high resolution digital download (orignal upload).</span>

                                </div>
                            </div>
                            <!-- Per Photo Price -->
                            <div class="col-md-4" class="per_photo_price_section">
                                <div class="form-group">
                                    {!! Form::label('low_quality_per_photo_price', 'Price For Social Media Resolution:*') !!}
                                    {!! Form::text('low_quality_per_photo_price', null, [
                                        'class' => 'form-control input_number',
                                        'placeholder' => '0.00',
                                        'pattern' => '[0-9]+(\.[0-9]{1,2})?',
                                    ]) !!}
                                    <span class="help-block">For low resolution digital download (resized according to settings).</span>

                                </div>
                            </div>
                            <div class="col-md-4" class="per_photo_price_section">
                                <div class="form-group">
                                    {!! Form::label('low_quality', 'Social Media Photo Compression Rate (%):*') !!}
                                    <input type="range" name="low_quality" min="10" max="90" value="30"
                                        class="form-control-range" oninput="updateRangeValue(this.value)">

                                    <h5 class="text-center"><span id="rangeValue">30</span>%</h5>
                                    <span class="help-block">Low quality resolution (the resized photo will be the accoring to
                                        this
                                        setting).</span>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-md-9">
                        {!! Form::label('event_cover', 'Event Cover:*') !!}
                        <input type="file" name="event_cover_selector" id="imageInput" required onchange="previewImage(event)"
                            accept="image/*" />
                        <input type="hidden" value="" name="event_cover" id="event_cover_croped">


                    </div>
                    <div class="col-md-3">
                        <div style="padding:5px;border:1px solid #010101;">
                            <img id="imagePreview" src="#" alt="Selected Image" style="display: none; max-width: 100%;" />
                        </div>
                    </div>
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


        <div id="cropperModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="cropperModalLabel"
            aria-hidden="true" style="max-height: 100%">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cropperModalLabel">Crop Image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <img id="cropperImage" src="#" alt="Cropped Image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="cropImage">Crop</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?= env('GOOGLE_MAP_API_KEY') ?>&libraries=places">
    </script>



    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('cropperImage');
                output.src = reader.result;
                $('#cropperModal').modal('show');
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        var cropper;
        $('#cropperModal').on('shown.bs.modal', function() {
            var image = document.getElementById('cropperImage');
            if (cropper) {
                cropper.destroy();
            }
            cropper = new Cropper(image, {
                aspectRatio: 1 / 1,
                viewMode: 2, // restrict the crop box to the canvas size
                dragMode: 'move',
                autoCropArea: 0.8,
                restore: false,
                guides: true,
                center: true,
                highlight: false,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
                ready: function() {
                    // Fit the image to the cropper on initial load
                    var containerData = cropper.getContainerData();
                    var imageData = cropper.getImageData();
                    var aspectRatio = imageData.width / imageData.height;
                    var zoomRatio = containerData.width / imageData.width;

                    if (aspectRatio < 1) {
                        zoomRatio = containerData.height / imageData.height;
                    }

                    cropper.zoomTo(zoomRatio);
                }
            });
        }).on('hidden.bs.modal', function() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        });

        document.getElementById('cropImage').addEventListener('click', function() {
            var canvas = cropper.getCroppedCanvas({
                width: 1080,
                height: 1080,
                fillColor: '#fff',
                imageSmoothingEnabled: false,
                imageSmoothingQuality: 'high',
            });
            canvas.toBlob(function(blob) {
                var formData = new FormData();
                formData.append('event_cover', blob);

                $.ajax({
                    url: '/upload-cover', // replace with your route
                    method: 'POST',
                    data: formData,
                    processData: false, // Important!
                    contentType: false, // Important!
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // For CSRF protection in Laravel
                    },
                    success: function(response) {
                        // Handle success here
                        console.log(response);
                        $('#imagePreview').attr('src', response.url).show();
                        $('#event_cover_croped').val(response.url);
                        $('#cropperModal').modal('hide');
                    },
                    error: function(error) {
                        // Handle error here
                        console.log(error);
                    }
                });
            });
            $('#cropperModal').modal('hide');
        });
    </script>


    <script>
        function updateRangeValue(value) {
            $('#rangeValue').text(value);
        }

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
            $('#photo_option').trigger('change');
            // Add change event to radio buttons
            $('#photo_option').change(function() {
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
    <script>
        // function previewImage(event) {
        //     var input = event.target;
        //     var preview = document.getElementById('imagePreview');

        //     if (input.files && input.files[0]) {
        //         var reader = new FileReader();

        //         reader.onload = function(e) {
        //             preview.src = e.target.result;
        //             preview.style.display = 'block';
        //         }

        //         reader.readAsDataURL(input.files[0]);
        //     } else {
        //         preview.src = '#';
        //         preview.style.display = 'none';
        //     }
        // }
    </script>
    <script>
        function initAutocomplete() {
            var input = document.getElementById('locationInput');
            var autocomplete = new google.maps.places.Autocomplete(input);
        }
        google.maps.event.addDomListener(window, 'load', initAutocomplete);
    </script>
@endsection
