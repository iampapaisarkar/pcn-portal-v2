<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    public function profile(){
        return view('community-pharmacy.company-profile');
    }
}
