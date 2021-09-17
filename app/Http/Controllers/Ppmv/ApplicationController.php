<?php

namespace App\Http\Controllers\Ppmv;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function applicationForm(){
        return view('ppmv.location-application');
    }
}
