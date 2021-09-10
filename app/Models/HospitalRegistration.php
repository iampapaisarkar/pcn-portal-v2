<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'registration_year', 'bed_capacity', 'passport', 'pharmacist_name', 'pharmacist_email',
        'pharmacist_phone', 'qualification_year', 'registration_no', 'last_year_licence_no', 'residential_address',
        'status', 'query', 'payment'
    ];

    public function user() {
        return $this->hasOne(User::class,'id', 'user_id');
    }
}
