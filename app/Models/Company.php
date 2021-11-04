<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'address', 'state', 'lga', 'category', 'sub_category'
    ];


    public function company_state() {
        return $this->hasOne(State::class,'id', 'state');
    }

    public function company_lga() {
        return $this->hasOne(Lga::class,'id', 'lga');
    }

    public function business() {
        return $this->hasOne(Business::class,'company_id', 'id');
    }

    public function director() {
        return $this->hasMany(Director::class,'company_id', 'id');
    }

    public function other_director() {
        return $this->hasMany(OtherDirector::class,'company_id', 'id');
    }
}
