<?php

namespace App\Http\Controllers\Admin\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceFeeMeta;
use DB;

class ServiceFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->service) && Service::where('id', $request->service)->exists()){

            $service = Service::with('fees')->where('id', $request->service)->first();

            return view('admin.services.service-fee.index', compact('service'));
        }else{
            return abort(404);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(isset($request->service) && Service::where('id', $request->service)->exists()){

            $service = Service::where('id', $request->service)->first();

            return view('admin.services.service-fee.create', compact('service'));
        }else{
            return abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(isset($request->service) && Service::where('id', $request->service)->exists()){

            $this->validate($request, [
                'description' => ['required'],
                'amount' => ['required', 'numeric', 'gt:0'],
            ]);

            try {
                DB::beginTransaction();

                ServiceFeeMeta::create([
                    'service_id' => $request->service,
                    'description' => $request->description,
                    'amount' => $request->amount,
                    'status' => true,
                ]);
                

                DB::commit();

                return back()->with('success','Fee added successfully');

            }catch(Exception $e) {
                DB::rollback();
                return back()->with('error','There is something error, please try after some time');
            }
        }else{
            return abort(404);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if(isset($request->service) && Service::where('id', $request->service)->exists()
        && ServiceFeeMeta::where('service_id', $request->service)->where('id', $id)->exists()){

            $service = Service::where('id', $request->service)->first();
            $fee = ServiceFeeMeta::where('id', $id)->first();

            return view('admin.services.service-fee.show', compact('service', 'fee'));
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
    public function update(Request $request, $id)
    {
        if(isset($request->service) && Service::where('id', $request->service)->exists()
        && ServiceFeeMeta::where('service_id', $request->service)->where('id', $id)->exists()){

            $service = Service::where('id', $request->service)->first();
            $fee = ServiceFeeMeta::where('id', $id)->first();

            try {
                DB::beginTransaction();

                ServiceFeeMeta::where(['service_id' => $request->service, 'id' => $id])->update([
                    'description' => $request->description,
                    'amount' => $request->amount,
                    'status' => $request->status == 'on' ? true : false,
                ]);

                Service::where('id', $request->service)->update([
                    'updated_at' => now()
                ]);
                

                DB::commit();

                return back()->with('success','Fee updated successfully');

            }catch(Exception $e) {
                DB::rollback();
                return back()->with('error','There is something error, please try after some time');
            }

            return view('admin.services.service-fee.show', compact('service', 'fee'));
        }else{
            return abort(404);
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
