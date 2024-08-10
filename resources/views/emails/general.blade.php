
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Snapshot HUB</title>
    <style>
      body {
        background: #dedde4;
      }

      .navbar-custom {
        background-color: #1e1832;
      }

      .bg-custom-footer {
        background-color: #d89623;
        color: #fff;
        /* height: 200px; */
      }

    </style>
  </head>

  <body style="font-family: 'Outfit'">
    <!-- Header -->
    <header class="navbar-custom" style="padding: 30px;">
          <div style="width: 30%;float: left;">
            <a href="{{ action([\App\Http\Controllers\FrontEndController::class, 'home']) }}">
              <!-- <img src="{{ asset('images/front/logo.png') }}" alt="Logo" class="img-fluid"
                            style="width:50%"> -->
              <img
                src="https://snapshot.demo.myrobotmonkey.com.au/public/images/front/logo.png"
                alt="Logo"
                class="img-fluid"
                style="max-width: 100%" />
            </a>
          </div>
          <div  style="width: 70%;float: right;">
            <h1 style="color: #fff;" >{{ $headerContent }}</h1>
          </div>
          <div style="clear: both;"></div>
    </header>

    <!-- Sections -->
    <section style="padding: 30px;">
        {!! $bodyContent !!}
        <br />
        <br />
    </section>

    <!-- Footer -->
    <footer class="bg-custom-footer">
          <div  style="padding: 30px;">
            <img
              src="https://snapshot.demo.myrobotmonkey.com.au/public/images/front/logo_white.png"
              height=""
              alt="Footer Logo"
              class="img-fluid" />
          </div>
        <!-- <hr style="background-color: rgba(255, 255, 255,0.5)">
        <p style="font-size: 12px;">Proudly created by MRM <img src="{{ asset('images/front/mrm.png') }}" height="" alt="Footer Logo" class="img-fluid" style="margin-top:-3px;"> <a class="footer-link" target="_blank"   rel="nofollow noopener" href="https://www.myrobotmonkey.com.au">Website Design | Graphic Design | SEO | Marketing | App Development</a> </p>
        <br> -->
      </div>
    </footer>

  </body>
</html>
