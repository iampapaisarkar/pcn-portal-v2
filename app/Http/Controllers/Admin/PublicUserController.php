<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Role;

class PublicUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if(isset($request->role) && isset($request->code) && $request->role && $request->code){

            $users = User::select('users.*')
            ->with('role', 'user_state')
            ->join('user_roles', 'users.id', 'user_roles.user_id')
            ->join('roles', 'user_roles.role_id', 'roles.id')
            ->where('roles.code', $request->code)
            ->where('roles.id', $request->role);

            if($request->per_page){
                $perPage = (integer) $request->per_page;
            }else{
                $perPage = 2;
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


            if($users){
                return view('admin.premises.public-users', compact('users'));
            }else{
                return abort(404);
            }
        }else{
            return abort(404);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
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
