<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renewal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'registration_id', 'form_id', 'type', 'renewal_year', 'expires_at',
        'licence', 'status', 'renewal', 'payment', 'query', 'token'
    ];
}
