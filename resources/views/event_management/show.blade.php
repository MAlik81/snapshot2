@extends('layouts.app')
@section('title')

@section('content')
    <!-- Content Header (Page header) -->
    <!-- Breadcrumbs -->
    {{-- user_event_permisions
        $event_permissions = ['upload_images','delete_images','protected_images','manage_albums','manage_overlay','manage_promotions','manage_discounts','get_what_you_sell','commission_based']
    --}}
    <section class="content-header">
        <div class="row">


            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}">Home</a></li>
                    <li><a href="{{ action([\App\Http\Controllers\EventManagementController::class, 'index']) }}">Events</a>
                    </li>
                    <li class="active">{{ $event->name }}</li>
                </ol>
            </div>
            <div class="col-md-6">
                <h1>{{ $event->name }}</h1>
                <p>Event date {{ date('D m-Y', strtotime($event->start_date)) }} to
                    {{ date('D m-Y', strtotime($event->end_date)) }} • {{ $event->location }}, {{ $event->country }}</p>
            </div>
            <div class="col-md-4">
                <h1>{{ session()->get('business.name') }}</h1>
                <p>Organizer</p>
            </div>
            @if (!$event_collaborator)
                <a type="button" class="btn btn-primary pull-right" style="position: absolute;right: 15px;top: 15px;"
                    href="{{ route('invitations.create', ['event_id' => $event->id]) }}">
                    <i class="fa fa-envelope"></i> Invite Collaborator </a>
            @endif
        </div>


        <!-- overlay.blade.php -->

    </section>

    {{-- @dd(auth()->user()->can('event.manage')) --}}
    <!-- Main content -->
    @if (auth()->user()->can('event.manage'))
        <section class="content">
            {{-- {!! Form::open(['url' => action([\App\Http\Controllers\BusinessController::class, 'postBusinessSettings']), 'method' => 'post', 'id' => 'bussiness_edit_form',
           'files' => true ]) !!} --}}
            <div class="row">
                <div class="col-xs-12">
                    <!--  <em-tab-container> -->
                    <div class="col-xs-12 pos-tab-container">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pos-tab-menu">
                            <div class="list-group">
                                <a href="#" class="list-group-item text-center active">Manage Albums</a>

                                @if (auth()->user()->can('event.manage'))
                                    @if (!$event_collaborator)
                                        <a href="#" class="list-group-item text-center ">Freelance photographers</a>
                                        <a href="#" class="list-group-item text-center">Team Member photographers</a>
                                    @endif
                                    @if (in_array('manage_promotions', $user_event_permisions))
                                        <a href="#" class="list-group-item text-center">Promote your Event</a>
                                    @endif
                                    @if (in_array('manage_discounts', $user_event_permisions))
                                        <a href="#" class="list-group-item text-center">Photo discount</a>
                                    @endif
                                    @if ($own_branding)
                                        @if (in_array('manage_overlay', $user_event_permisions))
                                            <a href="#" class="list-group-item text-center">Logo Overlay</a>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 pos-tab">
                            <!-- tab 1 start -->
                            @include('event_management.partials.album_status')

                            @if (auth()->user()->can('event.manage'))
                                @if (!$event_collaborator)
                                    @include('event_management.partials.manage_photographers')
                                    @include('event_management.partials.manage_affiliate_photographers')
                                @endif
                                @if (in_array('manage_promotions', $user_event_permisions))
                                    @include('event_management.partials.external_embeding')
                                @endif
                                @if (in_array('manage_discounts', $user_event_permisions))
                                    @include('event_management.partials.photo_discount')
                                @endif
                                @if ($own_branding)
                                    @if (in_array('manage_overlay', $user_event_permisions))
                                        @include('event_management.partials.logo_overlay')
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>
                    <!--  </em-tab-container> -->
                </div>
            </div>

            {{-- {!! Form::close() !!} --}}
        </section>
    @endif
    <!-- /.content -->
