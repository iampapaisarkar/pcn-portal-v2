<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use DB;
use App\Mail\InvitationEmail;
use Mail;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function index(Request $request)
    {   
        $users = User::select('users.*')
        ->with('role', 'user_state')
        ->join('user_roles', 'users.id', 'user_roles.user_id')
        ->join('roles', 'user_roles.role_id', 'roles.id')
        ->where('roles.code', '!=', 'vendor')
        ->where('users.id', '!=', Auth::user()->id);

        if($request->per_page){
            $perPage = (integer) $request->per_page;
        }else{
            $perPage = 10;
        }

        if(!empty($request->search)){
            $search = $request->search;
            $users = $users->where(function($q) use ($search){
                $q->where('users.firstname', 'like', '%' .$search. '%');
                $q->orWhere('users.lastname', 'like', '%' .$search. '%');
                $q->orWhere('users.email', 'like', '%' .$search. '%');
            });
        }

        $users = $users->latest()->paginate($perPage);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('code', '!=', 'vendor')->get();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            // Get role 
            $role = Role::where('code', $request->type)->first();

            // Get State 
            if($request->type == 'state_office'){
                $state = State::where('id', $request->state)->first();
            }

            // Store user 
            $user = User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'phone' => $request->phone,
                'state' => $request->type == 'state_office' ? $request->state : null,
                'activation_token' => Hash::make($request->email),
                'email_verified_at' => now()
            ]);

            // Store role or type 
            UserRole::create([
                'user_id' => $user->id,
                'role_id' => $role->id
            ]);

            $data = [
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'phone' => $request->phone,
                'state' => $request->type == 'state_office' ? $state->name : null,
                'role' => $role,
                'activation_url' =>env('APP_URL') . '/' . 'active-account?t=' . $user->activation_token . '&e=' . $request->email
            ];

            // Send invitation email 
            Mail::to($request->email)->send(new InvitationEmail($data));

            DB::commit();

            return back()->with('success','User added & invitation email successfully send');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('role', 'user_state')
        ->where('id', '!=', Auth::user()->id)
        ->where('id', $id)
        ->first();

        $roles = Role::where('code', '!=', 'vendor')->get();

        if($user){
            return view('admin.users.show', compact('user', 'roles'));
        }else{
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            // Get role 
            $role = Role::where('code', $request->type)->first();

            // Get State 
            if($request->type == 'state_office'){
                $state = State::where('id', $request->state)->first();
            }

            // Status 
            if($request->status == 'on'){
                $status = true;
            }else{
                $status = false;
            }

            // Store user 
            User::where('id', $id)->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'phone' => $request->phone,
                'state' => $request->type == 'state_office' ? $request->state : null,
                'activation_token' => Hash::make($request->email),
                'status' => $status
            ]);

            // Delete old role 
            UserRole::where('user_id', $id)->delete();

            // Store role or type 
            UserRole::create([
                'user_id' => $id,
                'role_id' => $role->id
            ]);

            DB::commit();

            return back()->with('success','User updated successfully');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
