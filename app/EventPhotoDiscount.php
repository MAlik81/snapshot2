<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventPhotoDiscount extends Model
{
    
    use HasFactory;
    protected $table = 'event_photo_discount';
    protected $guarded = ['id'];
    
}

