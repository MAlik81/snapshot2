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
                        style="font-size: 10.625vw;font-weight: 900;color: #fff;line-height: 6.25vwletter-spacing: -0.625vw;">
                        You ask?</h1>
                    <h1 class="mb-5"
                        style="font-size: 5vw;font-weight: 900;color: #000;line-height: 3.188vw;letter-spacing: -0.313vw;">We
                        answer.</h1>
                        
                    <h1>Do I need to subscribe to use Snapshot Hub</h1>
                    <p>
                        No you can register as a casual member with no monthly subscription 
                    </p>
                    <br>
                    
                    <h1>Can I watermark my images with my own branding?</h1>
                    <p>
                        If you are a subscribed member, you can watermark your images with your branding. This is offered for the Weekend User and Pro User subscriptions. If you are a casual member, you cannot use your own watermark.
                    </p>
                    <br>
                    
                    <h1>How does the embedded link work?</h1>
                    <p>
                        We offer an iframe that will integrate with your website. Simply copy the link and embed this into the back end of your site.
                    </p>
                    <br>
                    
                    <h1>Is the payment secure?</h1>
                    <p>
                        Yes, we use Stripe for our payment gateway. This is an internationally recognized platform. We do not store any card details on our site.
                    </p>
                    <br>
                    
                    <h1>Am I locked into the subscription for any time?</h1>
                    <p>
                        You can pull out of the subscription at any time. The billing cycle, however, is monthly and you will not be able to recover a partial month.
                    </p>
                    <br>
                    
                    <h1>How do I find my photos?</h1>
                    <p>
                        Click on the find photos tab and select the event you are looking for. You can take a selfie and the site will do the searching for you. Or you can search via number recognition.
                    </p>
                    <br>
                    
                    <h1>My child is in the event and he is under the child protection act. I don’t want him to appear in any gallery.</h1>
                    <p>
                        Simply send your photographer a picture of your son and he will be able to turn on the protection feature which will remove and delete him from any gallery via use of facial recognition.
                    </p>
                    <br>
                    
                    <h1>How can I sell my photos on your site?</h1>
                    <p>
                        To sell your images on Snapshot Hub, simply select the subscription plan that suits you and fill in the details. Once you have a username and password, you are ready to upload. Create an event; it can be a wedding, party, or sports event. Name your albums and upload.
                    </p>
                    <br>
                    
                    <h1>What type of photos can I sell?</h1>
                    <p>
                        The only limitations to the images you can sell is the size of the image. 4Mb is the largest size the site will allow you to upload. Apart from that, we do not allow any offensive material.
                    </p>
                    <br>
                    
                    <h1>How do I set the prices for my photos?</h1>
                    <p>
                        There are 2 categories for your photo sales. You can sell both high-definition and low social media res images. You select the price and the size of the low res images. This is done when you set up your event. Just follow the steps.
                    </p>
                    <br>
                    
                    <h1>What is the percentage of the sales does Snapshot Hub take and how do I pay that?</h1>
                    <p>
                        We have three levels of commission depending on what subscription you select. It ranges from 7%-15% commission. If you photograph a lot of events, then select the pro subscription and only pay 7%. If you only want to use the site for one event, select the Casual subscription and you will only pay 15%. The commission is calculated in your account and automatically deducted. So what you see is what you get.
                    </p>
                    <br>
                    
                    <h1>How do I get paid for the photos I sell?</h1>
                    <p>
                        We use Stripe for our payment gateway. Once your image sales have slowed down, simply request the payment and we will transfer it straight to your designated bank account.
                    </p>
                    <br>
                    
                    <h1>Do I retain the right to my photos after selling them on Snapshot Hub?</h1>
                    <p>
                        Absolutely. We are passionate about you advertising and owning your images. We may use some of your images for advertising your event through our socials but apart from that, you shot them, you own them. We simply provide the platform for you to get enumerated for your hard work without the huge expense of setting up an e-commerce site.
                    </p>
                    <br>
                    
                    <h1>Can customers purchase prints or digital downloads of my photos?</h1>
                    <p>
                        At this stage of the platform, we only sell digital downloads of your images.
                    </p>
                    <br>
                    
                    <h1>I cannot find the answer to my question</h1>
                    <p>
                        Ah shoot… Not enough FAQ? Then contact us at support@snapshothub.au. We will gladly answer your questions.
                    </p>
                    <br>
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
