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
        .navbar-toggler {
            position: absolute;
            right: 5px !important;
            top: -50px;
        }
    
</style>
</head>

<body style="font-family: 'Outfit';" style="">


    <!-- Sections -->
    <section class="mt-5" >
        <div class="container mt-5">
            <div class="row mt-5 mb-4">
                <div class="col-md-12 mt-5" >
                    <h1 class="mt-5" style="font-size: 10.625vw;font-weight: 900;color: #fff;line-height: 60px;letter-spacing: -0.625vw;">Join Us for Free</h1>
                    <h1 class="mt-5 mb-5" style="font-size: 5vw;font-weight: 900;color: #000;line-height: 3.188vw;letter-spacing: -0.313vw;">Create Your Account</h1>
                    <form class="bg-white p-4 col-md-6" style="border-radius: 20px;box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);" id="contactForm" action="{{ action([\App\Http\Controllers\FrontEndController::class, 'postSignUp']) }}" method="POST">
                        @csrf
                        <div class="form-group">
                          <input type="text" class="form-control" name="full_name" id="full_name" aria-describedby="full_name" placeholder="FULL NAME |">
                        </div>
                        <div class="form-group">
                          <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="EMAIL |">
                        </div>
                        <div class="form-group">
                          <input type="password" class="form-control" name="password" id="password" aria-describedby="password" placeholder="CREATE PASSWORD |">
                        </div>
                        <div class="form-group">
                          <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" aria-describedby="password_confirmation" placeholder="CONFIRM PASSWORD |">
                        </div>
                        <button type="submit" style="border-radius: 12px;" class="btn bg-custom-button"><strong>SIGN UP</strong></button>
                        <p class="pull-right mt-2">ALREADY REGISTERED <a href="{{ action([\App\Http\Controllers\FrontEndController::class, 'login']) }}">LOGIN</a></p>
                        <hr style="background-color: rgba(255, 255, 255,0.5)">
                        <p class="text-center"><a href="{{ action([\App\Http\Controllers\FrontEndController::class, 'home']) }}">BACK TO HOME!</a></p>
                        
                      </form>
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
