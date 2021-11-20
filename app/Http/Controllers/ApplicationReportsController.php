<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicationReportsController extends Controller
{
    public function report(){
        return view('generate-application-report');
    }
}
