
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
            background-image: url('{{ asset('images/front/contacbg.jpeg') }}');
            background-size:cover;
            background-repeat:no-repeat;
            background-position:right;
            height: 100vh;
        }

       
        .carousel-caption>h1 {
            font-weight: bold !important;
            font-size: 70px !important;
            /* background-color: rgba(0, 0, 0, 0.5) */
        }

        .bg-custom-button {
            background-color: #D89623;
            color: #fff;
            padding: 10px 30px;
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
    
</style>
</head>

<body style="font-family: 'Outfit';" style="">


    <!-- Sections -->
    <section class="mt-5" >
        <div class="container">
            <div class="row">
                <div class="col-md-3 mt-5" >
                </div>
                <div class="col-md-6 mt-5 p-5 bg-white" style="border-radius:20px;">
                    {{-- <h1 class="mt-5" style="font-size: 10.625vw;font-weight: 900;color: #fff;line-height: 60px;letter-spacing: -10px;">Welcome Back</h1> --}}
                    <h1 class="text-center" style="font-size: 40px;color: #000;line-height: 40px;">Are you signing up to buy photos?</h1>
                    <p class="text-center mt-3 mb-0"><a href="{{ action([\App\Http\Controllers\FrontEndController::class, 'signupFront']) }}" style="font-size: 20px;font-weight:700;color:#FFC064;"><u>SIGN UP HERE</u></a></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3" >
                </div>
                <div class="col-md-6 mt-2 p-5 bg-white" style="border-radius:20px;">
                    {{-- <h1 class="mt-5" style="font-size: 10.625vw;font-weight: 900;color: #fff;line-height: 60px;letter-spacing: -10px;">Welcome Back</h1> --}}
                    <h1 class="text-center" style="font-size: 40px;color: #000;line-height: 40px;">Are you signing up as an Event Manager, to share and sell your photos?</h1>
                    <p class="text-center mt-3 mb-0"><a href="{{ action([Modules\Superadmin\Http\Controllers\PricingController::class, 'index']) }}" style="font-size: 20px;font-weight:700;color:#FFC064;"><u>SIGN UP HERE</u></a></p>
                </div>
            </div>

        </div>
    </section>


    <!-- Bootstrap and Font Awesome JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.js"
        integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @if (session('status'))
        @if (session('status.success'))
            <script>
                toastr.success('{{ session('status.msg') }}');
            </script>
        @else
            <script>
                toastr.error('{{ session('status.msg') }}');
            </script>
        @endif
    @endif
</body>

</html>
