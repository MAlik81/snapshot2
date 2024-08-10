<div class="pos-tab-content">
    <div class="row">
        <div class="col-md-12">
            @component('components.widget', [
                'class' => 'box-primary col-md-6',
                'title' => 'Team Member Photographers',
            ])
                {!! Form::open([
                    'url' => action([\App\Http\Controllers\EventManagementController::class, 'addCollaborator']),
                    'method' => 'post',
                    'id' => 'add_collaborator_form',
                ]) !!}
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <input type="hidden" name="event_collaborator_id" id="event_collaborator_id" value="">
                <!-- Discount Type -->
                <div class="row">
                    <div class="form-group col-md-6">
                        {!! Form::label('collaborator_id', 'Photographer') !!}
                        {!! Form::select('collaborator_id', $all_collaborators, null, [
                            'class' => 'form-control',
                            'placeholder' => 'Select exiting user',
                            'id' => 'collaborator_id_dd',
                        ]) !!}
                        <p class="help-block">Remember to invite your colleagues first</p>

                    </div>

                    <div class="form-group col-md-6">
                        {!! Form::label('user_type', 'Role') !!}
                        {!! Form::select(
                            'user_type',
                            ['get_what_you_sell_member' => 'Sales-Based Team Member', 'commission_based_member' => 'Commissioned Team Member'],
                            null,
                            ['class' => 'form-control', 'placeholder' => 'Select Role', 'required'],
                        ) !!}
                        <p class="help-block">Please select the role carefully as it is not editable. To change the role, you
                            must first delete the photographer from the current role before assigning a new role. This will
                            result in the loss of all data related to the user's previous role.</p>

                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        {!! Form::label('commission', 'Commission (%)') !!}
                        {!! Form::number('commission', null, [
                            'class' => 'form-control',
                            'placeholder' => 'Commission',
                            'id' => 'available_commission_input',
                            'MAX' => 100,
                        ]) !!}
                        <p class="help-block" id="available_commission" style="display: none;">Remaining commission of this
                            event that you can allocate is {{ $remaining_commission }}%</p>
                        <input type="hidden" id="available_commission_value" value="{{ $remaining_commission }}">
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('collaborator_id', 'Choose Permissions') !!}
                        <div style="margin-left: 10%">
                            @foreach (['upload_images' => 'Upload Images', 'delete_images' => 'Delete Images', 'protected_images' => 'Protected Images', 'manage_albums' => 'Manage Albums', 'manage_overlay' => 'Manage Overlay', 'manage_promotions' => 'Event Promotions', 'manage_discounts' => 'Manage Discounts'] as $key => $permission)
                                <label class="checkbox">
                                    {!! Form::checkbox('user_permissions[]', $key) !!} {{ $permission }}
                                </label>
                            @endforeach

                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <button class="btn btn-warning btn-block" onclick="event.preventDefault(); location.reload();">Cancel</button>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary  btn-block">Submit Data</button>
                    </div>
                </div>




                {!! Form::close() !!}
            @endcomponent
        </div>
        <div class="col-md-12">
            @component('components.widget', [
                'class' => 'box-primary col-md-6',
                'title' => 'Sale Based Team Members',
            ])
                <div class="card">

                    <div class="card-body" style="overflow: auto;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Commission %</th>
                                    <th>Profit Share</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($event_get_what_you_sell_member as $key => $user)
                                    <tr>
                                        <td>{{ $user->user_id }}</td>
                                        <td>{{ $user->surname }} {{ $user->first_name }} {{ $user->last_name }}</td>
                                        <td>{{ 100 - $user->commission }}%</td>
                                        <td>${{ $user->collaborator_profit ?? 0 }}</td>
                                        <td>
                                           
                                            <button data-href="{{ action([\App\Http\Controllers\EventManagementController::class, 'getCollaborator'], ['event_id' => $event->id, 'user_id' => $user->id]) }}"
                                                class="btn btn-warning btn-xs" onclick="getCollaboratorData(this)">Edit</button>
                                            <a href="{{ action([\App\Http\Controllers\EventManagementController::class, 'removeCollaborator'], ['event_id' => $event->id, 'user_id' => $user->id]) }}"
                                                class="btn btn-danger btn-xs"
                                                onclick="return confirm('Are you sure?')">Remove</a>
                                            {{-- <a href="{{ action([\App\Http\Controllers\EventManagementController::class, 'removeCollaborator'], ['event_id' => $event->id, 'user_id' => $user->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Remove</a> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endcomponent
        </div>
        <div class="col-md-12">
            @component('components.widget', [
                'class' => 'box-primary col-md-6',
                'title' => 'Commissioned Team Members',
            ])
                <div class="card">

                    <div class="card-body" style="overflow: auto;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Commission %</th>
                                    <th>Profit Share</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($event_commission_based_member as $key => $user)
                                    <tr>
                                        <td>{{ $user->user_id }}</td>
                                        <td>{{ $user->surname }} {{ $user->first_name }} {{ $user->last_name }}</td>
                                        <td>{{ $user->commission }}%</td>
                                        <td>${{ $user->collaborator_profit ?? 0 }}</td>
                                        <td>
                                            <button data-href="{{ action([\App\Http\Controllers\EventManagementController::class, 'getCollaborator'], ['event_id' => $event->id, 'user_id' => $user->id]) }}"
                                                class="btn btn-warning btn-xs" onclick="getCollaboratorData(this)">Edit</button>
                                            <a href="{{ action([\App\Http\Controllers\EventManagementController::class, 'removeCollaborator'], ['event_id' => $event->id, 'user_id' => $user->id]) }}"
                                                class="btn btn-danger btn-xs"
                                                onclick="return confirm('Are you sure?')">Remove</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endcomponent
        </div>
    </div>

</div>
