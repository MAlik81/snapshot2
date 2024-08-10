<!-- resources/views/event_management/upload-images.blade.php -->
@extends('layouts.app')
@section('title', 'Albums')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}">Home</a></li>
                    <li><a href="{{ action([\App\Http\Controllers\EventManagementController::class, 'index']) }}">Events</a>
                    </li>
                    <li><a
                            href="{{ action([\App\Http\Controllers\EventManagementController::class, 'show'], [$event->id]) }}">
                            {{ $event->name }}</a></li>
                    
                    <li> <a
                            href="{{ action([\App\Http\Controllers\EventalbumsController::class, 'show'], [$album_id]) }}">{{ $album_data->name }}</a>
                    </li>
                    <li class="active">Manage Protected Images</li>
                </ol>
            </div>
        </div>
        <style>
            .loader-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                display: none;
                z-index: 9999;
            }

            .loader {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                border: 16px solid #f3f3f3;
                /* Light grey */
                border-top: 16px solid #3498db;
                /* Blue */
                border-radius: 50%;
                width: 120px;
                height: 120px;
                animation: spin 2s linear infinite;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }
        </style>
        <div class="loader-overlay">
            <div class="loader"></div>
        </div>
        {{-- @dd($album_data); --}}
        <h1>{{ $event->name }} ({{ $event->location }})</h1>
        <h4>{{ $album_data->name }} </h4>
        {{-- @slot('tool') --}}

        {{-- @endslot --}}
        {{-- <div class="box-tools"> --}}

        {{-- </div> --}}


    </section>
    <div class="container">
        <!-- Main content -->
        <section class="content">
            {{-- <a href="{{ action([\App\Http\Controllers\EventalbumsController::class, 'show'], [$album->id]) }}">
                                    
                <span class="info-box-text">{{ $album->name }}</span>
            </a> --}}
            @component('components.widget', ['class' => 'box-primary', 'title' => 'Search Protected Images'])
                <div class="row">

                    <div class="col-sm-3">
                        <div class="form-group">
                            {!! Form::label('imageInput', 'Select image to search:') !!}
                            {!! Form::file('imageInput', null, ['class' => 'form-control', 'id' => 'imageInput']) !!}
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div id="image_preview">

                        </div>
                    </div>

                </div>


                <div class="col-sm-3">
                    <button class="btn btn-primary" id="searchButton">Search</button>
                </div>
                {{-- <div id="results">

                </div> --}}
            @endcomponent
            @component('components.widget', ['class' => 'box-primary', 'title' => 'Protected Images'])
                @slot('tool')
                    <div class="box-tools">
                        {{-- <button type="button" class="btn btn-sm btn-primary">
                            <i class="fa fa-check"></i> Select All</button> --}}
                        <button type="button" class="btn btn-sm btn-danger" id="deleteSelectedPhotos">
                            <i class="fa fa-trash"></i>Delete Selected</button>
                    </div>
                @endslot
                <table id="image-preview-tabled" class="table table-borderd table-striped col-md-4">
                    <thead>
                        <tr>
                            <th> <input type="checkbox" id="selectAll"> Select All</th>
                            <th>Image</th>
                            <th>Similarity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="results">
                        <!-- your_view.blade.php -->

                    </tbody>
                </table>
            @endcomponent
        </section>
    </div>
@endsection