@stop
@section('javascript')
    <script type="text/javascript">
        $('div.em-tab-menu>div.list-group>a').click(function(e) {
            e.preventDefault();
            $(this).siblings('a.active').removeClass('active');
            $(this).addClass('active');
            var index = $(this).index();
            $('div.em-tab>div.em-tab-content').removeClass('active');
            $('div.em-tab>div.em-tab-content').eq(index).addClass('active');
        });
    </script>
    <script>
        $(document).ready(function() {
            // Initial visibility based on discount type
            toggleDiscountFields();

            // Add change event to discount type select
            $('#discount_type').change(function() {
                toggleDiscountFields();
            });

            // Initialize datepickers
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
        });

        // Function to toggle visibility of discount fields based on discount type
        function toggleDiscountFields() {
            var discountType = $('#discount_type').val();

            // Show/hide fields based on discount type
            $('#x_photos_container').toggle(discountType === 'percentage');
            $('#percentage_discount_container').toggle(discountType === 'percentage');
            $('#total_amount_container').toggle(discountType === 'selfie_bundle');
        }
    </script>
    <script>
        $(document).ready(function() {
            // Handle changes in settings and redraw the merged image
            function redrawMergedImage() {
                $("#overlay_div").css("background-image",
                    "url('{{ $overlay ? url($overlay->overlay_image_path) : '' }}')");
                var overlayImagePath =
                    '{{ $overlay ? url($overlay->overlay_image_path) : 'https://w7.pngwing.com/pngs/626/321/png-transparent-peace-symbols-sign-peace-love-trademark-logo-thumbnail.png' }}';
                var position = $('#position').val();
                var isEnabled = $('#enabled').is(':checked');

                var canvas = document.getElementById('mergedCanvas');
                var context = canvas.getContext('2d');

                var backgroundImage = new Image();
                backgroundImage.src =
                    'https://t4.ftcdn.net/jpg/05/49/86/39/360_F_549863991_6yPKI08MG7JiZX83tMHlhDtd6XLFAMce.jpg';

                backgroundImage.onload = function() {
                    // Set canvas dimensions based on the background image
                    canvas.width = backgroundImage.width;
                    canvas.height = backgroundImage.height;

                    context.clearRect(0, 0, canvas.width, canvas.height);
                    context.drawImage(backgroundImage, 0, 0, canvas.width, canvas.height);

                    if (isEnabled) {
                        var overlayImage = new Image();
                        overlayImage.src = overlayImagePath;

                        overlayImage.onload = function() {
                            var overlayX, overlayY;
                            console.log();
                            // Adjust overlay coordinates based on the selected position
                            switch (position) {
                                case 'top_left':
                                    overlayX = 0;
                                    overlayY = 0;
                                    break;
                                case 'top_right':
                                    overlayX = canvas.width - 100;
                                    overlayY = 0;
                                    break;
                                case 'bottom_left':
                                    overlayX = 0;
                                    overlayY = canvas.height - 100;
                                    break;
                                case 'bottom_right':
                                    overlayX = canvas.width - 100;
                                    overlayY = canvas.height - 100;
                                    break;
                                case 'center':
                                    overlayX = (canvas.width - 100) / 2;
                                    overlayY = (canvas.height - 100) / 2;
                                    break;
                                default:
                                    overlayX = 0;
                                    overlayY = 0;
                            }
                            console.log(overlayX, overlayY);
                            console.log(overlayImage.width, overlayImage.height);
                            // Draw the overlay image
                            // Set global alpha for transparency
                            context.globalAlpha = 0.5;

                            // Draw the overlay image
                            context.drawImage(overlayImage, overlayX, overlayY, 100, 100);

                            // Reset global alpha to default
                            // context.globalAlpha = 1;
                        };
                    }
                };
            }

            // Attach event handlers for changes in settings
            $('#position, #enabled').change(function() {
                redrawMergedImage();
            });

            // Initial draw on page load
            redrawMergedImage();
        });



        $("#user_type").change(function(e) {
            e.preventDefault();
            if ($(this).val() == 'commission_based_member') {
                $('#available_commission').show();
                $('#available_commission_input').prop('max', $('#available_commission_value').val());
            } else {
                $('#available_commission').hide();
                $('#available_commission_input').prop('max', 100);
            }
        });
    </script>
    <script>
        function getCollaboratorData(button) {
            const url = button.getAttribute('data-href');

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    console.log('Collaborator data:', data);
                    // Populate the form fields with the collaborator data
                    $('#event_collaborator_id').val(data.collaborator.id);
                    $('#collaborator_id_dd').prop('disabled', true).prop('required', false);
                    $('#user_type').val(data.collaborator.user_type).trigger('change').prop('disabled', true);
                    $('#available_commission_input').val(data.collaborator.commission);

                    // Check the permissions checkboxes
                    data.permissions.forEach(permission => {
                        $(`input[name="user_permissions[]"][value="${permission}"]`).prop('checked', true);
                    });
                    //focus and scroll to the add_collaborator_form
                    $('html, body').animate({
                        scrollTop: $("#add_collaborator_form").offset().top
                    }, 1000);
                })
                .catch(error => {
                    console.error('Error fetching collaborator data:', error);
                });
        }

        $(document).on('click', '.delete-album', function() {
            var id = $(this).data('album-id');
            console.log(id);
            var url = "<?=url('event-albums') ?>" + '/' + id;
            var confirm_msg = 'Are you sure you want to delete this album?';

            swal({
                title: "Confirmation",
                text: confirm_msg,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            if (data.success) {
                                swal("Success", data.msg, "success");
                            } else {
                                swal("Error", data.msg, "error");
                            }
                            location.reload();
                        }
                    });
                }

            });
        });
    </script>

@endsection
