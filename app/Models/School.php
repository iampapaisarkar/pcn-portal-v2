<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'state', 'status'
    ];

    public function school_state() {
        return $this->hasOne(State::class,'id', 'state');
    }

    // public function meptpApplication() {
    //     return $this->hasMany(MEPTPApplication::class,'traing_centre', 'id');
    //     // ->where('status', 'send_to_state_office');
    // }
}
