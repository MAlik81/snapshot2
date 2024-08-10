<div class="pos-tab-content">
    <div class="row">
        <div class="col-md-4 col-xs-12">
            <div class="form-group">
                {!! Form::label('facebook_link', 'Facebook Link :') !!}
                {!! Form::text('facebook_link', !empty($default_values['facebook_link']) ? $default_values['facebook_link'] : '', [
                    'class' => 'form-control',
                    'placeholder' => 'facebook_link',
                ]) !!}
            </div>
        </div>
        <div class="col-md-4 col-xs-12">
            <div class="form-group">
                {!! Form::label('instagram_link', 'Instagram Link:') !!}
                {!! Form::text('instagram_link', !empty($default_values['instagram_link']) ? $default_values['instagram_link'] : '', [
                    'class' => 'form-control',
                    'placeholder' => 'Instagram Link',
                ]) !!}
            </div>
        </div>
        <div class="col-md-4 col-xs-12">
            <div class="form-group">
                {!! Form::label('twitter_link', 'Twitter Link:') !!}
                {!! Form::text('twitter_link', !empty($default_values['twitter_link']) ? $default_values['twitter_link'] : '', [
                    'class' => 'form-control',
                    'placeholder' => 'twitter Link',
                ]) !!}
            </div>
        </div>
        <div class="col-md-4 col-xs-12">
            <div class="form-group">
                {!! Form::label('youtube_link', 'Youtube Link:') !!}
                {!! Form::text('youtube_link', !empty($default_values['youtube_link']) ? $default_values['youtube_link'] : '', [
                    'class' => 'form-control',
                    'placeholder' => 'Youtube Link',
                ]) !!}
            </div>
        </div>
    </div>
</div>
