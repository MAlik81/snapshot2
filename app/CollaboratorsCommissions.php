<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollaboratorsCommissions extends Model
{
    use HasFactory;
    protected $table = 'collaborators_commissions';
    protected $guarded = ['id'];
}
