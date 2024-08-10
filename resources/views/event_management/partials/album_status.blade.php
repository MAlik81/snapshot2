<div class="pos-tab-content active">
    <div class="row">
        @component('components.widget', [
            'class' => 'box-primary',
            'title' => 'Event Albums',
        ])
            {{-- <div class="box-tools">
                <a type="button" class="btn btn-primary pull-right"
                    href="{{ action([\App\Http\Controllers\EventalbumsController::class, 'index']) }}">
                    <i class="fa fa-plus"></i>View Albums</a>
            </div> --}}
            @can('event_albums.create')
                @if (in_array('manage_albums', $user_event_permisions))
                    <div class="box-tools">
                        <a type="button" class="btn  btn-primary  pull-right"
                            href="{{ action([\App\Http\Controllers\EventalbumsController::class, 'create']) }}">
                            <i class="fa fa-plus"></i> Add New Album</a>
                    </div>
                @endif
            @endcan
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Photos</th>
                        <th>Sales</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($albums as $key => $value)
                        <tr>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->photo_count }}</td>
                            <td>{{ round($value->amount_paid, 2) }}$</td>
                            <td>
                                @if (in_array('upload_images', $user_event_permisions))
                                    <a class="btn btn-success btn-sm" style="margin-right: 5px;"
                                        href="{{ action([\App\Http\Controllers\EventalbumsController::class, 'show'], [$value->id]) }}">
                                        <span class="info-box-number text-right" style="font-size: 12px;"><i
                                                class="fa fa-eye"></i> Upload Images</span>
                                    </a>
                                @endif

                                @if (in_array('manage_albums', $user_event_permisions))
                                    <a class="btn btn-warning btn-sm" style="margin-right: 5px;"
                                        href="{{ action([\App\Http\Controllers\EventalbumsController::class, 'edit'], [$value->id]) }}">
                                        <span class="info-box-number text-right" style="font-size: 12px;"><i
                                                class="fa fa-edit"></i> Edit Album</span>
                                    </a>
                                    <button class="btn btn-danger btn-sm delete-album" data-album-id="{{ $value->id }}">
                                        <span class="info-box-number text-right" style="font-size: 12px;"><i class="fa fa-trash"></i> Delete Album</span>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endcomponent
    </div>
</div>
