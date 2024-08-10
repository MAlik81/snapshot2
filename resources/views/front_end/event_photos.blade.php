<!DOCTYPE html>
<html lang="en" oncontextmenu="return true;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.css"
        integrity="sha512-oe8OpYjBaDWPt2VmSFR+qYOdnTjeV9QPLJUeqZyprDEQvQLJ9C5PCFclxwNuvb/GQgQngdCXzKSFltuHD3eCxA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href=" {{ asset('css/front-skins.min.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Snapshot HUB</title>
    <style>
        body {
            background: #fff;
        }

        .filters {
            background-color: #f1f1f1;
            border-radius: 20px;
        }

        .event-name {
            padding: 15px 40px;
            background-color: #f1f1f1;
            border-radius: 20px;
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

        .navbar-custom .dropdown-menu {
            width: 50vw;
            /* left: 50%; */
            transform: translateX(-50%);
            max-width: calc(100vw - 20px);
            border-radius: 0 0 20px 20px;
        }

        .navbar-custom .dropdown-menu-1 {
            width: 50vw;
            /* left: 50%; */
            transform: translateX(-7%);
            max-width: calc(100vw - 20px);
        }

        .navbar-custom .dropdown-menu-2 {
            width: 50vw;
            /* left: 50%; */
            transform: translateX(-22%);
            max-width: calc(100vw - 20px);
        }

        .navbar-custom .dropdown-menu-3 {
            width: 50vw;
            /* left: 50%; */
            transform: translateX(-30%);
            max-width: calc(100vw - 20px);
        }

        .event-full {
            border-radius: 20px;
            background-color: #426BD4;
            color: #fff;
            overflow: hidden;
        }

        #flatpickr-calendar {
            width: 95% !important;
            margin: 0 auto;
        }

        .check-mark {
            position: absolute;
            font-size: 25px;
            padding: 10px;
            color: white;
            background-color: rgba(255, 255, 255, 0.6);
            right: 25px;
            top: 10px;
            border-radius: 50%;
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

        .footer-link {
            color: #fff !important;
            text-decoration: none !important;
        }

        .footer-link:hover {
            color: #efefef !important;
        }

        .skin-black {
            background-color: #070707 !important;
        }

        .skin-black .main-header .navbar_custom {
            background-color: #070707 !important;
        }
    </style>
    <style>
        .image-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .image-item {
            margin: 5px;
            position: relative;
            /* width: 200px; Adjust as per your requirement */
        }

        .image-item img {
            max-width: 100%;
            height: 170px !important;
            display: block;
            border-radius: 20px;
            overflow: hidden;
        }
    </style>
    <style>
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
            top: -70px;
        }
    </style>
</head>

<body style="font-family: 'Outfit';">

    <!-- Header -->
    <header class="navbar-custom fixed-top  main-header">
        <div class="main-header">
            <div class="navbar_custom">
                <div class=" container ">
                    <div class="row align-items-center p-4 ">
                        <div class="col-lg-5">
                            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png"
                                alt="Logo" class="img-fluid business_logo" style="height:100px;border-radius:50%">
                            <strong style="color: #fff;font-size:30px;" class="p-1 business_name"> --</strong>
                        </div>
                        <div class="col-lg-7">
                            <nav class="navbar navbar-expand-lg navbar-dark" style="text-align:center;">
                                <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                                    aria-label="Toggle navigation">
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
            </div>
        </div>
    </header>

    <!-- Slider -->
    <section style="margin-top:200px;">

        <div class="container">
            <div class="row mt-5">
                <div class="col-md-3 mt-3">
                    <div class="filters">
                        <h2 class=" p-4" style="cursor: pointer;">Filter by <span style="font-size: 10px;"
                                onclick="clearfilters()"><u>Clear
                                    All Filters</u></span></h2>
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn" data-toggle="collapse" data-target="#collapseOne"
                                            aria-expanded="true" aria-controls="collapseOne">
                                            Album
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        <ul>
                                            @foreach ($Eventalbums as $album)
                                                <li>
                                                    <a
                                                        href="{{ route('event-photos', ['event_id' => $album->event_id, 'album_id' => $album->id]) }}">{{ $album->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn collapsed" data-toggle="collapse"
                                            data-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                            Date
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse p-1" aria-labelledby="headingTwo"
                                    data-parent="#accordion">
                                    <input type="date" id="photo_date" class="form-control">
                                    <button class="btn btn-block btn-secondary p-2" id="photo_date_button">Search
                                        Now</button>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="btn collapsed" data-toggle="collapse"
                                            data-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            Face Recognition
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                    data-parent="#accordion">
                                    <div class="card-body">

                                        <!-- Image preview -->
                                        <img id="image-preview" src="" alt="Selected Image"
                                            class="img-fluid mt-3">

                                        <input type="file" id="file-input" accept=".jpg, .jpeg, .png"
                                            style="display: none;">
                                        <button id="select-btn" class="btn btn-primary mt-2 btn-block">Select Image
                                            from Files</button>

                                        <!-- Button to capture a selfie -->
                                        <button id="capture-btn" class="btn btn-primary mt-2 btn-block"
                                            data-toggle="modal" data-target="#selfieModal">Capture Selfie</button>


                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingFour">
                                    <h5 class="mb-0">
                                        <button class="btn collapsed" data-toggle="collapse"
                                            data-target="#collapseFour" aria-expanded="false"
                                            aria-controls="collapseFour">
                                            Bib Number
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseFour" class="collapse p-1" aria-labelledby="headingFour"
                                    data-parent="#accordion">

                                    <input type="text" pattern="[0-9]*" id="photo_bib" class="form-control">
                                    <button class="btn btn-block btn-secondary p-2" id="photo_bib_button">Search
                                        Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <h2 class="event-name">{{ $selected_album ? $selected_album->name : '' }}</h2>
                    <div class="row mt-2 mb-2">
                        <div class="image-container" id="image-container">

                            <!-- Add more image items as needed -->
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

    <!-- Modal for capturing selfie -->
    <div class="modal fade" id="selfieModal" tabindex="-1" role="dialog" aria-labelledby="selfieModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="selfieModalLabel">Capture Selfie</h5>
                    <button type="button" class="close stop-camera" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Video element for camera preview -->
                    <video id="camera-preview" autoplay width="200px"></video>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary stop-camera" data-dismiss="modal">Close</button>
                    <!-- Button to capture selfie -->
                    <button type="button" class="btn btn-primary" id="take-selfie">Take Selfie</button>
                </div>
            </div>
        </div>
    </div>



    <input type="hidden" id="popup_image_id">
    <div id="imagePopup" class="modal fade" tabindex="-1" role="dialog">
        <span class="fa fa-chevron-left"
            style="
        position: absolute;
        top: 30%;
        left: 10%;
        z-index: 999;
        color: black;
        font-size: 50px;
        cursor: pointer;
    "></span>
        <span class="fa fa-chevron-right"
            style="
                position: absolute;
                top: 30%;
                right: 10%;
                z-index: 999;
                color: black;
                font-size: 50px;
                cursor: pointer;
            "></span>
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius:20px;">
                <div class="modal-header" style="border-bottom:0px solid white;padding: 1rem 2rem;">
                    <p class="modal-title" style="font-size: 20px !important;" id="event_name_pp">Image Preview</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><img src="{{ asset('images/front/fa-close.png') }}" height=""
                                alt="Footer Logo" class="img-fluid"
                                style="color: white; font-size:15px;font-weight:bold; "></span>
                    </button>
                </div>
                <div class="modal-body" style="border-bottom:0px solid white;padding: 0rem 1rem; ">
                    <img class="img-fluid" id="modalImage"
                        style="width:100%;border-radius:20px;overflow:hidden;margin:0 auto;">
                    <div id="overlay_div"
                        style="z-index:900;border-radius:20px;overflow:hidden;margin:0 auto;position: absolute;width:96%;height:100%;top:0px;opacity: 0.3;background-size: 300px;background-repeat: repeat;">
                    </div>
                </div>
                <div
                    style="padding: 1rem;
                border-top: 0px solid #ffffff;
                border-bottom-right-radius: 0.3rem;
                border-bottom-left-radius: 0.3rem;
            ">
                    <div class="row">
                        <div class="col-md-7">
                            <p
                                style="font-size: 32px;
                            margin-bottom: 0px;
                            line-height: 32px;">
                                <b>$<span id="price_pp"></span></b>
                            </p>
                            <p style="font-size: 14px;">For high resolution digital download </p>
                        </div>
                        <div class="col-md-5">
                            <button
                                style="float: right !important;
                            background-color: black !important;
                            font-size: 15px !important;
                            color: white !important;
                            padding: 7px 14px !important;
                            border-radius: 20px !important;
                            opacity:1 !important;
                            line-height: 2 !important;
                            border:1px solid black !important;"
                                id="addtocartpopup" class="btn btn-xs close" data-dismiss="modal" aria-label="Close"
                                style="">+ ADD TO CART <i class="fa fa-shopping-cart"
                                    style="font-size: 20px;"></i></button>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <p
                                style="font-size: 32px;
                            margin-bottom: 0px;
                            line-height: 32px;">
                                <b>$<span id="price_pp_lq"></span></b>
                            </p>
                            <p style="font-size: 14px;">For low resolution digital download </p>
                        </div>
                        <div class="col-md-5">
                            <button
                                style="float: right !important;
                            background-color: black !important;
                            font-size: 15px !important;
                            color: white !important;
                            padding: 7px 14px !important;
                            border-radius: 20px !important;
                            opacity:1 !important;
                            line-height: 2 !important;
                            border:1px solid black !important;"
                                id="addtocartpopuplq" class="btn btn-xs close" data-dismiss="modal"
                                aria-label="Close" style=""> + ADD TO CART <i class="fa fa-shopping-cart"
                                    style="font-size: 20px;"></i></button>
                        </div>

                    </div>
                </div>
            </div>
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
        // var iframeUrl = '';
        // Check if the page is inside an iframe
        // if (window.self !== window.top) {
        //     // Select all anchor elements
        //     var anchorElements = document.querySelectorAll('a');

        //     // Update target attribute to _blank for all anchor elements
        //     anchorElements.forEach(function(anchor) {
        //         anchor.setAttribute('target', '_blank');
        //     });

        //     // Get the URL of the current page inside the iframe
        //     iframeUrl = window.location.href;
        //     console.log("The URL inside the iframe is: " + iframeUrl);
        // }

        $(function() {
            $("#datepicker").datepicker({
                dateFormat: "yy-mm-dd",
                showButtonPanel: true, // Show button panel for navigation
            });
        });


        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var total_img = 0;
        var curent_img = 0;

        function getData() {

            // if (iframeUrl) {
            //     window.open(iframeUrl, '_blank');
            // }
            // Get the image data from the image preview element
            var imageData = $('#image-preview').attr('src');

            // Update the postData object with the image data
            var postData = {
                event_id: {{ $event_id }},
                event_date: $("#photo_date").val(),
                photo_bib: $("#photo_bib").val(),
                image: imageData,
                album_id: {{ $selected_album ? $selected_album->id : 0 }},
                _token: csrfToken
            };
            $('.loader-overlay').show();
            // Send AJAX request with updated postData
            $.ajax({
                url: "{{ action([\App\Http\Controllers\FrontEndController::class, 'getEventAlbumPhotos']) }}",
                type: "POST",
                data: postData,
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                success: function(response) {
                    console.log(response);
                    console.log(response.success);
                    if (response.success) {
                        $("#image-container").html(response.events_design);
                        $(".business_logo").attr('src', response.business_logo);
                        $(".business_name").html(response.business_name);
                        var theme_color = response.theme_color;
                        if (theme_color) {
                            $("header").addClass('skin-' + theme_color);
                            $("footer").addClass('skin-' + theme_color);
                        } else {
                            $("header").addClass('skin-blue');
                        }
                    } else {
                        console.log(response);
                        console.log(response.msg);
                        toastr.error(response.msg);
                    }
                    $('.loader-overlay').hide();
                    $('#image-preview').attr('src', '');
                    $('#image-preview').hide();
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error("Error:", error);
                    toastr.error(error);
                    $('.loader-overlay').hide();
                    $('#image-preview').attr('src', '');
                    $('#image-preview').hide();
                }
            });



        }


        $(document).ready(function() {

            getData();
        });
        $("#photo_bib_button").click(function(e) {
            e.preventDefault();
            getData();
        });
        $("#photo_date_button").click(function(e) {
            e.preventDefault();
            getData();
        });

        function clearfilters() {
            $('#image-preview').attr('src', '');
            $('#image-preview').hide();
            $("#photo_date").val('');
            $("#photo_bib").val('');
            getData();
        }


        $('.check-mark').on('click', function() {
            console.log($(this).data(photoid));
        });

        function addtocart(element, id) {
            
            // if (iframeUrl) {
            //     window.open(iframeUrl, '_blank');
            // }
            console.log(id);
            var postData = {
                photo_id: id,
                low_quality: 0
            };
            console.log($(element).css('background-color'));
            if ($(element).css('background-color') == 'rgba(255, 255, 255, 0.6)') {
                // $(element).css('background-color', 'rgba(0, 0, 0, 0.6)');
                $(element).siblings('img').click()
                // $.ajax({
                //     url: "{{ action([\App\Http\Controllers\FrontEndController::class, 'updateCart']) }}",
                //     type: "POST",
                //     data: postData,
                //     dataType: "json",
                //     headers: {
                //         "X-CSRF-TOKEN": csrfToken,
                //     },
                //     success: function(response) {
                //         console.log(response);
                //         if (response.count) {
                //             toastr.success('Added to cart');
                //             $("#lblCartCount").html(response.count);
                //             $("#lblCartCount").show();
                //         } else {

                //             $("#lblCartCount").html(response.count);
                //             $("#lblCartCount").hide();
                //         }
                //     },
                //     error: function(xhr, status, error) {
                //         // Handle errors
                //         console.error("Error:", error);
                //     }
                // });
            } else {
                $(element).css('background-color', 'rgba(255, 255, 255, 0.6)');

                $.ajax({
                    url: "{{ action([\App\Http\Controllers\FrontEndController::class, 'deleteCart']) }}",
                    type: "POST",
                    data: postData,
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.count) {
                            toastr.success('Removed from cart');
                            $("#lblCartCount").html(response.count);
                            $("#lblCartCount").show();



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
            }


        }




        $("#addtocartpopup").click(function(e) {
            
            // if (iframeUrl) {
            //     window.open(iframeUrl, '_blank');
            // }
            e.preventDefault();
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var postDatatemp = {
                photo_id: $('#popup_image_id').val(),
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
            // $('#imagePopup').modal('hide');
            // $("#imagePopup").hide();
            // $(".modal-backdrop").hide();

        });
        $("#addtocartpopuplq").click(function(e) {
            
            // if (iframeUrl) {
            //     window.open(iframeUrl, '_blank');
            // }
            e.preventDefault();
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var postDatatemp = {
                photo_id: $('#popup_image_id').val(),
                low_quality: 1
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
            // $('#imagePopup').modal('hide');

            // $("#imagePopup").hide();
            // $(".modal-backdrop").hide();

        });
    </script>
    <script>
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

    <script>
        $(document).ready(function() {

            $(".gallery-image").on('click', function() {
                var imageSrc = $(this).data('image');
                console.log(imageSrc);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            setTimeout(() => {
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

            }, 2000);

        });

        $(document).ready(function() {
            // Function to update the popup image and details
            function updatePopuupImage(imageSrc, id, price, low_quality_price, overlay_path, overlay_position,
                event_name, curent, total) {
                console.log("Updating popup with image:", imageSrc);
                $('#modalImage').attr('src', imageSrc);
                total_img = total;
                curent_img = curent;
                $("#popup_image_id").val(id);
                $("#price_pp").html(price);
                $("#price_pp_lq").html(low_quality_price);
                $("#event_name_pp").html(event_name + ' (SKU: ' + id + ')');
                $("#overlay_div").css("background-image", "url('" + overlay_path + "')");
                $('#imagePopup').modal('show');

            }

            // Event delegation for dynamically added elements
            $(document).on('click', '[id^=imageitem_]', function() {
                var imageSrc = $(this).data('path');
                var id = $(this).data('id');
                var price = $(this).data('price');
                var low_quality_price = $(this).data('lowQualityPrice');
                var overlay_path = $(this).data('overlayPath');
                var overlay_position = $(this).data('overlayPosition');
                var event_name = $(this).data('eventName');
                var curent = $(this).data('curent');
                var total = $(this).data('total');
                console.log(imageSrc, id, price, low_quality_price, overlay_path, overlay_position,
                    event_name, curent, total);
                updatePopuupImage(imageSrc, id, price, low_quality_price, overlay_path, overlay_position,
                    event_name, curent, total);
                $('#imagePopup').modal('show');
            });

            // Function to move the slider
            function moveslider(pl) {
                console.log("Slider move:", pl, "Total images:", total_img, "Current image:", curent_img);
                if (pl + curent_img >= 0 && pl + curent_img < total_img) {
                    curent_img = curent_img + pl;
                    console.log("New current image index:", curent_img);
                    let nextImage = $("#imageitem_" + curent_img);
                    console.log("Next image element:", nextImage);
                    if (nextImage.length > 0) {
                        nextImage.trigger('click');
                        $('#imagePopup').modal('show');
                    } else {
                        console.error("Next image not found");
                    }
                } else {
                    console.warn("Index out of bounds");
                }
            }

            // Example of how to trigger the slider move on arrow click
            $('.fa-chevron-left').click(function() {
                moveslider(-1);
            });

            $('.fa-chevron-right').click(function() {
                moveslider(1);
            });
        });
    </script>
</body>

</html>
