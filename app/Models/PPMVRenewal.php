<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPMVRenewal extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id', 'meptp_application_id', 'ppmv_application_id', 'renewal_year', 'expires_at', 'licence', 'status', 'renewal', 'payment', 'query', 'token', 'inspection', 'inspection_report'
    ];

    public function user() {
        return $this->hasOne(User::class,'id', 'vendor_id');
    }

    public function ppmv_application() {
        return $this->hasOne(PPMVApplication::class,'id', 'ppmv_application_id');
    }

    public function meptp_application() {
        return $this->hasOne(MEPTPApplication::class,'id', 'meptp_application_id');
    }
}
