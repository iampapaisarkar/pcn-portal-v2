<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Rules\CurrentPasswordCheckRule;
use Storage;
use DB;

class ProfileController extends Controller
{
    public function index(){
        return view('profile');
    }

    public function update(Request $request){
        try {
            DB::beginTransaction();

            if(Auth::user()->hasRole(['hospital_pharmacy'])){

                $this->validate($request, [
                    'hospital_name' => [
                        'required', 'min:3', 'max:255'
                    ],
                    'hospital_address' => [
                        'required', 'min:3', 'max:255'
                    ],
                    'state' => [
                        'required'
                    ],
                    'lga' => [
                        'required'
                    ],
                ]);

                $authUser = Auth::user();

                // Check Image Validation 
                if(request()->file('photo')){
                    $validator = Validator::make($request->all(), [
                        'photo' => 'required|mimes:jpg,png,jpeg'
                    ]);
                    if ($validator->fails()) {
                        return back()->with('error','Supported files is  JPG or PNG or JPEG');
                    }

                    $file = request()->file('photo');
                    $file_name = $file->getClientOriginalName();
                    $file->move('images', $file_name);
                }

                if(isset($file_name) && auth()->user()->photo == $file_name){
                    $fileName = auth()->user()->photo;
                }else if(isset($file_name) && auth()->user()->photo != $file_name){
                    $destinationPath = 'images/';
                    File::delete($destinationPath.auth()->user()->photo);
                    $fileName = $file_name;
                }else if(!isset($file_name) && auth()->user()->photo){
                    $fileName = auth()->user()->photo;
                }else{
                    $fileName = null;
                }

                auth()->user()->update([
                    'hospital_name' => $request->hospital_name,
                    'hospital_address' => $request->hospital_address,
                    'state' => $request->state,
                    'lga' => $request->lga,
                    'photo' => $fileName
                ]);

            }

            if(Auth::user()->hasRole(['ppmv'])){

                $this->validate($request, [
                    'state' => [
                        'required'
                    ],
                    'lga' => [
                        'required'
                    ],
                    'gender' => [
                        'required'
                    ],
                    'address' => [
                        'required'
                    ],
                    'dob' => [
                        'required'
                    ],
                    'shop_name' => [
                        'required'
                    ],
                    'shop_email' => [
                        'required'
                    ],
                    'shop_phone' => [
                        'required'
                    ],
                    'shop_address' => [
                        'required'
                    ],
                    'shop_city' => [
                        'required'
                    ]
                ]);

                $authUser = Auth::user();

                // Check Image Validation 
                if(request()->file('photo')){
                    $validator = Validator::make($request->all(), [
                        'photo' => 'required|mimes:jpg,png,jpeg'
                    ]);
                    if ($validator->fails()) {
                        return back()->with('error','Supported files is  JPG or PNG or JPEG');
                    }

                    $file = request()->file('photo');
                    $file_name = $file->getClientOriginalName();
                    $file->move('images', $file_name);
                }

                if(isset($file_name) && auth()->user()->photo == $file_name){
                    $fileName = auth()->user()->photo;
                }else if(isset($file_name) && auth()->user()->photo != $file_name){
                    $destinationPath = 'images/';
                    File::delete($destinationPath.auth()->user()->photo);
                    $fileName = $file_name;
                }else if(!isset($file_name) && auth()->user()->photo){
                    $fileName = auth()->user()->photo;
                }else{
                    $fileName = null;
                }

                auth()->user()->update([
                    'state' => $request->state,
                    'lga' => $request->lga,
                    'gender' => $request->gender,
                    'address' => $request->address,
                    'dob' => $request->dob,
                    'shop_name' => $request->shop_name,
                    'shop_email' => $request->shop_email,
                    'shop_phone' => $request->shop_phone,
                    'shop_address' => $request->shop_address,
                    'shop_city' => $request->shop_city,
                    'photo' => $fileName
                ]);

            }

            if(Auth::user()->hasRole(['community_pharmacy', 'distribution_premises', 'manufacturing_premises'])){

                $this->validate($request, [
                    'firstname' => [
                        'required', 'min:3', 'max:255'
                    ],
                    'lastname' => [
                        'required', 'min:3', 'max:255'
                    ],
                    'email' => [
                        'required'
                    ],
                    'phone' => [
                        'required'
                    ],
                ]);

                $authUser = Auth::user();

                // Check Image Validation 
                if(request()->file('photo')){
                    $validator = Validator::make($request->all(), [
                        'photo' => 'required|mimes:jpg,png,jpeg'
                    ]);
                    if ($validator->fails()) {
                        return back()->with('error','Supported files is  JPG or PNG or JPEG');
                    }

                    $file = request()->file('photo');
                    $file_name = $file->getClientOriginalName();
                    $file->move('images', $file_name);
                }

                if(isset($file_name) && auth()->user()->photo == $file_name){
                    $fileName = auth()->user()->photo;
                }else if(isset($file_name) && auth()->user()->photo != $file_name){
                    $destinationPath = 'images/';
                    File::delete($destinationPath.auth()->user()->photo);
                    $fileName = $file_name;
                }else if(!isset($file_name) && auth()->user()->photo){
                    $fileName = auth()->user()->photo;
                }else{
                    $fileName = null;
                }

                auth()->user()->update([
                    'firstname' => $request->hospital_name,
                    'lastname' => $request->hospital_address,
                    'email' => $request->state,
                    'phone' => $request->lga,
                    'photo' => $fileName
                ]);

            }

            DB::commit();

            if(Auth::user()->hasRole(['hospital_pharmacy', 'community_pharmacy', 'distribution_premises', 'manufacturing_premises', 'ppmv'])){
                return redirect()->route('dashboard')->with('success','Profile updated successfully');
            }else{
                return back()->with('success','Profile updated successfully');
            }

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  

    }

    // public function removeProfilePhoto(){

    //     $fileName = auth()->user()->photo;
    //     $destinationPath = 'images/';
    //     File::delete($destinationPath.auth()->user()->photo);

    //     auth()->user()->update([
    //         'photo' => null
    //     ]);

    //     return back()->with('success','Profile photo removed successfully');
    // }

    public function updatePassword(Request $request){

        $authUser = Auth::user();

        $user = User::find(auth()->user()->id);

        $this->validate($request, [
            'old_password' => ['required', new CurrentPasswordCheckRule],
            'password' => ['confirmed','min:8','required_with:confirmed_password', 'different:old_password'],
        ]);

        if(!Hash::check($request->old_password, Auth::user()->password)){
            return back()->with('error','Can not set old password as a new password');
        }

        auth()->user()->update([
            'password' => Hash::make($request->get('password')),
        ]);


        return back()->with('success','Password updated successfully');
    }

    public function activeAccount(Request $request){

        if(User::where(['email' => $request->e, 'activation_token' => $request->t])->exists()){
            $user = User::where(['email' => $request->e, 'activation_token' => $request->t])->first();
            return view('active-account', compact($user));
        }else{
            return abort(404);
        }
    }

    public function activisionAccount(Request $request){

        try {
            DB::beginTransaction();

            if(User::where(['email' => $request->email, 'activation_token' => $request->token])->exists()){
                $this->validate($request, [
                    'password' => ['required', 'string', 'min:8', 'confirmed']
                ]);

                $user = User::where(['email' => $request->email, 'activation_token' => $request->token])->update([
                    'activation_token' => null,
                    'password' => Hash::make($request->password)
                ]);

                Auth::logout();
                Auth::loginUsingId(User::where(['email' => $request->email])->first()->id);

                $reponse = true;
            }else{
                $reponse = false;
            }

            DB::commit();
                if($reponse == true){
                    return redirect()->route('dashboard')->with('success','Congratulations Account successfully activated');
                }else{
                    return back()->with('error','There is something error, please try after some time');
                }
        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }
}
