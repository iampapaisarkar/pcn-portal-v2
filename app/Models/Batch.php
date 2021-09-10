<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $dates = [
        'closed_at'
    ];

    protected $fillable = [
        'batch_no', 'year', 'status', 'closed_at'
    ];

    public function meptpApplication() {
        return $this->hasMany(MEPTPApplication::class,'batch_id', 'id');
        // ->where('status', 'send_to_state_office');
    }
}
