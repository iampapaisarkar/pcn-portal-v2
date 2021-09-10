<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPMVApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id', 'meptp_application_id',
        'reference_1_name', 'reference_1_phone', 'reference_1_email', 'reference_1_address', 'reference_1_letter', 'current_annual_licence',
        'reference_2_name', 'reference_2_phone', 'reference_2_email', 'reference_2_address','reference_2_letter', 'reference_occupation',
    ];

    public function user() {
        return $this->hasOne(User::class,'id', 'vendor_id');
    }

    public function meptp() {
        return $this->hasOne(MEPTPApplication::class,'id', 'meptp_application_id');
    }

    public function ppmv_renewal() {
        return $this->hasOne(PPMVRenewal::class,'ppmv_application_id', 'id');
    }
}
