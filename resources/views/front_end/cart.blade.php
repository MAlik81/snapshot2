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
            color: #fff !important;
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
                                        <span class='badge badge-warning lblCartCount' id="lblCartCount"
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

                <div class=" mb-4 text-center col-md-12"
                    style="background-color: #D89623;color: #fff; padding: 1.1rem !important;border-radius:20px;">
                    <h1 style="margin-top:45px;">Your Cart</h1>
                </div>
            </div>

            <div class="row bg-white p-4" style="border-radius:20px;">
                <div class="col-md-12">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Items in your cart: <b><span class="lblCartCount"> </span></b></span>
                        <span class="text-muted">Total Amount: ${{ $total }}</span>
                        @if (session()->get('discounted_price', 0))
                            <span class="text-muted">Discounted Amount:
                                ${{ session()->get('discounted_price', 0) }}</span>
                        @endif

                        @if (count(session()->get('front_user', [])))
                            @if (session()->get('cart', null))
                                <a href="{{ action([\App\Http\Controllers\FrontEndController::class, 'checkout']) }}"
                                    class="btn btn-learn-more">Checkout Now <i class="fa fa-arrow-right"></i></a>
                            @endif
                        @else
                            <a ype="button" data-toggle="modal" data-target="#loginModal"
                                class="btn btn-learn-more">Checkout Now <i class="fa fa-arrow-right"></i></a>

                        @endif

                    </h4>

                    <div class="row">

                        @if (session()->get('cart'))
                            <table class="table table-condensed table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 50%">Photo</th>
                                        <th>Price</th>
                                        <th>
                                            <a href="#" class="btn btn-sm btn-danger" style="border-radius: 20px;" onclick="clearCart()">Clear Cart</a>
                                        </th>
                                    </tr>
                                </thead>
                                @foreach ($cart as $key => $cart_item)
                                    <tr>
                                        <td>
                                            <img src="https://s3.{{ env('AWS_DEFAULT_REGION') }}.amazonaws.com/{{ env('AWS_BUCKET') }}/{{ $cart_item['image'] }}"
                                                style="height:150px;border-radius:15px;overflow:hidden; "
                                                alt="Card image cap">

                                            &nbsp;&nbsp;&nbsp;&nbsp;<span><b><u><?= ($cart_item['business_name'])?$cart_item['business_name']:'' ?></u></b></span>
                                        </td>
                                        <td style="vertical-align: middle;">${{ $cart_item['price'] }}</td>
                                        <td style="vertical-align: middle;">
                                            <a href="#" class="btn btn-danger"
                                                onclick="removeFromCart({{ $key }})"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                                <tbody></tbody>
                            </table>
                        @endif
                        @if (!session()->get('cart', null))
                            <div class="col-md-12 text-center" role="alert"
                                style="background-color: #d85323;color: #fff;padding:10px 20px;border-radius:20px;">
                                <h3>Your Cart is empty, please add images to your Cart.</h3>

                            </div>
                        @endif
                    </div>
                    {{-- @dd($cart); --}}

                    {{-- <li class="list-group-item d-flex justify-content-between">
                            <span>Total (AUD)</span>
                            <strong>$20</strong>
                        </li>
                    </ul> --}}

                    {{-- <form class="card p-2">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Promo code">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-secondary">Redeem</button>
                            </div>
                        </div>
                    </form> --}}
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
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
                        $(".lblCartCount").html(response.count);
                        $(".lblCartCount").show();
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
                        $(".lblCartCount").html(response.count);
                        $(".lblCartCount").hide();
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error("Error:", error);
                }
            });

        });

        function removeFromCart(id) {
            csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var postData = {
                photo_id: id
            };
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
                        location.reload();                    
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error("Error:", error);
                }
            });
        }
        function clearCart() {
            
            $.ajax({
                url: "{{ action([\App\Http\Controllers\FrontEndController::class, 'clearCart']) }}",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }
    </script>
</body>

</html>
