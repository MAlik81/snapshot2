<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventalbums extends Model
{
    use HasFactory;
    protected $table = 'event_albums';
    protected $guarded = ['id'];
    protected $fillable = [
        'business_id', 'event_id', 'name', 'status'
    ];

}
