<?php

namespace App\Http\Controllers\StateOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\HospitalRegistration;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\AllActivity;

class LocationBannerPaidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $documents = Registration::where([
        // 'registrations.payment' => true, 
        'registrations.banner_status' => 'paid',
        'registrations.banner_collected' => false
        ])
        ->with('ppmv', 'other_registration.company.business', 'other_registration.company.company_state',
        'other_registration.company.company_lga', 'user', 'user.user_state', 'user.user_lga')
        ->leftjoin('users', 'users.id', 'registrations.user_id')
        ->leftjoin('other_registrations', 'other_registrations.registration_id', 'registrations.id')
        ->leftjoin('companies', 'other_registrations.company_id', 'companies.id')
        ->where(function($q){
            $q->where('users.state', Auth::user()->state);
            $q->orWhere('companies.state', Auth::user()->state);
        })
        ->select('registrations.*');

        if($request->per_page){
            $perPage = (integer) $request->per_page;
        }else{
            $perPage = 10;
        }

        if(!empty($request->search)){
            $search = $request->search;
            $documents = $documents->where(function($q) use ($search){
                $q->where('registrations.type', 'like', '%' .$search. '%');
                $q->orWhere('registrations.category', 'like', '%' .$search. '%');
            });
        }

        $documents = $documents->latest()->paginate($perPage);

        // dd($documents);
        
        return view('stateoffice.banner-paid.index', compact('documents'));
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

    public function bannerCollect(Request $request)
    {
        Registration::where(['id' => $request->registration_id])->update([
            'banner_collected' => true,
            'banner_recipient_name' => $request->recipient_name,
            'banner_comment' => $request->comment,
        ]);

        return back()
        ->with('success', 'Location Banner Approval Collected');
    }

    
}
