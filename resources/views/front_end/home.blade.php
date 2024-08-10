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
            padding: 20px 30px;
            border-radius: 20px;
            font-weight: bold;
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

        .uppercase {
            text-transform: uppercase;
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
                    <nav class="navbar navbar-expand-lg navbar-dark">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
                            style="">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ action([\App\Http\Controllers\FrontEndController::class, 'home']) }}"
                                        style="color: #fff;"> <u>Home</u></a>
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
    </header>

    <!-- Slider -->
    <section style="margin-top: 88px;">

        <div id="carouselExample" class="carousel slide" data-ride="carousel" data-interval="2000">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('images/front/Rectangle_26.png') }}" class="d-block w-100" alt="Image 1">
                    <div class="carousel-caption d-none d-md-block">
                        <h1>SHOOT. SHARE. SELL.</h1>
                    </div>
                </div>
                <div class="carousel-item">
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
            </div>
            <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </section>
    </section>

    <!-- Sections -->
    <section class="mt-4">
        <div class="container">
            <div class="row mt-4 mb-4">
                <div class="col-md-5">
                    <h2>Are you a</h2>
                    <h1 class="uppercase">Photographer?</h1>
                    <p>Here is a platform to share and sell your photos from an event..</p>
                    <div class="row">
                        <div class="col-md-2"><img src="{{ asset('images/front/vector.png') }}" alt="Image 1">
                        </div>
                        <div class="col-md-10">
                            <h4>Ease of uploading</h4>
                            <p>With easy to use gallery creation uploading has been made simpler. Unlimited galleries for you event. Simply drag and drop your images into your galleries.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"><img src="{{ asset('images/front/vector.png') }}" alt="Image 1">
                        </div>
                        <div class="col-md-10">
                            <h4>Your own branding</h4>
                            <p>Where not here to advertise us. Your brand is important to you. Choosing your subscription will give you all your own branding and watermarking on your images.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"><img src="{{ asset('images/front/vector.png') }}" alt="Image 1">
                        </div>
                        <div class="col-md-10">
                            <h4>Embed onto your website</h4>
                            <p>We have done the hard work for you by providing an embedded window that will seamless integrate with your own website.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"><img src="{{ asset('images/front/vector.png') }}" alt="Image 1">
                        </div>
                        <div class="col-md-10">
                            <h4>High speed upload</h4>
                            <p>Utilising the latest tech we deliver the fast upload available. The only restriction is the speed of your internet.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"><img src="{{ asset('images/front/vector.png') }}" alt="Image 1">
                        </div>
                        <div class="col-md-10">
                            <h4>Less commission</h4>
                            <p>Select the level of commission we through our unique subscriptions. Pay as little as 7% commission on your image sales.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-7"
                    style="background-image: url('{{ asset('images/front/section1.png') }}');background-size:contain;    background-repeat: no-repeat;background-position: center;">

                </div>
            </div>
        </div>





        <div style="background-color:#0094FF;color:#fff; ">
            <div class="container">
                <div class="row mt-4">
                    <div class="col-md-6"
                        style="background-image: url('{{ asset('images/front/dashborad1.png') }}');background-size:contain;background-repeat:no-repeat;background-position:center;">

                    </div>
                    <div class="col-md-6 mt-4">
                        <h2>Custom dashboard to manage your photos and albums</h2>
                        <ul>
                            <li>Invite multi users at different levels</li>
                            <li>Visual real-time stats </li>
                            <li>Track financials</li>
                            <li>Build your photography team for an event. </li>
                        </ul>
                        <div class="row" style="text-align: center;">
                            <div class="col-md-3">
                                <a href="<?= env('APP_URL') ?>/event-management" target="_blank" style="text-decoration:none;color:#fff;"> 
                                    <img src="{{ asset('images/front/Vector_green.png') }}" style="width:57px"
                                        alt="Image 1">
                                    <p class="uppercase"><small>Create an Event</small></p>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="<?= env('APP_URL') ?>/event-management" target="_blank" style="text-decoration:none;color:#fff;"> 
                                <img src="{{ asset('images/front/img_green.png') }}" style="width:57px"
                                    alt="Image 1">
                                <p class="uppercase"><small>Upload your Photos</small></p>
                            </a>
                            </div>
                            <div class="col-md-3">
                                <a href="<?= env('APP_URL') ?>/event-management" target="_blank" style="text-decoration:none;color:#fff;"> 
                                <img src="{{ asset('images/front/cart_green.png') }}" style="width:57px"
                                    alt="Image 1">
                                <p class="uppercase"><small>Share and Sell your Photos</small></p>
                            </a>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <a class="btn btn-learn-more"
                                    href="{{ action([\App\Http\Controllers\FrontEndController::class, 'buySubscription']) }}">LEARN
                                    MORE</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div style="background-color:#1E1832;color:#fff;  ">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 mt-5">
                        <h2>Events.</h2>
                        <h1 class="uppercase">Looking for your photos?</h1>
                        <div class="row">
                            <div class="col-md-2"><img src="{{ asset('images/front/vector.png') }}" alt="Image 1">
                            </div>
                            <div class="col-md-10">
                                <h4>Search for event and date</h4>
                                <p>With our dedicated server we support a high-speed bandwidth to upload and download
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"><img src="{{ asset('images/front/vector.png') }}" alt="Image 1">
                            </div>
                            <div class="col-md-10">
                                <h4>Find images by facial recognition and bid number</h4>
                                <p>Your event pages will be branded and all photos will be watermarked with your own
                                    logo so
                                    you can directly promote to your customers</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"><img src="{{ asset('images/front/vector.png') }}" alt="Image 1">
                            </div>
                            <div class="col-md-10">
                                <h4>Download for socials and high-resolution images</h4>
                                <p>Your event pages will be branded and all photos will be watermarked with your own
                                    logo so
                                    you can directly promote to your customers</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"><img src="{{ asset('images/front/vector.png') }}" alt="Image 1">
                            </div>
                            <div class="col-md-10">
                                <h4>Secure payment gateway</h4>
                                <p>With our dedicated server we support a high-speed bandwidth to upload and download
                                </p>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-7"
                        style="background-image: url('{{ asset('images/front/events1.png') }}');;background-size:contain;background-repeat:no-repeat;background-position:center;">

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                    </div>
                    <div class="col-md-7" style="text-align:center;">
                        <a class="btn btn-learn-more"
                            href="{{ action([\App\Http\Controllers\FrontEndController::class, 'findPhotos']) }}">FIND
                            YOUR PHOTOS</a>
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
    @include('front_end.modal_login')
    @include('front_end.modal_signup')
    @include('front_end.modal_signup_front')
    @include('front_end.modal_forgot')
    @include('front_end.modal_responce')
    @include('front_end.modal_reset')
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
    @if ($token)
        <script>
            $("#resetModal").modal('show');
        </script>
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
                                if (element) {
                                    element.each(function() {
                                        console.log($(this)
                                            .text()
                                        ); // Output the text content of each matched element
                                        $(element).css('background-color',
                                            'rgba(0, 0, 0, 0.6)');
                                    });
                                }
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
</body>

</html>
