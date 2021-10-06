<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\User\CompanyProfileUpdateRequest;

class CompanyProfileController extends Controller
{
    public function profile(){
        return view('company-profile');
    }

    public function profileUpdate(CompanyProfileUpdateRequest $request){
        dd($request->all());
        return view('company-profile');
    }
}
