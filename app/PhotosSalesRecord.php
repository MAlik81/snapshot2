<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotosSalesRecord extends Model
{
    use HasFactory;
    protected $table = 'photo_sales';
    protected $guarded = ['id'];
}
