<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Role;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:13'],
            'type' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        try {
            DB::beginTransaction();

            if($data['type'] == 'hospital_pharmacy'
            || $data['type'] == 'community_pharmacy'
            || $data['type'] == 'distribution_premisis'
            || $data['type'] == 'manufacturing_premisis'
            || $data['type'] == 'ppmv'){
                $role = Role::where('code', $data['type'])->first();

                $user = User::create([
                    'firstname' => $data['firstname'],
                    'lastname' => $data['lastname'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                ]);
                UserRole::create([
                    'user_id' => $user->id,
                    'role_id' => $role->id
                ]);
            }else{
                return back()->with('error','There is something error, please try after some time');
            }
                
            DB::commit();

            return $user;

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There something internal server errore');
        }  
    }
}
