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
                        style="font-size: 10.625vw;font-weight: 900;color: #fff;line-height: 6.25vwletter-spacing: -0.625vw;">
                        Privacy</h1>
                    <h1 class="mb-5"
                        style="font-size: 5vw;font-weight: 900;color: #000;line-height: 3.188vw;letter-spacing: -0.313vw;">Policy.</h1>
                    <h1>Introduction</h1>
                    <p>
                        Welcome to SnapShot Hub. Your privacy is important to us. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website www.snapshothub.au use our services, or participate in events hosted on our platform. By accessing or using our services, you agree to this Privacy Policy.
                       
                    </p>

                    <h1>Information We Collect</h1>
                    <h4>Personal Information</h4>
                    <p>
                        We may collect personal information that you provide to us directly, such as:
                        <ul>
                            <li>Name</li>
                            <li>Email address</li>
                            <li>Phone Number</li>
                            <li>Payment information</li>
                            <li>Billing Information</li>
                            <li>Profile information (e.g., profile Photo, bio)</li>
                        </ul>
                    </p>
                    <h4>Non-Personal Information</h4>
                    <p>
                        We may also collect non-personal information, including but not limited to:
                        <ul>
                            <li>Browser Type</li>
                            <li>Operating system</li>
                            <li>IP address</li>
                            <li>Device Information</li>
                            <li>Pages you visit on our platform</li>
                            <li>Links you click on our platform</li>
                            <li>Event participation</li>
                        </ul>
                    </p>
                    <h4>Cookies and Tracking Technologies</h4>
                    <p>
                        We use cookies and similar tracking technologies to track the activity on our platform and hold certain information. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent.
                    </p>

                    <h1>How We Use Your Information</h1>
                    <p>
                        We use the information we collect in the following ways:
                        <ul>
                            <li>To provide and maintain our services</li>
                            <li>To process transactions and send related information, such as purchase confirmations and invoices</li>
                            <li>To manage your account and provide customer support</li>
                            <li>To communicate with you about updates, offers, and promotional materials</li>
                            <li>To personalize your experience on our platform</li>
                            <li>To improve our platform and services</li>
                            <li>To detect, prevent, and address technical issues and security breaches</li>
                            <li>To fulfill any other purpose for which you provide it</li>
                        </ul>
                    </p>
                    <h1>Sharing Your Information</h1>
                    <p>
                        We may share your information in the following circumstances:
                        <ul>
                            <li>With service providers who perform services on our behalf, such as payment processing, data analysis, email delivery, hosting services, and customer service</li>
                            <li>With event organizers to facilitate event management and participation</li>
                            <li>With third parties for marketing and advertising purposes, with your consent where required by law</li>
                            <li>In connection with a merger, sale, or other transfer of some or all of our business assets</li>
                            <li>To comply with legal obligations, enforce our terms and conditions, or protect our rights</li>
                            <li>With your consent or at your direction</li>
                        </ul>
                    </p>
                    <h1>Security of Your Information</h1>
                    <p>
                        We use administrative, technical, and physical security measures to help protect your personal information. While we strive to use commercially acceptable means to protect your personal information, we cannot guarantee its absolute security
                    </p>

                    <h1>Your Choices</h1>
                    <h4>Account Information</h4>
                    <p>
                        You may update or correct your account information at any time by logging into your account settings. You can also contact us to request deletion of your account. Please note that we may retain certain information as required by law or for legitimate business purposes.
                    
                    </p>
                    <h4>Marketing Communications</h4>
                    <p>
                        You can opt-out of receiving promotional emails from us by following the unsubscribe instructions included in those emails or by contacting us directly. Even after you opt-out, you may still receive non-promotional communications, such as those regarding your account or ongoing business relations.
                        <br>We may also use you images to promote your business and activities that have taken place on our site. This is a part of the subscription you select.
                    </p>
                    <h4>Cookies</h4>
                    <p>
                        Most web browsers are set to accept cookies by default. You can usually choose to set your browser to remove or reject cookies. If you choose to remove or reject cookies, this could affect the availability and functionality of our services.
                    </p>


                    <h1>Children's Privacy</h1>
                    <p>
                        Our services are not directed to children under the age of 13, and we do not knowingly collect personal information from children under 13. If we become aware that we have collected personal information from children under 13, we will take steps to delete such information.
                    </p>
                    <h1>Changes to This Privacy Policy</h1>
                    <p>
                        We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on our website and updating the "Effective Date" at the top. You are advised to review this Privacy Policy periodically for any changes. Your continued use of the platform after any changes to this Privacy Policy will constitute your acknowledgment of the changes and your consent to abide and be bound by the updated policy.
                    </p>
                    <h1>Contact Us</h1>
                    <p>
                        If you have any questions about this Privacy Policy, please contact us at:
                        <ul>
                            <li>
                                Email: support@snapshothub.au
                            </li>
                        </ul>
                        Effective Date: 14/6/2024
                    </p>
                    <br>
                    <hr style="border-top: 3px solid rgba(0,0,0,.4);">
                    <p>This Privacy Policy is designed to help you understand how your information is collected and used when you use our platform. We are committed to protecting your privacy and ensuring a secure experience on our platform. Thank you for choosing SnapShot Hub</p>
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
</body>

</html>
