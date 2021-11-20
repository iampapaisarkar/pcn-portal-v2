<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'registration_year', 'type', 'category', 'token', 'status', 'banner_status', 'query', 'payment', 'inspection_report', 'location_approval', 'recommendation_status'
    ];

    public function user() {
        return $this->hasOne(User::class,'id', 'user_id');
    }

    public function hospital_pharmacy() {
        return $this->hasOne(HospitalRegistration::class,'registration_id', 'id');
    }

    public function ppmv() {
        return $this->hasOne(PpmvLocationApplication::class,'registration_id', 'id');
    }

    public function other_registration() {
        return $this->hasOne(OtherRegistration::class,'registration_id', 'id');
    }
}
