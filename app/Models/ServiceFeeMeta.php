<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceFeeMeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id', 'description', 'amount', 'registration_fee', 'inspection_fee', 'status'
    ];
}
