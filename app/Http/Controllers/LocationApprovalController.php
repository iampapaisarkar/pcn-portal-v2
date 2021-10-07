<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationApprovalController extends Controller
{
    public function locationForm(){
        return view('location-approval-form');
    }
}
