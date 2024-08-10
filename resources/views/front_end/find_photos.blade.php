<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
    <!-- CSRF Token -->
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
            background-color: rgba(0, 0, 0, 0.5)
        }

        .btn-learn-more {
            background-color: #426BD4;
            color: #fff;
            padding: 10px 20px;
        }

        .blue-div {
            background-color: #426BD4;
            color: #fff;
            border-radius: 20px;
        }

        /* .navbar-custom .dropdown-menu {
            position: absolute;
            left: 0;
        } */

        /* .navbar-custom .dropdown-menu-1 {
            width: 50vw;
            transform: translateX(-7%);
            max-width: calc(100vw - 20px);
        }

        .navbar-custom .dropdown-menu-2 {
            width: 50vw;
            transform: translateX(-22%);
            max-width: calc(100vw - 20px);
        }

        .navbar-custom .dropdown-menu-3 {
            width: 50vw;
            transform: translateX(-30%);
            max-width: calc(100vw - 20px);
        } */

        .event-full {
            border-radius: 20px;
            background-color: #426BD4;
            color: #fff;
            overflow: hidden;
        }

        .image-container {
            position: relative;
            overflow: hidden;
        }

        .image-container img {
            transition: transform 0.3s ease;
        }

        .image-container:hover img {
            transform: scale(1.1);
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

        /* .nav-item > a{
            border-left: 1px solid #fff;
        } */

        .footer-link {
            color: #fff !important;
            text-decoration: none !important;
        }

        .footer-link:hover {
            color: #efefef !important;
        }

        .dropdown {
            position: static !important;
        }

        .dropdown-menu {
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
            margin-top: 0px !important;
            width: 100% !important;
            border-bottom-left-radius: 20px !important;
            border-bottom-right-radius: 20px !important;
            position: relative;
            background-color: rgba(255, 255, 255, .8) !important;
            /* display: block; */
        }
        .upload_photo{
            font-weight: 800;
            padding: 20px 30px;
            border-radius: 20px !important;
            background-color: #426BD4;
            color: white;
            border: none;
        }
        .upload_photo:hover{
            background-color: rgba(66, 107, 212, 0.7)
        }
        .upload_selfie{
            font-weight: 800;
            padding: 20px 30px;
            border-radius: 20px !important;
            background-color: #FF5C00;
            color: white;
            border: none;
        }
        .upload_selfie:hover{
            background-color: rgba(255, 94, 0, 0.7);
            color: white;
        }
        #image-preview{
            width: 100%;
            /* margin-left: 20px; */
            border-radius: 20px;
            overflow: hidden; 
        }
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
        #image-preview {
            display: none;
            max-width: 100%;
            max-height: 200px;
            margin-bottom: 10px;
        }

        #camera-preview {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
        .navbar-toggler {
            position: absolute;
            right: 5px !important;
            top: -50px;
        }
    </style>
</head>

