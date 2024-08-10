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
    
        .footer-link{
            color: #fff !important;
            text-decoration: none !important;
        }
        .footer-link:hover{
            color: #efefef !important;
        }
        .navbar-toggler {
            position: absolute;
            right: 5px !important;
            top: -50px;
        }
</style>
</head>

<body style="font-family: 'Outfit';" style="">

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



    <!-- Sections -->
    <section class="mt-5">
        <div class="container mt-5">
            <div class="row mt-5 mb-4">
                <div class="col-md-12 mt-5">
                    <h1 class="mt-5"
                        style="font-size: 10.625vw;font-weight: 900;color: #fff;line-height: 6.25vwletter-spacing: -0.625vw">
                        Terms</h1>
                    <h1 class="mb-5"
                        style="font-size: 5vw;font-weight: 900;color: #000;line-height: 3.188vw;letter-spacing: -0.313vw;">And
                        conditions.</h1>


                    <h1>Introduction</h1>
                    <p class="">
                        Welcome to Snapshot Hub! These Terms and Conditions govern your use of our website, platform, and services. By accessing or using Snapshot Hub, you agree to be bound by these Terms and Conditions. If you do not agree with any part of these terms, you must not use our services.
                    </p>
                   
                    <h1>Definitions</h1>
                    <p class="">
                        <ul>
                            <li><strong>Snapshot Hub:</strong> Refers to our website, platform, and services provided. </li>
                            <li><strong>User:</strong> Any individual or entity accessing or using Snapshot Hub.</li>
                            <li><strong>Content:</strong> All text, images, video, audio, and other materials available on Snapshot Hub.</li>
                            <li><strong>Services:</strong> All features and functionalities offered by Snapshot Hub.</li>
                        </ul>
                    </p>
                    <h1>Use of Services</h1>
                    <p class="">
                        <ol>
                            <li><strong>Eligibility:</strong> You must be at least 18 years old to use Snapshot Hub. By using our services, you represent and warrant that you meet this requirement. </li>
                            <li><strong>Account Registration:</strong> To access certain features, you will need to register an account. You are responsible for maintaining the confidentiality of your account information and for all activities under your account.</li>
                            <li><strong>Prohibited Conduct:</strong>You agree not to use Snapshot Hub for any unlawful or prohibited activities, including but not limited to:
                            <br>
                            <ul>
                                <li>Violating any applicable laws or regulations.</li>
                                <li>Infringing upon the rights of others.</li>
                                <li>Uploading or transmitting harmful, obscene, or otherwise objectionable content.</li>
                                <li>Uploading, sharing, or transmitting pornographic material.</li>
                                <li>Interfering with the operation of Snapshot Hub or its security measures.</li>
                            </ul>
                            </li>
                        </ol>
                    </p>

                    <h1>Privacy</h1>
                    <p class="">
                        Your privacy is important to us. Please review our Privacy Policy to understand how we collect, use, and protect your personal information.
                    </p>
                    <h1>Disclaimer of Warranties</h1>
                    <p class="">
                        Snapshot Hub provides its services "as is" and "as available" without any warranties of any kind, whether express or implied. We do not warrant that our services will be uninterrupted, error-free, or free from viruses or other harmful components.
                    </p>
                    <h1>Limitation of Liability</h1>
                    <p class="">
                        To the maximum extent permitted by law, Snapshot Hub shall not be liable for any direct, indirect, incidental, special, or consequential damages resulting from your use of our services, even if we have been advised of the possibility of such damages.
                    </p>
                    <h1>Indenification</h1>
                    <p class="">
                        You agree to indemnify, defend, and hold harmless Snapshot Hub and its affiliates, officers, directors, employees, and agents from any claims, liabilities, damages, losses, and expenses arising from your use of our services or your violation of these Terms and Conditions.
                    </p>
                    <h1>Modifications</h1>
                    <p class="">
                        Snapshot Hub reserves the right to modify these Terms and Conditions at any time. We will notify you of any changes by posting the new terms on our website. Your continued use of our services after any such changes constitutes your acceptance of the new terms.
                    </p>
                    <h1>Governing Law</h1>
                    <p class="">
                        These Terms and Conditions are governed by and construed in accordance with the laws of Australia, without regard to its conflict of law principles. Any disputes arising under or in connection with these terms shall be subject to the exclusive jurisdiction of the courts located in Brisbane City.
                    </p>
                    <h1>Contact Us</h1>
                    <p class="">
                        If you have any questions or concerns about these Terms and Conditions, please contact us at: <br> Email: support@snapshothub.com
                    </p>
                    <p class="">
                        By using Snapshot Hub, you acknowledge that you have read, understood, and agree to be bound by these Terms and Conditions.
                    </p>
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
                                .text()); // Output the text content of each matched element
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
</body>

</html>
