<div class="pos-tab-content ">
    <div class="row">
        <div class="col-md-12">
            @component('components.widget', [
                'class' => 'box-primary col-md-6',
                'title' => 'Freelancer Photographers ',
            ])
               
                {!! Form::open([
                    'url' => action([\App\Http\Controllers\EventManagementController::class, 'addCollaborator']),
                    'method' => 'post',
                    'id' => 'add_collaborator_form',
                ]) !!}
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <input type="hidden" name="user_type" value="free_lancer">
                <input type="hidden" name="user_permissions[]" value="upload_images">
                <input type="hidden" name="user_permissions[]" value="delete_images">
                
                <!-- Discount Type -->
                <div class="form-group col-md-6">
                    {!! Form::label('collaborator_id', 'Photographer') !!}
                    {!! Form::select('collaborator_id', $all_collaborators, null, ['class' => 'form-control','placeholder'=>"Select exiting user"]) !!}
                    <p class="help-block">Remember to invite your colleagues first</p>

                </div>

                <div class="form-group  col-md-6">
                    {!! Form::label('free_lancer', '.') !!}
                    <button type="submit" class="btn btn-primary  btn-block form-control">ADD</button>
                </div>




                {!! Form::close() !!}
                @endcomponent
            </div>
                <div class="col-md-12">
                @component('components.widget', [
                    'class' => 'box-primary col-md-6',
                    'title' => 'Freelancer Photograhpers',
                ])
                <div class="card">

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($event_free_lancers as $key => $free_lancer)
                                    <tr>
                                        <td>{{ $free_lancer->user_id }}</td>
                                        <td>{{ $free_lancer->surname }} {{ $free_lancer->first_name }} {{ $free_lancer->last_name }}</td>
                                        <td>
                                            <a href="{{ action([\App\Http\Controllers\EventManagementController::class, 'removeCollaborator'], ['event_id' => $event->id, 'user_id' => $free_lancer->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Remove</a>
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
