<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAffiliateUsers extends Model
{
    use HasFactory;
    protected $table = 'event_affiliate_user';
    protected $guarded = ['id'];

}
