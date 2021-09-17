<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id', 'user_id', 'bed_capacity', 'passport', 'pharmacist_name', 'pharmacist_email',
        'pharmacist_phone', 'qualification_year', 'registration_no', 'last_year_licence_no', 'residential_address'
    ];

    public function user() {
        return $this->hasOne(User::class,'id', 'user_id');
    }

    public function passport_doc() {
        return storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
        DIRECTORY_SEPARATOR . $this->user_id . DIRECTORY_SEPARATOR . 'hospital_pharmacy' . DIRECTORY_SEPARATOR . $this->passport);
    }

}
