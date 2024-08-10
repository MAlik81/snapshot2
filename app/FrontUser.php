<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrontUser extends Model
{
    use HasFactory;  
    protected $table = 'front_users';
    protected $guarded = ['id'];
}
