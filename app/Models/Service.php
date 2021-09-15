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

    public function childService() {
        return $this->hasMany(ChildService::class,'service_id', 'id');
    }

    // public function isServiceExist($id){
    //     return $this->where('id', $id)->exists();
    // }
}
