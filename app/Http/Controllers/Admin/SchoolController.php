<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\School;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\School\SchoolStoreRequest;
use App\Http\Requests\School\SchoolUpdateRequest;
use DB;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $schools = School::with('school_state');

        if($request->per_page){
            $perPage = (integer) $request->per_page;
        }else{
            $perPage = 10;
        }

        if(!empty($request->search)){
            $search = $request->search;
            $schools = $schools->where(function($q) use ($search){
                $q->where('name', 'like', '%' .$search. '%');
                $q->orWhere('code', 'like', '%' .$search. '%');
            });
        }

        $schools = $schools->latest()->paginate($perPage);

        return view('admin.schools.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.schools.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SchoolStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            // Store school 
            School::create([
                'name' => $request->name,
                'code' => strtoupper($this->sanitize($request->code)),
                'state' => $request->state,
                'status' => $request->status == 'on' ? true : false
            ]);

            DB::commit();

            return back()->with('success','School added successfully');

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
        $school = School::with('school_state')
        ->where('id', $id)
        ->first();

        if($school){
            return view('admin.schools.show', compact('school'));
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
    public function update(SchoolUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            // Update school 
            School::where('id', $id)->update([
                'name' => $request->name,
                'code' => strtoupper($this->sanitize($request->code)),
                'state' => $request->state,
                'status' => $request->status == 'on' ? true : false
            ]);

            DB::commit();

            return back()->with('success','School updated successfully');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }

    public function sanitize($value) {
        $value = strip_tags($value);
        // Preserve escaped octets.
        $value = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $value);
        // Remove percent signs that are not part of an octet.
        $value = str_replace('%', '', $value);
        // Restore octets.
        $value = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $value);
    
        $value = strtolower($value);
        $value = preg_replace('/&.+?;/', '', $value); // kill entities
        $value = str_replace('.', '-', $value);
        $value = preg_replace('/[^%a-z0-9 _-]/', '', $value);
        $value = preg_replace('/\s+/', '-', $value);
        $value = preg_replace('|-+|', '-', $value);
        $value = trim($value, '-');
    
        return $value;
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
