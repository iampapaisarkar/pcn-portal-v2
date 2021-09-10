<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'description'
    ];

    public function fees() {
        return $this->hasMany(ServiceFeeMeta::class,'service_id', 'id');
    }

    public function netFees() {
        return $this->hasMany(ServiceFeeMeta::class,'service_id', 'id')
        ->where('status', true);
    }

    public function isServiceExist($id){
        return $this->where('id', $id)->exists();
    }
}
