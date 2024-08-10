<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawals extends Model
{
    use HasFactory;
    protected $table = 'vendor_withdrawals';
    protected $guarded = ['id'];

}
