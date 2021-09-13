<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renewal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'registration_id', 'form_id', 'type', 'renewal_year', 'expires_at',
        'licence', 'status', 'inspection', 'payment', 'query', 'token'
    ];

    public function user() {
        return $this->hasOne(User::class,'id', 'user_id');
    }

    public function hospital_pharmacy() {
        return $this->hasOne(HospitalRegistration::class,'id', 'form_id');
    }

    public function registration() {
        return $this->hasOne(Registration::class,'id', 'registration_id');
    }
}
