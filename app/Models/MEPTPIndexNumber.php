<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MEPTPIndexNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'arbitrary_1', 'arbitrary_2', 'batch_year', 'state_code', 'school_code', 'tier'
    ];
}
