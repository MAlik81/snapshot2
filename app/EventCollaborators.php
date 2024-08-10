<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCollaborators extends Model
{
    use HasFactory;
    protected $table = 'event_collaborator';
    protected $guarded = ['id'];
}
