<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id', 'company_id', 'user_id', 'firstname', 'middlename', 'surname', 'email', 'phone',
        'gender', 'doq', 'residental_address', 'annual_licence_no'
    ];

    public function company() {
        return $this->hasOne(Company::class,'id', 'company_id');
    }

}
