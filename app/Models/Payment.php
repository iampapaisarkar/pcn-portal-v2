<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id', 'order_id', 'reference_id', 'application_id', 'service_id', 'service_type', 'amount', 'service_charge',
        'total_amount', 'status', 'token'
    ];

    public function user() {
        return $this->hasOne(User::class,'id', 'vendor_id');
    }

    public function service() {
        return $this->hasOne(Service::class,'id', 'service_id');
    }

    public function application() {
        $invoice = $this->hasOne(Payment::class,'id', 'id')->first();
        if($invoice->service_type == 'meptp_training'){
            return $this->hasOne(MEPTPApplication::class,'id', 'application_id');
        }
    }
}