<body style="font-family: 'Outfit';">

    <!-- Header -->
    <header class="navbar-custom fixed-top p-3">
        <div class="container">
            <div class="row align-items-center  ">
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
                                        style="color: #fff;"><u>Find Photos</u></a>
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
                                        <span class='badge badge-warning' id='lblCartCount'
                                            style="display: none;"></span>
                                    </a>
                                </li>
                                @if (count(session()->get('front_user', [])))
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            href="{{ action([\App\Http\Controllers\FrontEndController::class, 'userProfile']) }}"
                                            style="color: #fff;">Profile</a>
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
    <section style="margin-top: 120px;">

        <div class="container">
            <div class="row mt-5 mb-4 ">
                <div class="col-md-12 blue-div mt-3">
                    <div class="row">
                        <div class="col-md-4 p-5">
                            <h2>LOOKING FOR YOUR PHOTOS?</h2>
                        </div>
                        <div class="col-md-4 p-5">
                            <p>Simply search your photos either by event name, date, face recognition or photographer
                            </p>
                        </div>
                        <div class="col-md-4">
                            <div style="margin-top: -20px;">
                                <img src="{{ asset('images/front/img-find-photos-banner.png') }}" alt=""
                                    class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <section class="mt-4">
        <div class="container">

            <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
                <span class="navbar-brand">Find Photos By</span>
                <button class="navbar-toggler" style="top: 0px !important;" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Event Name
                            </a>
                            <div class="dropdown-menu dropdown-menu-1 mb-3 mt-3 p-4"
                                aria-labelledby="navbarDropdownMenuLink">
                                <div class="input-group col-md-4 ">
                                    <div class="input-group-prepend" onclick="getData()">
                                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                                    </div>
                                    <input type="search" id="event_name" class="form-control" placeholder="Type to search event" onkeydown="if(event.keyCode === 13) getData()">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="getData()"
                                            type="button"><i class="fa fa-caret-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Selfie Search
                            </a>
                            <div class="dropdown-menu dropdown-menu-2 mb-3 mt-3 p-4"
                                aria-labelledby="navbarDropdownMenuLink">
                                <div class="row">
                                    
                                <div class="col-md-3 p-4 text-center">
                                    <img id="image-preview" src="{{ asset('images/front/findphotos_default.png') }}"
                                        alt="Selected Image" class="img-fluid">
                                        <p class="mt-2" style="font-weight: 500;font-size:14px;">
                                            <b>
                                                Please take a front view photo by looking at the camera directly when taking the selfie
                                            </b>
                                        </p>
                                        <p style="font-size:14px;">
                                            *Your photos will not be stored anywhere Read more in our 
                                            <a 
                                            href="{{ action([\App\Http\Controllers\FrontEndController::class, 'PrivacyPolicy']) }}">Privacy
                                            Policy</a>
                                        </p>
                                </div>
                                <div class="col-md-4 p-4">
                                    <input type="file" id="file-input" accept="image/*" style="display: none;">
                                    <button id="select-btn" class="btn btn-primary mt-2 btn-block upload_photo close_dd" >UPLOAD PHOTO</button>

                                    <!-- Button to capture a selfie -->
                                    <button id="capture-btn" class="btn btn-warning mt-2 btn-block upload_selfie close_dd"
                                        data-toggle="modal" data-target="#selfieModal">TAKE A SELFIE</button>
                                </div>
                                </div>
                                <!-- Image preview -->


                            </div>
                        </li>
                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                SKU / UID
                            </a>
                            <div class="dropdown-menu dropdown-menu-3 mb-3 mt-3 p-4"
                                aria-labelledby="navbarDropdownMenuLink">
                                <div class="input-group  col-md-4 ">
                                    <div class="input-group-prepend" onclick="getData()">
                                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                                    </div>
                                    <input type="search" id="photo_sku" class="form-control" onkeydown="if(event.keyCode === 13) getData()">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="getData()"
                                            type="button"><i class="fa fa-caret-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </li> --}}
                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Face Recognition
                            </a>
                            <div class="dropdown-menu dropdown-menu-3  mb-3 mt-3 p-3"
                                aria-labelledby="navbarDropdownMenuLink">
                                <form class="form-inline">
                                    <div class="input-group ">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                                        </div>
                                        <input type="search" class="form-control">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button"><i
                                                    class="fa fa-caret-right"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li> --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Photographers
                            </a>
                            <div class="dropdown-menu mb-4 mt-3 p-4" aria-labelledby="navbarDropdownMenuLink">
                                <div class="input-group  col-md-4 ">
                                    <div class="input-group-prepend" onclick="getData()">
                                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                                    </div>
                                    <input type="search" id="event_photographer" class="form-control" placeholder="Type to search photographer" onkeydown="if(event.keyCode === 13) getData()">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="getData()"
                                            type="button"><i class="fa fa-caret-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="clear_filters" style="cursor: pointer;"><b>Clear all filters </b></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </section>
    <!-- Sections -->
    <section class="mt-4">
        <div class="container" id="event_container">






        </div>

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
    </section>

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
    <!-- Modal for capturing selfie -->
    <div class="modal fade" id="selfieModal" tabindex="-1" role="dialog" aria-labelledby="selfieModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="selfieModalLabel">Capture Selfie</h5>
                    <button type="button" class="close  stop-camera" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Video element for camera preview -->
                    <video id="camera-preview" autoplay></video>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary stop-camera" data-dismiss="modal">Close</button>
                    <!-- Button to capture selfie -->
                    <button type="button" class="btn btn-primary" id="take-selfie">Take Selfie</button>
                </div>
            </div>
        </div>
    </div>

    <div class="loader-overlay">
        <div class="loader"></div>
    </div>
    <!-- Bootstrap and Font Awesome JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
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
            // Prevent dropdowns from auto-closing
            $('.dropdown').on('hide.bs.dropdown', function(e) {
                if ($(this).is(e.target)) {
                    e.preventDefault();
                }
            });
            //on focus out hide dropdown
            $(document).click(function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown-menu').hide();
                }
            });
            // Manually show/hide dropdowns when their toggle button is clicked
            $('.dropdown-toggle').click(function() {
                var dropdownMenu = $(this).next('.dropdown-menu');

                if (dropdownMenu.is(':visible')) {
                    // If the dropdown menu is visible, hide it
                    dropdownMenu.hide();
                } else {
                    // If the dropdown menu is not visible, hide all other dropdown menus and show this one
                    $('.dropdown-menu').hide();
                    dropdownMenu.show();
                }
            });
        });

        function getData() {
            $('.dropdown-menu').hide();
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            event_name = $("#event_name").val();
            photo_sku = $("#photo_sku").val();
            event_photographer = $("#event_photographer").val();
            imageData = $('#image-preview').attr('src');
            var postData = {
                event_name: event_name,
                photo_sku: photo_sku,
                event_photographer: event_photographer,
                image: imageData,
                _token: csrfToken
            };

            $('.loader-overlay').show();
            $.ajax({
                url: "{{ action([\App\Http\Controllers\FrontEndController::class, 'getEvents']) }}",
                type: "POST",
                data: postData,
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                success: function(response) {
                    if (response.success) {
                        $("#event_container").html(response.events_design);
                        $('.loader-overlay').hide();
                    }else{
                        toastr.error(response.msg);
                        $('.loader-overlay').hide();
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error("Error:", error);
                    $('.loader-overlay').hide();
                }
            });
        }

        $(document).ready(function() {
            getData();
        });
        $('#clear_filters').click(function (e) { 
            e.preventDefault();
            $("#event_name").val('');
            $("#event_date").val('');
            $("#event_photographer").val('');
            $('#image-preview').attr('src', "{{ asset('images/front/findphotos_default.png') }}");
            getData();
        });



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

        $(document).ready(function() {
            const fileInput = $('#file-input');
            const selectButton = $('#select-btn');
            const imagePreview = $('#image-preview');
            const ajaxStatus = $('#ajax-status');
            let stream = null;

            // Event listener for file input change
            fileInput.change(function() {
                const file = fileInput.prop('files')[0];
                if (file) {
                    // Display selected image
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        imagePreview.attr('src', event.target.result);
                        imagePreview.css('display', 'block');
                        getData();
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Event listener for select button click
            selectButton.click(function() {
                fileInput.click();
            });

            // Event listener for taking selfie button click
            $('#take-selfie').click(function() {
                const video = document.getElementById('camera-preview');
                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                const imageData = canvas.toDataURL('image/png');

                // Display captured selfie
                imagePreview.attr('src', imageData);
                imagePreview.css('display', 'block');

                // Stop camera
                if (stream) {
                    stream.getTracks().forEach(function(track) {
                        track.stop();
                    });
                }

                $('#selfieModal').modal('hide'); // Close the modal
                getData();
            });

            // Function to initialize camera preview
            function initCamera() {
                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(function(mediaStream) {
                        stream = mediaStream;
                        const video = document.getElementById('camera-preview');
                        video.srcObject = mediaStream;
                        video.play();
                    })
                    .catch(function(error) {
                        console.error('Error accessing camera:', error);
                        alert('Error accessing camera. Please try again.');
                    });
            }

            // Function to stop camera recording
            $(".stop-camera").click(function() {
                if (stream) {
                    stream.getTracks().forEach(function(track) {
                        track.stop();
                    });
                }
            });

            // Open camera modal when Capture Selfie button is clicked
            $('#capture-btn').click(function() {
                initCamera();
            });
        });
    </script>
    </script>
</body>

</html>
