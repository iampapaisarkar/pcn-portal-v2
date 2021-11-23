<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'application_id', 'application_type', 'activity', 'status', 'state_id', 'approved_by'
    ];

    public function application() {
        return $this->hasOne(Registration::class,'id', 'application_id');
    }

    public function renewal() {
        return $this->hasOne(Renewal::class,'id', 'application_id');
    }

    public function payment() {
        return $this->hasOne(Payment::class,'id', 'application_id');
    }

    public function state() {
        return $this->hasOne(State::class,'id', 'state_id');
    }

    public function approvedBy() {
        return $this->hasOne(User::class,'id', 'approved_by');
    }
}
