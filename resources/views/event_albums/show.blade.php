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
                    <li class="active">{{ $album_data->name }}</li>
                </ol>
            </div>
        </div>
        <style>
            #image-dropzone {
                border: 2px dashed #ccc;
                border-radius: 5px;
                min-height: 150px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                overflow: auto;
                position: relative;
            }

            #image-preview {
                display: flex;
                flex-wrap: wrap;
                margin-top: 10px;
                overflow: auto;
            }

            .dz-preview {
                display: block;
                margin: 4px;
            }

            .dz-image {
                border-radius: 5px;
                overflow: hidden;
            }

            .dz-details {
                width: 120px;
                height: 120px;
                overflow: hidden;
            }

            .dz-remove {
                position: absolute;
                top: 0;
                right: 0;
                cursor: pointer;
                z-index: 999;
                background-color: rgba(7, 0, 0, 0.8);
                padding: 5px;
            }
        </style>
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
            #images_upload_counter {
                color: white;
                position: absolute;
                top: 65%;
                left: 55%;
                transform: translate(-50%, -50%);
                font-size: 30px;
                font-weight: bold;
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
            <h3 id="images_upload_counter">  </h3>
        </div>
        {{-- @dd($album_data); --}}
        <div class="row">
            <div class="col-md-8">

                <h1>{{ $event->name }} ({{ $event->location }})</h1>

                <h4>{{ $album_data->name }} </h4>
            </div>

            @if (in_array('protected_images', $user_event_permisions))
                <div class="col-md-4">
                    <div class="box-tools text-right">
                        <a href="{{ action([\App\Http\Controllers\EventphotosController::class, 'protectedImages'], [$album_data->id]) }}"
                            class="btn btn-success btn-sm"> Manage Protected Images </a>
                    </div>
                </div>
            @endif
        </div>

        {{-- @slot('tool') --}}

        {{-- @endslot --}}


    </section>
    <div class="container">
        <!-- Main content -->
        <section class="content">
            @php
                $aws_storage = isset($package->package_details['aws_storage'])
                    ? $package->package_details['aws_storage']
                    : 0;
            @endphp

        @if (in_array('upload_images', $user_event_permisions))
            @component('components.widget', ['class' => 'box-primary', 'title' => 'Upload Images'])
                <div class="col-sm-12">
                    <h5><b>Please note: A maximum of 4MB per file, will only be uploaded.</b></h5>
                    @slot('tool')
                        <div class="box-tools" style="margin-top: 20px;">
                            <button type="button" disabled class="btn btn-default"><b>Storage Usage:
                                </b>{{ round($used_storage / 1024, 3) }}MB / {{ $aws_storage * 1024 }}MB</button>
                        </div>
                    @endslot
                </div>
                <input type="hidden" name="meta_data" value="-">
                <div class="col-sm-12">
                    <div id="image-dropzone" class="dropzone" @if ($used_storage / 1024 >= $aws_storage * 1024) disabled @endif>
                        <div class="dz-message">
                            <h3>Drag & Drop images here or click to upload.</h3>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12" style="margin-top: 10px;text-align: center; ">
                    <button class="btn btn-primary pull-right" id="uploadButton"
                        @if ($used_storage / 1024 >= $aws_storage * 1024) disabled @endif> <i class="fa fa-upload" style="font-size: 20px"></i>
                        Upload Photos</button>
                </div>
                <!-- Add this below your existing HTML structure -->
                <table id="image-preview-table" class="table" style="margin-top: 20px">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Upload Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- This will be populated dynamically using JavaScript -->
                    </tbody>
                </table>

                {{-- <!-- Gallery View -->
                    <div class="row mt-4">
                        @for ($i = 0; $i < 10; $i++)
                            <div class="col-md-3 mb-3">
                                <img src="https://www.w3schools.com/css/paris.jpg" class="img-thumbnail"
                                    alt="Image {{ $i + 1 }}">
                            </div>
                        @endfor
                    </div> --}}
            @endcomponent
        @endif
            @component('components.widget', ['class' => 'box-primary', 'title' => 'Uploaded Images'])
                @slot('tool')
                    <div class="box-tools">
                        
                        @if (in_array('delete_images', $user_event_permisions))
                        <button type="button" class="btn btn-sm btn-danger" id="deleteSelectedPhotos">
                            <i class="fa fa-trash"></i>Delete Selected</button>
                        @endif
                    </div>
                @endslot
                <table class="table" id="images_table">
                    <thead>
                        <tr>
                            <th> <input type="checkbox" id="selectAll"> SKU </th>
                            <th>Image</th>
                            <th>Size</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- your_view.blade.php -->
                        @foreach ($imageUrls as $fileName => $imageUrl)
                            <tr>
                                <td>
                                    <input type='checkbox' class="awsphotos" name='awsphotos[]'
                                        value='{{ $imageUrl['folderPath'] }}/{{ $fileName }}'>
                                    {{ $imageUrl['sku'] }}
                                </td>
                                <td>
                                    <img src="{{ $imageUrl['url'] }}" alt="{{ $fileName }} " width="50">
                                </td>
                                <td>
                                    {{ round($imageUrl['size'], 2) }} KB
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-xs delete-btn"
                                        data-image = "{{ $imageUrl['folderPath'] }}/{{ $fileName }}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
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
        $('#images_table').dataTable({
            responsive: true,
            autoWidth: false,
            order: [],
            columnDefs: [{
                orderable: false,
                targets: [0, 1, 2, 3]
            }],
            pageLength: 100,
            lengthChange: false,
            searching: true,
            columns: [{
                    searchable: true
                },
                {
                    searchable: false
                },
                {
                    searchable: false
                },
                {
                    searchable: false
                }
            ]
        });

        function showLoader() {
            $('.loader-overlay').show();
        }
        $('#image-preview-table').hide();
        $("#uploadButton").hide();

        function hideLoader() {
            $('.loader-overlay').hide();
        }
        // Function to create a thumbnail Blob from the original file
        function createThumbnailBlob(file) {
            return new Promise(function(resolve) {
                var ___reader = new FileReader();
                ___reader.onload = function(e) {
                    // Create an Image element and set its source to the data URL
                    var img = new Image();
                    img.src = e.target.result;

                    // Create a canvas element
                    var canvas = document.createElement('canvas');
                    canvas.width = 120;
                    canvas.height = 120;

                    // Draw the image on the canvas
                    var ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, 120, 120);

                    // Convert the canvas content to a Blob
                    canvas.toBlob(function(blob) {
                        resolve(blob);
                    });
                };
                ___reader.readAsDataURL(file);
            });
        }
        $('#images_upload_counter').text('0 / 0');
        var totalFiles = 0;
        $(document).ready(function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var myDropzone = new Dropzone("#image-dropzone", {
                url: '{{ route('upload.image', $album_data->id) }}',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                autoProcessQueue: false,
                parallelUploads: 1,
                acceptedFiles: ".jpeg,.jpg,.png", // Accept only JPEG and PNG files
                addRemoveLinks: true,
                maxFilesize: 5, // Set maximum file size limit to 10 MB
                timeout: 120000,
            });

            // Function to update the image upload counter
            function updateImageCounter() {
                var uploadedFiles = totalFiles - myDropzone.getQueuedFiles().length - myDropzone.getUploadingFiles().length;
                $('#images_upload_counter').text(`${uploadedFiles} / ${totalFiles}`);
            }

            $('#uploadButton').on('click', function() {
                if (myDropzone.getQueuedFiles().length > 0) {
                    totalFiles = myDropzone.getQueuedFiles().length;
                    updateImageCounter();
                    showLoader();
                    myDropzone.processQueue();
                }
            });

            myDropzone.on("sending", function(file, xhr, formData) {
                formData.append('meta_data', $('#meta_data').val());
            });

            myDropzone.on("addedfile", function(file) {
                const acceptedFiles = ['.jpeg', '.jpg', '.png'];
                const fileExtension = file.name.split('.').pop().toLowerCase();
                const isValidFile = acceptedFiles.includes(`.${fileExtension}`);

                if (!isValidFile) {
                    toastr.error('Unsupported file type');
                    myDropzone.removeFile(file);
                    return;
                }

                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-preview-table').show();
                    $('#uploadButton').show();

                    $('#image-preview-table tbody').append('<tr id="' + file.upload.uuid +
                        '"><td><img src="' + e.target.result +
                        '" alt="preview" width="50"></td><td>' + file.name + '</td><td>' + (file
                            .size / 1024).toFixed(2) +
                        ' KB</td><td><div class="progress"><div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div></td></tr>'
                    );
                    updateImageCounter();
                };
                reader.readAsDataURL(file);
            });

            myDropzone.on("uploadprogress", function(file, progress, bytesSent) {
                $('#' + file.upload.uuid + ' .progress-bar').css('width', progress + '%');
            });

            myDropzone.on("removedfile", function(file) {
                $('#' + file.upload.uuid).remove();
                updateImageCounter();
                if (myDropzone.getQueuedFiles().length > 0) {
                    $('#uploadButton').show();
                } else {
                    $('#image-preview-table').hide();
                    $('#uploadButton').hide();
                }
            });

            myDropzone.on("queuecomplete", function() {
                if (myDropzone.getFilesWithStatus(Dropzone.ERROR).length === 0) {
                    toastr.success("All images are uploaded");
                }
                setTimeout(function() {
                    hideLoader();
                    location.reload(true);
                }, 3000);
            });

            myDropzone.on("complete", function(file) {
                if (file.status === Dropzone.ERROR) {
                    $('#' + file.upload.uuid + ' .progress-bar').removeClass('bg-success').addClass(
                        'bg-danger');
                }
                myDropzone.removeFile(file);
                updateImageCounter();
                myDropzone.processQueue();
            });

            myDropzone.on("error", function(file, response) {
                if (typeof response !== "undefined" && response !== null && typeof response.data !==
                    "undefined") {
                    toastr.error(response.data);
                } else {
                    toastr.error("An unexpected error occurred.");
                }
                myDropzone.removeFile(file);
                updateImageCounter();
                myDropzone.processQueue();
                // hideLoader();
            });
        });


        // ==============
    </script>

    <script>
        // Assuming you're using jQuery
        $(document).ready(function() {
            $('.delete-btn').click(function() {
                var eventphotoId = $(this).data('image');
                swal({
                    title: LANG.sure,
                    text: 'Are you sure you want to delete this image?',
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: '/delete_photo',
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
            swal({
                title: LANG.sure,
                text: 'Are you sure you want to delete the selected?',
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    selectedCheckboxes.each(function() {
                        var eventphotoId = $(this).val();

                        $.ajax({
                            url: '/delete_photo',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                eventphotoId: eventphotoId
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                toastr.success("Images deleted successfully");
                                location.reload(true);
                            },
                            error: function(xhr) {
                                console.error('Error deleting image:', xhr
                                    .responseText);
                            }
                        });
                    });
                }
            });
        });


    </script>

@endsection
