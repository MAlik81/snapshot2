<div class="pos-tab-content">
    <div class="row">
        @component('components.widget', [
            'class' => 'box-primary',
            'title' => 'Promote Your Event',
        ])
                <div class="alert alert-success" role="alert">
                    <strong>Link for iframe: </strong>{{ route('event-photos', ['event_id' => $event->id, 'album_id' => 0]) }}
                </div>
                <div class="alert alert-info" role="alert">
                    <strong>iframe Embed code: </strong>
                    <code>
                        &lt;iframe src="{{ route('event-photos', ['event_id' => $event->id, 'album_id' => 0]) }}" frameborder="0"&gt; &lt/iframe&gt;
                    </code>
                </div>
                <iframe src="{{ route('event-photos', ['event_id' => $event->id, 'album_id' => 0]) }}" frameborder="0"
                style="
                    width:130%;
                    height:1000px;
                transform: scale(0.7); 
                transform-origin: 0 0;   
                "    
                ></iframe>

        @endcomponent

    </div>
</div>