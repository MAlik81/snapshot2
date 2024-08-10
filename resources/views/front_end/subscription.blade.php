<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Snapshot HUB</title>
    <style>
        body {
            background: #DEDDE4;
        }

        .navbar-custom {
            background-color: #1E1832;
        }

        .join-now {
            background-color: #1E1832;
            color: #D89623;
            font-weight: 900 !important;
            border-radius: 0px !important;
            width: 100%;
            height: 100%;
            font-size: 20px;
        }

        .join-now:hover {
            color: #fff;
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

        .footer-link {
            color: #fff !important;
            text-decoration: none !important;
        }

        .footer-link:hover {
            color: #efefef !important;
        }

        .table th {
            border-bottom: none !important;
        }

        .table td {
            border-top: none !important;
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
                                        style="color: #fff;"><u>Photographer</u></a>
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
    <section style="margin-top: 88px;">

        <div id="carouselExample" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('images/front/Header-photographers.png') }}" class="d-block w-100"
                        alt="Image 1">
                    <div class="carousel-caption d-none d-md-block">

                        <h1 style="font-size:150px !important;">It’s time.</h1>
                        <h1>SHOOT. SHARE. SELL.</h1>
                    </div>
                </div>
                {{-- <div class="carousel-item">
                    <img src="{{ asset('images/front/Rectangle_27.png') }}" class="d-block w-100" alt="Image 2">
                    <div class="carousel-caption d-none d-md-block">
                        <h1>SHOOT. SHARE. SELL.</h1>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/front/Rectangle_28.png') }}" class="d-block w-100" alt="Image 3">
                    <div class="carousel-caption d-none d-md-block">
                        <h1>SHOOT. SHARE. SELL.</h1>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/front/Rectangle_29.png') }}" class="d-block w-100" alt="Image 4">
                    <div class="carousel-caption d-none d-md-block">
                        <h1>SHOOT. SHARE. SELL.</h1>
                    </div>
                </div>
            </div> --}}
                {{-- <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a> --}}
            </div>
    </section>

    <!-- Sections -->
    <section class="mt-4">
        <div class="container">
            <div class="row mt-4 mb-4">
                <div class="col-md-12">
                    <h1 style="font-size:5vw"> <strong>Easy. Easy. Easy</strong></h1>
                    {{-- <p>Here is a platform to share and sell your photos from an event..</p> --}}
                    <div class="row" style="font-size:90%;">
                        <div class="col-md-4 p-3">
                            <h5>High speed upload</h5>
                            <p>With our dedicated server we support a High-Speed bandwidth to Upload and Download. </p>
                        </div>
                        <div class="col-md-4 p-3">
                            <h5>Your own brand</h5>
                            <p>Your event pages will be branded and all photos will be watermarked with your own logo so
                                you can directly promote to your customers.</p>
                        </div>
                        <div class="col-md-4 p-3">
                            <h5>Embed onto your website</h5>
                            <p>Your Event pages will be branded and all photos will be watermarked with your own logo so
                                you can directly promote to your customers.</p>
                        </div>
                        <div class="col-md-4 p-3">
                            <h5>Less commission</h5>
                            <p>You choose your commission, Depending on your subscription. You could pay as low as 7%
                                commission and brand you own work for no extra cost.</p>
                        </div>
                        <div class="col-md-4 p-3">
                            <h5>Run your own event</h5>
                            <p>With a dedicated team management feature you can choose how much information your team
                                can see. Make your team members team partners and they can see the sales or employ
                                Freelance photographers that only have upload access. You Choose!</p>
                        </div>
                        <div class="col-md-4 p-3">
                            <h5>The Choice is Easy</h5>
                            <p>Choose your commission, Choose your team structure, Choose to integrate the iframe to
                                your website to save you thousands of dollars in web development. Choose your level of
                                advertising. </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">                
                <h1 style="font-size:5vw"> <strong>Why you choose Snapshot Hub?</strong></h1>
                <p>We have been out in the field shooting 100 of events so we know that you need something Easy to use,
                    affordable and effective in promoting your company. With our subscription based membership we will
                    advertise your business for you. You will not see our branding on your images anywhere.
                    With an Easy subscription structure you get the freedom to choose the level commission and whether
                    we run you images advertising you on our socials. </p>

            </div>
            <div class="row mb-4">
                @php
                    $count = 0;
                @endphp
                @foreach ($packages as $package)
                    {{-- @if ($package->is_private == 1 && !auth()->user()->can('superadmin'))
                        @php
                            continue;
                        @endphp
                    @endif

                    @php
                        $businesses_ids = json_decode($package->businesses);
                    @endphp --}}
                    @php
                        $count++;
                    @endphp
                    <div class="col-md-4" @if ($package->mark_package_as_popular == 1) style="transform: scale(1.1);" @endif>
                        <div style="border-radius: 20px 20px 0px 0px; overflow: hidden;">
                            <table class="table table-striped bg-white text-center table-sm">
                                <thead>
                                    <tr style="background-color:#D89623;color:white;">
                                        <th>
                                            <h1>{{ $package->name }}</h1>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            <h3> @php
                                                $interval_type = !empty($intervals[$package->interval])
                                                    ? $intervals[$package->interval]
                                                    : __('lang_v1.' . $package->interval);
                                            @endphp
                                                @if ($package->price != 0)
                                                    <span class="display_currency" data-currency_symbol="true">
                                                        ${{ number_format($package->price, 2,'.','') }}
                                                    </span>

                                                    <small>
                                                        / {{ $package->interval_count }} {{ $interval_type }}
                                                    </small>
                                                @else
                                                    @lang('superadmin::lang.free_for_duration', ['duration' => $package->interval_count . ' ' . $interval_type])
                                                @endif
                                                </small>
                                            </h3>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><b>
                                                @if ($package->platform_commission == 0)
                                                    No
                                                @else
                                                    {{ $package->platform_commission }} %
                                                @endif
                                                Commission to Snapshot Hub
                                            </b></td>
                                    </tr>
                                    <tr>
                                        <td>Use as required</td>
                                    </tr>
                                    <tr>
                                        <td>No membership fee</td>
                                    </tr>
                                    <tr>
                                        <td>Facial Recognition</td>
                                    </tr>
                                    <tr>
                                        <td>Facial Recognition for removing
                                            people under protection</td>
                                    </tr>
                                    <tr>
                                        <td>Number recognition</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @if ($package->aws_storage == 0)
                                                @lang('superadmin::lang.unlimited')
                                            @else
                                                {{ $package->aws_storage }} GBs
                                            @endif AWS storage
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @if ($package->event_data_duration == 0)
                                                Permanantly store data
                                            @else
                                                Delete data after {{ $package->event_data_duration }} Month(s) fromthe
                                                last sale of event
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>

                                            @if ($package->own_branding == 0)
                                                Can not use your own branding
                                            @else
                                                Can use your own branding
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ $package->description }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class=" text-white p-0">
                                            <a href="{{ route('login') }}" class="btn join-now p-2"><b>JOIN NOW</b>
                                            </a>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                @endforeach
                {{--                 
                <div class="col-md-4">
                    <div style="border-radius: 20px 20px 0px 0px; overflow: hidden;">
                        <table class="table table-striped bg-white text-center table-sm">
                            <thead>
                                <tr style="background-color:#D89623;color:white;">
                                    <th>
                                        <h1>Gold</h1>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <h3>3
                                            0 Days
                                        </h3>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><b>7.5% Commission to Snapshot Hub</b></td>
                                </tr>
                                <tr>
                                    <td>Use as required</td>
                                </tr>
                                <tr>
                                    <td>No membership fee</td>
                                </tr>
                                <tr>
                                    <td>Facial Recognition</td>
                                </tr>
                                <tr>
                                    <td>Facial Recognition for removing
                                        people under protection</td>
                                </tr>
                                <tr>
                                    <td>Number recognition</td>
                                </tr>
                                <tr>
                                    <td>XX GBs AWS storage</td>
                                </tr>
                                <tr>
                                    <td>Create Packages for Clients</td>
                                </tr>
                                <tr>
                                    <td>Own branding on previewed images.
                                        NO Snapshot Hub promotional
                                        anywhere on Iframe or galleries</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="navbar-custom text-white p-3">
                                        JOIN NOW
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div style="border-radius: 20px 20px 0px 0px; overflow: hidden;">
                        <table class="table table-striped bg-white text-center table-sm">
                            <thead>
                                <tr style="background-color:#D89623;color:white;">
                                    <th>
                                        <h1>Platinum</h1>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <h3>3
                                            0 Days
                                        </h3>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><b>5% Commission to Snapshot Hub</b></td>
                                </tr>
                                <tr>
                                    <td>Use as required</td>
                                </tr>
                                <tr>
                                    <td>No membership fee</td>
                                </tr>
                                <tr>
                                    <td>Facial Recognition</td>
                                </tr>
                                <tr>
                                    <td>Facial Recognition for removing
                                        people under protection</td>
                                </tr>
                                <tr>
                                    <td>Number recognition</td>
                                </tr>
                                <tr>
                                    <td>Unlimited storage</td>
                                </tr>
                                <tr>
                                    <td>Create Packages for Clients</td>
                                </tr>
                                <tr>
                                    <td>Own branding on previewed images.
                                        NO Snapshot Hub promotional
                                        anywhere on Iframe or galleries</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="navbar-custom text-white p-3">
                                        JOIN NOW
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div> --}}
            </div>
        </div>





        <div style="background-color:#0094FF;color:#fff; ">
            <div class="container">
                <div class="row mt-5 p-5">
                    <div class="col-md-6"
                        style="background-image: url('{{ asset('images/front/dashborad1.png') }}');background-size:contain;background-repeat:no-repeat;background-position:center;">

                    </div>
                    <div class="col-md-6 mt-4">
                        <h2>Custom dashboard to manage your photos and albums</h2>
                        <ul>
                            <li>Invite multi users at different levels</li>
                            <li>Visual real time stats </li>
                            <li>Track financials</li>
                            <li>Build your photography team for an event. </li>
                        </ul>
                        <div class="row" style="text-align: center;">
                            <div class="col-md-3">
                                <a href="<?= env('APP_URL') ?>/event-management" target="_blank"
                                    style="text-decoration:none;color:#fff;">
                                    <img src="{{ asset('images/front/Vector_green.png') }}" style="width:57px"
                                        alt="Image 1">
                                    <p class="uppercase"><small>Create an Event</small></p>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="<?= env('APP_URL') ?>/event-management" target="_blank"
                                    style="text-decoration:none;color:#fff;">
                                    <img src="{{ asset('images/front/img_green.png') }}" style="width:57px"
                                        alt="Image 1">
                                    <p class="uppercase"><small>Upload your Photos</small></p>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="<?= env('APP_URL') ?>/event-management" target="_blank"
                                    style="text-decoration:none;color:#fff;">
                                    <img src="{{ asset('images/front/cart_green.png') }}" style="width:57px"
                                        alt="Image 1">
                                    <p class="uppercase"><small>Share and Sell your Photos</small></p>
                                </a>
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
    </script>
</body>

</html>
