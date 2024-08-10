<div class="modal fade" id="forgotModal" tabindex="-1" role="dialog" aria-labelledby="forgotModalLabel" aria-hidden="true">
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
                    action="{{ action([\App\Http\Controllers\FrontEndController::class, 'postForgot']) }}"
                    method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="EMAIL " required>
                    </div>
                    <button type="submit" style="border-radius: 12px;"
                        class="btn bg-custom-button"><strong>SEND PASSWORD RESET LINK</strong></button>
                    
                    
                </form>
            </div>
        </div>
    </div>

</div>
