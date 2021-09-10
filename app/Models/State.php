<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function lga() {
        return $this->hasMany(Lga::class,'state_id', 'id');
    }
}
