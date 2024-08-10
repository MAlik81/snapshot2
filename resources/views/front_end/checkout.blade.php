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
    
        .footer-link{
            color: #fff !important;
            text-decoration: none !important;
        }
        .footer-link:hover{
            color: #efefef !important;
        }
</style>
    <style>
        /* Style for card details inputs */
        #card-element {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        #card-errors {
            color: red;
            margin-bottom: 15px;
        }
        .navbar-toggler{
            position: absolute;
            right:5px !important;
                top:-50px;
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
                            style="width:50%">
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
        <div class="container">
            
            <div class="row" style="">

                <div  class=" mb-4 text-center col-md-12" style="background-color: #D89623;   padding: 1.5rem !important;color: #fff;padding:;border-radius:20px;">
                    <h1 style="margin-top:45px;">Checkout</h1>
                </div>
            </div>

            <div class="row bg-white p-4" style="border-radius:20px;">
                <div class="col-md-4 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Your cart</span>
                        <span class="badge badge-secondary badge-pill">{{ count($cart) }}</span>
                    </h4>
                    <ul class="list-group mb-3">
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($cart as $key => $cart_item)
                            @php
                                $total += $cart_item['price'];
                            @endphp
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <img class="card-img-top" src="https://s3.{{env('AWS_DEFAULT_REGION')}}.amazonaws.com/{{env('AWS_BUCKET')}}/{{ $cart_item['image'] }}"
                                        style="max-width: 50px;height:auto;" alt="Card image cap">
                                    <small class="text-muted"><?= ($cart_item['business_name'])?$cart_item['business_name']:'' ?></small>
                                </div>
                                <span class="text-muted">${{ $cart_item['price'] }}</span>
                            </li>
                        @endforeach

                        <li class="list-group-item d-flex justify-content-between">
                            <span>Images Price (AUD)</span>
                            <strong>${{ $total }}</strong>
                        </li>
                        @if (session()->get('discounted_price', 0))
                            
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Discounted Price (AUD)</span>
                            
                            <strong>${{ (session()->get('discounted_price', $total))? session()->get('discounted_price', $total) : $total }}</strong>
                        </li>
                            
                        @endif
                        @if (env('STRIPE_TRANSACTION_CHARGES'))
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Stripe Transaction Charges ({{env('STRIPE_TRANSACTION_CHARGES')}}%)</span>
                                <strong>${{ ((((session()->get('discounted_price', $total))? session()->get('discounted_price', $total) : $total)*env('STRIPE_TRANSACTION_CHARGES'))/100)}}</strong>
                                {{-- <strong>${{ ((session()->get('discounted_price', $total))? session()->get('discounted_price', $total) : $total) }} * {{ env('STRIPE_TRANSACTION_CHARGES')}} / {{100}}</strong> --}}
                            </li>
                        @endif 
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total Price (AUD)</span>
                            <strong>${{ ((((session()->get('discounted_price', $total))? session()->get('discounted_price', $total) : $total)*env('STRIPE_TRANSACTION_CHARGES'))/100)+((session()->get('discounted_price', $total))? session()->get('discounted_price', $total) : $total) }}</strong>
                        </li>
                        
                    </ul>
                    

                </div>
                <div class="col-md-8 order-md-1">
                    <h4 class="mb-3">Checkout</h4>
                    @php
                        $code = 'aud';
                    @endphp

                    <div class="col-md-12">
                        {!! Form::open([
                            'url' => action([\App\Http\Controllers\FrontEndController::class, 'processPayment']),
                            'method' => 'post',
                            'id' => 'payment-form',
                            'enctype' => 'multipart/form-data', // Add this line for multipart/form-data encoding
                        ]) !!}
                        {{ csrf_field() }}
                        <input type="hidden" name="gateway" value="stripe">
                        {{-- <input type="hidden" name="has_discount" value="0">
                        <input type="hidden" name="discount_type" value="">
                        <input type="hidden" name="discount" value="0">
                        <input type="hidden" name="net_amount" value="{{ $total }}"> --}}
                        <input type="hidden" name="price" value="{{ ((((session()->get('discounted_price', $total))? session()->get('discounted_price', $total) : $total)*env('STRIPE_TRANSACTION_CHARGES'))/100)+((session()->get('discounted_price', $total))? session()->get('discounted_price', $total) : $total) }}">
                        <input type="hidden" name="coupon_code" value="{{ request()->get('code') ?? null }}">
                        <div class="form-group">
                            <label for="user_name">Full Name</label>
                            <input type="text" class="form-control" name="name" id="user_name" value="<?= session()->get('front_user.name', null) ?>" aria-describedby="username"
                                placeholder="Full Name">
                            <small id="username" class="form-text text-muted">Your First Name and Last Name</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp" value="<?= session()->get('front_user.email', null) ?>" name="email" placeholder="Enter email">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with
                                anyone else.</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Your Card Details</label>
                            
                                <div id="card-element">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>
                            <small id="emailHelp" class="form-text text-muted">Secured transaction with strip.</small>

                        <div id="card-errors" role="alert" class="form-text text-muted"></div>
                        </div>
                        <!-- Card Element for Stripe.js -->

                        <!-- Used to display form errors. -->
                       

                        <button type="submit" class="btn btn-success btn-block">Pay Now</button>
                        {{-- <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="{{ env('STRIPE_PUB_KEY') }}"
                                data-amount="@if (in_array($code, ['bif', 'clp', 'djf', 'gnf', 'jpy', 'kmf', 'krw', 'mga', 'pyg', 'rwf', 'ugx', 'vnd', 'vuv', 'xaf', 'xof', 'xpf'])) {{ $total }} @else {{ $total * 100 }} @endif"
                                data-name="{{ env('APP_NAME') }}" data-description="{{ env('APP_NAME') }}"
                                data-image="https://stripe.com/img/documentation/checkout/marketplace.png" data-locale="auto"
                                data-currency="{{ $code }}"></script> --}}

                        {!! Form::close() !!}
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
    <footer class="bg-custom-footer">
        <div class="container ">
            <div class="row">
                <div class="col-md-12 mt-5">
                    <img src="{{ asset('images/front/logo_white.png') }}" height="" alt="Footer Logo" class="img-fluid">
                    <div style="position: absolute; top: 0; right: 20px;">
                        <a href="{{env('facebook_link')}}" target="_blank"><img src="{{ asset('images/front/facebook.png') }}" height="" alt="Footer Logo" class="img-fluid" style="color: white; font-size:15px;font-weight:bold; "></a>
                        <a href="{{env('instagram_link')}}" target="_blank"><img src="{{ asset('images/front/instagram.png') }}" height="" alt="Footer Logo" class="img-fluid" style="color: white; font-size:15px;font-weight:bold; margin-left: 20px;"></a>
                        <a href="{{env('twitter_link')}}" target="_blank"><img src="{{ asset('images/front/twitter.png') }}" height="" alt="Footer Logo" class="img-fluid" style="color: white; font-size:15px;font-weight:bold; margin-left: 20px;"></a>
                        <a href="{{env('youtube_link')}}" target="_blank"><img src="{{ asset('images/front/youtube.png') }}" height="20" alt="Footer Logo" class="img-fluid" style="color: white; font-size:15px;font-weight:bold;  margin-left: 15px;height:20px;"></a>
                    </div>
                </div>
                <div class="col-md-7  mt-3">
                    <div class="row" style="font-size:small;color:#fff !important;">
                        <div class="col-md-2">
                            <a class="footer-link" href="{{ action([\App\Http\Controllers\FrontEndController::class, 'aboutUs']) }}">About Us</a><br>
                            <a class="footer-link"  href="{{ action([\App\Http\Controllers\FrontEndController::class, 'frontContactUs']) }}">Contact Us</a>
                        </div>
                        <div class="col-md-2">
                            <a class="footer-link"  href="{{ action([\App\Http\Controllers\FrontEndController::class, 'findPhotos']) }}">Find Photos</a><br>
                            <a class="footer-link"  href="{{ action([\App\Http\Controllers\FrontEndController::class, 'buySubscription']) }}">Photographers</a>
                        </div>
                        <div class="col-md-3">
                            <a class="footer-link"  href="{{ action([\App\Http\Controllers\FrontEndController::class, 'termsAndConditions']) }}">Terms & Conditions</a> <br>
                            <a class="footer-link"  href="{{ action([\App\Http\Controllers\FrontEndController::class, 'PrivacyPolicy']) }}">Privacy Policy</a>
                        </div>
                        <div class="col-md-4 mb-5">
                            <a class="footer-link"  href="{{ action([\App\Http\Controllers\FrontEndController::class, 'FAQforPhotographers']) }}">FAQ for Photographers</a>
                        </div>
                    </div>

                </div>
            </div>
            <hr style="background-color: rgba(255, 255, 255,0.5)">
            <p style="font-size: 12px;">Proudly created by MRM <img src="{{ asset('images/front/mrm.png') }}" height="" alt="Footer Logo" class="img-fluid" style="margin-top:-3px;"> <a class="footer-link" target="_blank"   rel="nofollow noopener" href="https://www.myrobotmonkey.com.au">Website Design | Graphic Design | SEO | Marketing | App Development</a> </p>

            <br>
            <br>
        </div>
    </footer>

    <!-- Bootstrap and Font Awesome JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.js"
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
    <!-- Include Stripe.js library -->
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        var stripe = Stripe('{{ env('STRIPE_PUB_KEY') }}');
        var elements = stripe.elements();

        // Create an instance of the card Element.
        var card = elements.create('card');

        // Add an instance of the card Element into the `card-element` div.
        card.mount('#card-element');

        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server.
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form.
            form.submit();
        }
    </script>
</body>

</html>
