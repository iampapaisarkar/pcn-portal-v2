<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildService extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'description'
    ];

    public function ServiceMeta() {
        return $this->hasMany(ServiceFeeMeta::class,'service_id', 'id');
    }

}
