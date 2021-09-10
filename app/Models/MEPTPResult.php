<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MEPTPResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id', 'vendor_id', 'status', 'score', 'percentage'
    ];

    public function user() {
        return $this->hasOne(User::class,'id', 'vendor_id');
    }
}
