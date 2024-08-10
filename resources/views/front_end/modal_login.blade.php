<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-top:20%;">
        <div class="modal-content"
            style="border-radius: 20px;box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);">
            {{-- <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="close  stop-camera" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> --}}
            <style>
                .bg-custom-button {
                    background-color: #D89623;
                    color: #fff;
                    padding: 10px 30px;
                }
            </style>
            <div class="modal-body">
                <button type="button" class="close  stop-camera" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <form class="bg-white p-4" id="contactForm"
                    action="{{ action([\App\Http\Controllers\FrontEndController::class, 'postLogin']) }}"
                    method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="EMAIL ">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password"
                            aria-describedby="password" placeholder="PASSWORD ">
                    </div>
                    <button type="submit" style="border-radius: 12px;"
                        class="btn bg-custom-button"><strong>LOGIN</strong></button>
                    <a data-toggle="modal" data-target="#forgotModal"   data-dismiss="modal" class="pull-right mt-2"><u>FORGOT YOUR PASSWORD?</u></a>
                    <hr style="background-color: rgba(255, 255, 255,0.5)">

                    <p class="pull-right">DON'T HAVE AN ACCOUNT? <a  data-toggle="modal" data-target="#front_signupModal" data-dismiss="modal" ><u>SIGNUP</u></a>
                    </p>
                    <br>
                    <br>
                </form>
            </div>
        </div>
    </div>

</div>