@section('javascript')
    <!-- Include Dropzone.js -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script> --}}

    <!-- Your HTML structure remains the same -->
    <!-- Your HTML -->
    <script>
        function showLoader() {
            $('.loader-overlay').show();
        }

        function hideLoader() {
            $('.loader-overlay').hide();
        }
        $(document).ready(function() {
            $('#searchButton').on('click', function() {
                showLoader();
                var fileInput = document.getElementById('imageInput');
                var file = fileInput.files[0];
                if (file) {
                    var formData = new FormData();
                    formData.append('file', file);

                    // Make AJAX call to search for similar images
                    $.ajax({
                        url: '/get-protected-images',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.success) {
                                // Display search results
                                var resultsDiv = $('#results');
                                resultsDiv.empty(); // Clear previous results
                                response.similar_images.forEach(function(image) {
                                    // resultsDiv.append('<div>Image ID: ' + image.ImageId + ', Similarity: ' + image.Similarity + '</div>');
                                    var string_tr = '';

                                    string_tr += '<tr>';
                                    string_tr += '<td>';
                                    string_tr +=
                                        '<input type="checkbox" class="awsphotos" name="awsphotos[]" value="' +
                                        image.Image_id + '">';
                                    string_tr += '</td>';
                                    string_tr += '<td>';
                                    string_tr += '<img src="' + image.ImageUrl +
                                        '" alt="' + image.ImageUrl +
                                        '" width="200">';
                                    string_tr += '</td>';
                                    string_tr += '<td>';
                                    string_tr += image.Similarity;
                                    string_tr += '</td>';
                                    string_tr += '<td>';
                                    string_tr +=
                                        '<button class="btn btn-danger btn-xs delete-btn" data-image = "' +
                                        image.Image_id + '">Delete</button>';
                                    string_tr += '</td>';
                                    string_tr += '</tr>';
                                    resultsDiv.append(string_tr);
                                    console.log(string_tr);
                                });
                            } else {
                                console.error('Error:', response.error);
                            }
                            hideLoader();
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            hideLoader();
                        }
                    });
                } else {
                    console.error('No file selected.');
                    hideLoader();
                }
            });
        });
    </script>



    <script>
        // Assuming you're using jQuery
        $(document).ready(function() {
            // Use event delegation to handle click events on dynamically created buttons
            $(document).on('click', '.delete-btn', function() {

                var eventphotoId = $(this).data('image');
                swal({
                    title: LANG.sure,
                    text: 'Are you sure you want to delete this image?',
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        showLoader();
                        $.ajax({
                            url: '/delete_photo_by_id',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                eventphotoId: eventphotoId
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                console.log(response);
                                toastr.success("Image deleted successfully");
                                location.reload(true);

                            },
                            error: function(xhr) {
                                console.error('Error deleting image:', xhr
                                .responseText);
                            }
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // When the "Select All" checkbox is clicked
            $("#selectAll").change(function() {
                // Check or uncheck all checkboxes with class "awsphotos"
                $(".awsphotos").prop("checked", $(this).prop("checked"));
            });

            // When any checkbox with class "awsphotos" is clicked
            $(".awsphotos").change(function() {
                // Check if all checkboxes with class "awsphotos" are checked
                if ($(".awsphotos:checked").length === $(".awsphotos").length) {
                    // If all are checked, check the "Select All" checkbox
                    $("#selectAll").prop("checked", true);
                } else {
                    // If any is unchecked, uncheck the "Select All" checkbox
                    $("#selectAll").prop("checked", false);
                }
            });
        });
        $('#deleteSelectedPhotos').on('click', function() {
            // Select all checkboxes with class "awsphotos" that are checked
            const selectedCheckboxes = $('.awsphotos:checked');
            // Check if there are any selected checkboxes
            if (selectedCheckboxes.length === 0) {
                toastr.error("Please select atleast one image before deletion");
                location.reload(true);
                return;
            }
            // Ask for confirmation
            if (confirm('Are you sure you want to delete the selected photos?')) {
                selectedCheckboxes.each(function() {
                    var eventphotoId = $(this).val();
                    showLoader();
                    $.ajax({
                        url: '/delete_photo_by_id',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            eventphotoId: eventphotoId
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response);
                            toastr.success("Image deleted successfully");
                            location.reload(true);
                            // Optionally, remove the checkbox after successful deletion
                            // $(this).closest('div').remove();
                        },
                        error: function(xhr) {
                            console.error('Error deleting image:', xhr
                                .responseText);
                        },
                        finalize: function() {
                            hideLoader();
                        }
                    });
                });
            }
        });
    </script>

@endsection
