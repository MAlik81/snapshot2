<?php

// app/Models/Event.php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'business_id','name', 'location', 'country', 'start_date', 'end_date', 'timezone', 'event_type', 'photo_option', 'per_photo_price', 'low_quality_per_photo_price', 'low_quality','event_cover','bucket_name','collection_id','status'
    ];

    protected $dates = ['deleted_at'];

}
