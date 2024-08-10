<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.css"
        integrity="sha512-oe8OpYjBaDWPt2VmSFR+qYOdnTjeV9QPLJUeqZyprDEQvQLJ9C5PCFclxwNuvb/GQgQngdCXzKSFltuHD3eCxA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Snapshot HUB</title>
    <style>
        body {
            background: #1E1832;
        }

        .navbar-custom {
            background-color: #1E1832;

        }

        .bg-custom-footer {
            background-color: #D89623;
            color: #fff;
            /* height: 200px; */
        }

        .carousel-caption>h1 {
            font-weight: bold !important;
            font-size: 70px !important;
            /* background-color: rgba(0, 0, 0, 0.5) */
        }

        .btn-learn-more {
            background-color: #426BD4;
            color: #fff;
            padding: 10px 20px;
        }

        .badge {
            padding-left: 5px !important;
            padding-right: 5px !important;
            padding-top: 2px !important;
            padding-bottom: 2px !important;
            -webkit-border-radius: 9px;
            -moz-border-radius: 9px;
            border-radius: 50%;
        }

        #lblCartCount {
            font-size: 12px;
            padding: 5px;
            background: #D89623;
            color: #fff;
            padding: 0 5px;
            vertical-align: top;
            margin-left: -10px;
            z-index: 999;
        }

        .event-name {
            padding: 15px 40px;
            background-color: #f1f1f1;
            border-radius: 20px;
        }

        .download-image_icon {
            position: absolute;
            font-size: 20px;
            background-color: rgba(30, 24, 50, 0.8);
            padding: 10px;
            color: #f1f1f1;
            bottom: 15px;
            left: 5px;
            border-radius: 20px;
        }

        .edit-image_icon {
            position: absolute;
            font-size: 20px;
            background-color: rgba(30, 24, 50, 0.8);
            padding: 10px;
            color: #f1f1f1;
            bottom: 15px;
            right: 5px;
            border-radius: 20px;
        }

        .download-image_icon:hover {
            background-color: #fff;
            font-size: 25px;
            color: rgba(30, 24, 50, 1);
        }

        .edit-image_icon:hover {
            background-color: #fff;
            font-size: 25px;
            color: rgba(30, 24, 50, 1);
        }

        @media (min-width: 576px) {
            .modal-dialog {
                max-width: 70% !important;
                margin: 1.75rem auto;
            }
        }

        .footer-link {
            color: #fff !important;
            text-decoration: none !important;
        }

        .footer-link:hover {
            color: #efefef !important;
        }
    </style>
    <style>
        .d-flex {
            display: flex;
            flex-wrap: wrap;
        }

        .card-wrapper {
            flex: 0 0 auto;
            height: 200px;
            margin-right: 10px;
            /* Adjust as needed */
            margin-bottom: 10px;
            /* Adjust as needed */
        }

        .card {
            width: 100%;
            height: 100%;
            position: relative;
        }

        .card-img-top {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-icons {
            /* position: absolute; */
            top: 5px;
            right: 5px;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            z-index: 1;
        }

        .card-icons i {
            margin-top: 5px;
        }

        .cropper-container {
            width: auto !important;
        }

        .navbar-toggler {
            position: absolute;
            right: 5px !important;
            top: -50px;
        }
    </style>
</head>

<body style="background-color:#1E1832; font-family: 'Outfit';">

    <!-- Header -->
    <header class="navbar-custom  fixed-top p-3">
        <div class="container">
            <div class="row align-items-center ">
                <div class="col-lg-4">
                    <a href="{{ action([\App\Http\Controllers\FrontEndController::class, 'home']) }}">
                        <img src="{{ asset('images/front/logo.png') }}" alt="Logo" class="img-fluid"
                            style="max-width:50%">
                    </a>
                </div>
                <div class="col-lg-8">
                    <nav class="navbar navbar-expand-lg navbar-dark" style="text-align:center;">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ action([\App\Http\Controllers\FrontEndController::class, 'home']) }}"
                                        style="color: #fff;">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ action([\App\Http\Controllers\FrontEndController::class, 'findPhotos']) }}"
                                        style="color: #fff;">Find Photos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ action([\App\Http\Controllers\FrontEndController::class, 'buySubscription']) }}"
                                        style="color: #fff;">Photographer</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ action([\App\Http\Controllers\FrontEndController::class, 'frontContactUs']) }}"
                                        style="color: #fff;">Contact</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ action([\App\Http\Controllers\FrontEndController::class, 'cart']) }}" target="_blank">
                                        <i class="fa fa-shopping-cart"
                                            style="color: #D89623; font-size:25px; position: relative;"></i>
                                        <span class='badge badge-warning lblCartCount' id="lblCartCount"
                                            style="display: none;"></span>
                                    </a>
                                </li>
                                @if (count(session()->get('front_user', [])))
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            href="{{ action([\App\Http\Controllers\FrontEndController::class, 'userProfile']) }}"
                                            style="color: #fff;"><u>Profile</u></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link btn"
                                            style="background-color: #D89623;color: #fff;padding:10px 20px;"
                                            href="{{ action([\App\Http\Controllers\FrontEndController::class, 'logout']) }}"><b>
                                                Logout </b></a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a type="button" class="nav-link" data-toggle="modal"
                                            data-target="#loginModal">
                                            Login
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a type="button" class="nav-link btn uppercase"
                                            style="background-color: #D89623;color: #fff;padding:10px 20px;border-radius:20px;"
                                            data-toggle="modal" data-target="#signupModal">
                                            Signup
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>


    <!-- Slider -->
    <section class="mt-5">

        <div class="container">
            <div class="row" style="">

                <div  class=" mb-4 text-center col-md-12"
                    style="padding:1.5rem !important;background-color: #D89623;color: #fff;padding:10px 20px;border-radius:20px;">
                    <h1 style="margin-top:45px;">Welcome {{ session()->get('front_user.name', 'User') }}</h1>
                </div>
            </div>

            <div class="container mt-5">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                            aria-controls="home" aria-selected="true">My Photos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="receipts-tab" data-toggle="tab" href="#receipts" role="tab"
                            aria-controls="receipts" aria-selected="false">Receipts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile_settings-tab" data-toggle="tab" href="#profile_settings"
                            role="tab" aria-controls="profile_settings" aria-selected="false">Profile
                            Settings</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel"
                        aria-labelledby="home-tab">
                        <div class="row mb-3 bg-white" style=" border-radius:20px;overflow:hidden;">
                            <h2 class="text-center mb-3 p-3 col-md-12" style="background-color: #426BD4;color:#fff;">
                                Your Images
                            </h2>

                            <div class="col-md-12">
                                {{-- @foreach ($user_photos as $key => $photo)
                                <div class="col-md-4 mb-3">
                                    <div class="card" style="100%;">
                                        <img class="card-img-top"
                                            src="https://s3.{{ env('AWS_DEFAULT_REGION') }}.amazonaws.com/{{ env('AWS_BUCKET') }}/{{ str_replace('/thumbnails', '', $photo->photo_url) }}"
                                            style="max-width: 100%;height:auto;" alt="Card image cap">
                                        <i class="fa fa-download download-image_icon" id="downloadImage{{ $photo->id }}"
                                            data-url="{{ $photo->photo_url }}"></i>
                                        <i class="fa fa-crop edit-image_icon"
                                            onclick="edit('https://s3.{{ env('AWS_DEFAULT_REGION') }}.amazonaws.com/{{ env('AWS_BUCKET') }}/{{ str_replace('/thumbnails', '', $photo->photo_url) }}')"></i>
                                    </div>
                                </div>
                            @endforeach --}}
                                <div class="d-flex flex-wrap p-3">
                                    @foreach ($user_photos as $key => $photo)
                                        <div class="card-wrapper">
                                            <div class="card">
                                                @if ($photo->is_low_q)
                                                    @php
                                                        $photo_url = str_replace(
                                                            '/thumbnails',
                                                            '/low_quality',
                                                            $photo->photo_url,
                                                        );
                                                    @endphp
                                                @else
                                                    @php
                                                        $photo_url = str_replace('/thumbnails', '', $photo->photo_url);
                                                    @endphp
                                                @endif
                                                <img class="card-img-top"
                                                    src="https://s3.{{ env('AWS_DEFAULT_REGION') }}.amazonaws.com/{{ env('AWS_BUCKET') }}/{{ $photo_url }}"
                                                    alt="Card image cap">
                                                <div class="card-icons">
                                                    <i class="fa fa-download download-image_icon"
                                                        id="downloadImage{{ $photo->id }}"
                                                        data-url="{{ $photo_url }}"></i>
                                                    {{-- <i class="fa fa-crop edit-image_icon"
                                                    onclick="edit('https://s3.{{ env('AWS_DEFAULT_REGION') }}.amazonaws.com/{{ env('AWS_BUCKET') }}/{{ $photo_url }}')"></i> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="receipts" role="tabpanel" aria-labelledby="receipts-tab">
                        <div class="row bg-white" style=" border-radius:20px;overflow:hidden;">
                            <h2 class="text-center mb-3 p-3 col-md-12" style="background-color: #426BD4;color:#fff;">
                                Your payment
                                receipts</h2>
                            <div class="col-md-12">
                                <ol class="m-3">

                                    @foreach ($buy_records as $key => $record)
                                        @if ($record->total_amount)
                                            <li>
                                                <a href="{{ $record->receipt_url }}"
                                                    target="_blank">Receipt_{{ date('d-M-Y', strtotime($record->created_at)) }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile_settings" role="tabpanel"
                        aria-labelledby="profile_settings-tab">
                        <div class="row bg-white" style=" border-radius:20px;overflow:hidden;">
                            <h2 class="text-center mb-3 p-3 col-md-12" style="background-color: #426BD4;color:#fff;">
                                Profile Settings</h2>
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-6 p-3">
                                <form method="POST" action="{{ route('update_profile') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ session()->get('front_user.name', 'User') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ session()->get('front_user.email') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" id="confirm_password"
                                            name="confirm_password">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>




            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
        </div>
    </section>




    <!-- Footer -->
    <!-- Footer -->
    <footer class="bg-custom-footer">
        <div class="container ">
            <div class="row">
                <div class="col-md-12 mt-5">
                    <img src="{{ asset('images/front/logo_white.png') }}" height="" alt="Footer Logo"
                        class="img-fluid">
                    <div style="position: absolute; top: 0; right: 20px;">
                        <a href="{{ env('facebook_link') }}" target="_blank"><img
                                src="{{ asset('images/front/facebook.png') }}" height="" alt="Footer Logo"
                                class="img-fluid" style="color: white; font-size:15px;font-weight:bold; "></a>
                        <a href="{{ env('instagram_link') }}" target="_blank"><img
                                src="{{ asset('images/front/instagram.png') }}" height="" alt="Footer Logo"
                                class="img-fluid"
                                style="color: white; font-size:15px;font-weight:bold; margin-left: 20px;"></a>                    
                        <a href="{{ env('youtube_link') }}" target="_blank"><img
                                src="{{ asset('images/front/youtube.png') }}" height="20" alt="Footer Logo"
                                class="img-fluid"
                                style="color: white; font-size:15px;font-weight:bold;  margin-left: 15px;height:20px;"></a>
                    </div>
                </div>
                <div class="col-md-7  mt-3">
                    <div class="row" style="font-size:small;color:#fff !important;">
                        <div class="col-md-2">
                            <a class="footer-link"
                                href="{{ action([\App\Http\Controllers\FrontEndController::class, 'aboutUs']) }}">About
                                Us</a><br>
                            <a class="footer-link"
                                href="{{ action([\App\Http\Controllers\FrontEndController::class, 'frontContactUs']) }}">Contact
                                Us</a>
                        </div>
                        <div class="col-md-2">
                            <a class="footer-link"
                                href="{{ action([\App\Http\Controllers\FrontEndController::class, 'findPhotos']) }}">Find
                                Photos</a><br>
                            <a class="footer-link"
                                href="{{ action([\App\Http\Controllers\FrontEndController::class, 'buySubscription']) }}">Photographers</a>
                        </div>
                        <div class="col-md-3">
                            <a class="footer-link"
                                href="{{ action([\App\Http\Controllers\FrontEndController::class, 'termsAndConditions']) }}">Terms
                                & Conditions</a> <br>
                            <a class="footer-link"
                                href="{{ action([\App\Http\Controllers\FrontEndController::class, 'PrivacyPolicy']) }}">Privacy
                                Policy</a>
                        </div>
                        <div class="col-md-4 mb-5">
                            <a class="footer-link"
                                href="{{ action([\App\Http\Controllers\FrontEndController::class, 'FAQforPhotographers']) }}">FAQ
                                for Photographers</a>
                        </div>
                    </div>

                </div>
            </div>
            <hr style="background-color: rgba(255, 255, 255,0.5)">
            <p style="font-size: 12px;">Proudly created by MRM 
                <a class="footer-link" target="_blank"   rel="nofollow noopener" href="https://www.myrobotmonkey.com.au"><img src="{{ asset('images/front/mrm.png') }}" height="" alt="Footer Logo" class="img-fluid" style="margin-top:-3px;"> </a>
                <a class="footer-link" target="_blank"   rel="nofollow noopener" href="https://www.myrobotmonkey.com.au/website-design">Website Design</a> | 
                <a class="footer-link" target="_blank"   rel="nofollow noopener" href="https://www.myrobotmonkey.com.au/graphic-design">Graphic Design</a> | 
                <a class="footer-link" target="_blank"   rel="nofollow noopener" href="https://www.myrobotmonkey.com.au/search-engine-optimisation">SEO</a> | 
                <a class="footer-link" target="_blank"   rel="nofollow noopener" href="https://www.myrobotmonkey.com.au/marketing-digital">Marketing</a> | 
                <a class="footer-link" target="_blank"   rel="nofollow noopener" href="https://www.myrobotmonkey.com.au/app-development/">App Development</a>
             </p>

            <br>
            <br>
        </div>
    </footer>
    <!-- Modal Popup -->
    <div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 70% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cropModalLabel">Crop Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="imageToCrop" src="" alt="Image to Crop" />
                    <div id="cropOptions">
                        <!-- Crop options will be dynamically generated here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="cropAndDownload">Crop & Download</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and Font Awesome JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.js"
        integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @include('front_end.modal_login')
    @include('front_end.modal_signup')
    @include('front_end.modal_signup_front')
    @include('front_end.modal_forgot')
    @include('front_end.modal_responce')
    @if (session('status'))
        @if (session('status.success'))
            <script>
                $("#account_responce_modal").html('{{ session('status.msg') }}');
                $("#account_responce_modal").css('color', '#0094FF');
                $("#responceModal").modal('show');
            </script>
        @else
            <script>
                $("#account_responce_modal").html('{{ session('status.msg') }}');
                $("#account_responce_modal").css('color', 'red');
                $("#responceModal").modal('show');
            </script>
        @endif
    @endif
    <script>
        $(document).ready(function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var postDatatemp = {
                photo_id: 0,
                low_quality: 0
            };
            $.ajax({
                url: "{{ action([\App\Http\Controllers\FrontEndController::class, 'updateCart']) }}",
                type: "POST",
                data: postDatatemp,
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                success: function(response) {
                    console.log(response);
                    if (response.count) {
                        $("#lblCartCount").html(response.count);
                        $("#lblCartCount").show();
                        $.each(response.cart, function(index, value) {
                            // Select element(s) with data-value attribute equal to "your-value"
                            var element = $('[data-photoid="' + index + '"]');
                            if (element) {
                                element.each(function() {
                                    console.log($(this)
                                        .text()
                                    ); // Output the text content of each matched element
                                    $(element).css('background-color',
                                        'rgba(0, 0, 0, 0.6)');
                                });
                            }

                        });
                    } else {
                        $("#lblCartCount").html(response.count);
                        $("#lblCartCount").hide();
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error("Error:", error);
                }
            });

        });
    </script>
    <script>
        // Assuming you're using jQuery for AJAX

        $('.download-image_icon').click(function() {
            var imageUrl = $(this).data('url');
            downloadImage(imageUrl);
        });

        function downloadImage(imageUrl) {
            $.ajax({
                type: 'POST',
                url: "{{ action([\App\Http\Controllers\FrontEndController::class, 'downloadImage']) }}",
                data: {
                    imageUrl: imageUrl,
                    _token: '{{ csrf_token() }}'
                },
                xhrFields: {
                    responseType: 'blob' // Set responseType to 'blob' to receive binary data
                },
                success: function(response, status, xhr) {
                    // Check if the response contains the image content
                    if (xhr.getResponseHeader('Content-Type').indexOf('image') !== -1) {
                        // Create a blob URL for the image content
                        var blobUrl = URL.createObjectURL(response);
                        // Create a temporary anchor element
                        var link = document.createElement('a');
                        link.href = blobUrl;
                        link.download = 'image.jpg'; // You can specify the download filename here
                        // Simulate a click event to trigger the download
                        link.click();
                        // Clean up: revoke the blob URL
                        URL.revokeObjectURL(blobUrl);
                    } else {
                        console.error('Invalid response: Not an image');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
    </script>
    <script>
        var cropper;
        // Function to handle edit button click
        function edit(imageUrl) {
            console.log(imageUrl);
            // Set the image source in the modal
            $("#imageToCrop").attr("src", imageUrl);

            // Open the modal
            $("#cropModal").modal("show");
        }

        // Function to initialize cropping options
        function initializeCropOptions() {


            // Clear existing options
            $("#cropOptions").empty();
            if (cropper) {
                cropper.destroy();
            }
            // Add fixed ratio crop options
            var ratios = ["16:9", "4:3", "1:1"]; // Add more ratios as needed
            ratios.forEach(function(ratio) {
                var option = $("<button class='btn btn-secondary mr-2'></button>").text(ratio);
                option.click(function() {
                    // Initialize cropping with the selected ratio
                    var ratioArray = ratio.split(":");
                    cropper = new Cropper(document.getElementById("imageToCrop"), {
                        aspectRatio: parseFloat(ratioArray[0]) / parseFloat(ratioArray[1]),
                        crop: function(event) {
                            console.log(event.detail.x);
                            console.log(event.detail.y);
                            console.log(event.detail.width);
                            console.log(event.detail.height);
                        }
                    });
                });
                $("#cropOptions").append(option);
            });
        }

        // Initialize cropping options when the modal is shown
        $("#cropModal").on("shown.bs.modal", function() {
            if (cropper) {
                cropper.destroy();
            }
            initializeCropOptions();
        });

        // Handle crop and download button click
        $("#cropAndDownload").click(function() {
            // Get the cropped image data
            var canvas = cropper.getCroppedCanvas();
            if (!canvas) {
                return;
            }
            // Convert canvas to blob
            canvas.toBlob(function(blob) {
                // Create a temporary anchor element
                var link = document.createElement("a");
                link.href = URL.createObjectURL(blob);
                link.download = "cropped_image.jpg"; // Specify the download filename
                // Simulate a click event to trigger the download
                link.click();
                // Clean up: revoke the object URL
                URL.revokeObjectURL(link.href);
            });
            $("#cropOptions").empty();
            if (cropper) {
                cropper.destroy();
            }
            cropper.destroy();
            $(".close").trigger('click');
        });
    </script>
</body>

</html>
