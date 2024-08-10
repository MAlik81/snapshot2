<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrontUserPhotos extends Model
{
    use HasFactory;
    protected $table = 'user_photos';
    protected $guarded = ['id'];
}
