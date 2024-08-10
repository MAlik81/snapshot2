<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAlbumPhotos extends Model
{
    use HasFactory;
    protected $table = 'event_album_photos';
    protected $guarded = ['id'];

}
