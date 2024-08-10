<div class="modal fade" id="front_signupModal" tabindex="-1" role="dialog" aria-labelledby="front_signupModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-top:15%;">
        <div class="modal-content"
            style="border-radius: 20px;box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);">
            {{-- <div class="modal-header">
                <h5 class="modal-title" id="front_signupModalLabel">front_signup</h5>
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
                <form class="bg-white p-4"
                   
                    id="contactForm"
                    action="{{ action([\App\Http\Controllers\FrontEndController::class, 'postSignUp']) }}"
                    method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" name="full_name" id="full_name"
                            aria-describedby="full_name" placeholder="FULL NAME " required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="EMAIL " required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password"
                            aria-describedby="password" placeholder="CREATE PASSWORD " required pattern=".{8,}">
                        <p class='text-muted'>Password must be at least 8 characters long</p>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password_confirmation"
                            id="password_confirmation" aria-describedby="password_confirmation"
                            placeholder="CONFIRM PASSWORD " required>
                    </div>
                    <button type="submit" style="border-radius: 12px;" class="btn bg-custom-button"><strong>SIGN
                            UP</strong></button>
                    <p class="pull-right mt-2">ALREADY REGISTERED <a
                        data-toggle="modal" data-target="#loginModal"   data-dismiss="modal"><u>LOGIN</u></a>
                    </p>
                    

                </form>
            </div>
        </div>

    </div>
</div>
