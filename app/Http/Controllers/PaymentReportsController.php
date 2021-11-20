<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentReportsController extends Controller
{
    public function report(){
        return view('generate-payment-report');
    }
}
