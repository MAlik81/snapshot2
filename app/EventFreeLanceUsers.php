<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventFreeLanceUsers extends Model
{
    use HasFactory;
    protected $table = 'event_free_lance_users';
    protected $guarded = ['id'];
}
