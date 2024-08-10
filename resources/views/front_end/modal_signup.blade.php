<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-top:10%;width:50%">
        <div class="modal-content" style="border-radius: 20px; background:none;border:none;">
            {{-- <div class="modal-header">
                <h5 class="modal-title" id="signupModalLabel">signup</h5>
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
                
                <button style="padding:10px;" type="button" class="close  stop-camera" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="p-5 bg-white" style="border-radius:20px; width:100%">
                    {{-- <h1 class="mt-5" style="font-size: 170px;font-weight: 900;color: #fff;line-height: 60px;letter-spacing: -10px;">Welcome Back</h1> --}}
                    <h1 class="text-center" style="font-size: 32px;color: #000;line-height: 40px;">Are you signing up to
                        buy photos?</h1>
                    <p class="text-center mt-3 mb-0">
                        {{-- <a href="{{ action([\App\Http\Controllers\FrontEndController::class, 'signupFront']) }}"
                            style="font-size: 20px;font-weight:700;color:#FFC064;">
                            <u>SIGN UP HERE</u>
                        </a> --}}
                        <a type="button"  style="font-size: 20px;font-weight:700;color:#FFC064;" data-toggle="modal" data-target="#front_signupModal" data-dismiss="modal" >
                                <u>SIGN UP HERE</u>
                            </a>
                    </p>
                </div>
                <div class=" mt-2 p-5 bg-white" style="border-radius:20px; width:100%"">
                    {{-- <h1 class="mt-5" style="font-size: 170px;font-weight: 900;color: #fff;line-height: 60px;letter-spacing: -10px;">Welcome Back</h1> --}}
                    <h1 class="text-center" style="font-size: 32px;color: #000;line-height: 40px;">Are you signing up as
                        an Event Manager, to share and sell your photos?</h1>
                    <p class="text-center mt-3 mb-0"><a
                            href="{{ action([\App\Http\Controllers\BusinessController::class, 'getRegister']) }}"
                            style="font-size: 20px;font-weight:700;color:#FFC064;"><u>SIGN UP HERE</u></a></p>
                </div>
            </div>

        </div>
    </div>
</div>
