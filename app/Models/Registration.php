<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'registration_year', 'type', 'category', 'token', 'status', 'query', 'payment', 'inspection_report'
    ];

    public function user() {
        return $this->hasOne(User::class,'id', 'user_id');
    }

    public function hospital_pharmacy() {
        return $this->hasOne(HospitalRegistration::class,'registration_id', 'id');
    }
}
