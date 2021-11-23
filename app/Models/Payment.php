<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id', 'order_id', 'reference_id', 'application_id', 'service_id', 'extra_service_id', 'service_type', 'amount', 'service_charge',
        'total_amount', 'status', 'token'
    ];

    public function user() {
        return $this->hasOne(User::class,'id', 'vendor_id');
    }

    public function service() {
        return $this->hasOne(ChildService::class,'id', 'service_id');
    }

    public function application() {
        return $this->hasOne(Registration::class,'id', 'application_id');
    }

    public function renewal() {
        return $this->hasOne(Renewal::class,'id', 'application_id');
    }
}
