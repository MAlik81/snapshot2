<?php
// app\Models\OverlayImage.php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OverlayImage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'business_id',
        'event_id',
        'overlay_image_path',
        'position',
        'enabled',
    ];

    protected $dates = ['deleted_at'];

}

