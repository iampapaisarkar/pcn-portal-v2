<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpmvLocationApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'registration_id', 
        'birth_certificate', 
        'educational_certificate', 
        'income_tax', 
        'handwritten_certificate', 
        'reference_1_name', 
        'reference_1_phone', 
        'reference_1_email', 
        'reference_1_address', 
        'reference_1_letter', 
        'current_annual_licence',
        'reference_2_name', 
        'reference_2_phone', 
        'reference_2_email', 
        'reference_2_address',
        'reference_2_letter', 
        'reference_occupation',
    ];
}
