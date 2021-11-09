<?php

namespace App\Http\Controllers\Admin\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChildService;
use App\Models\Service;

class ChildServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if(isset($request->service) && $request->service){
            $services = ChildService::where('service_id', $request->service)->get();
            $single_service = Service::where('id', $request->service)->first();

            $breads = [
                [
                    'page' => 'Services',
                    'route' => route('services.index')
                ],
                [
                    'page' => $single_service->description . ' Services',
                    'route' => route('child-services.index') . '?service='.$single_service->id
                ]
            ];
            if($services){
                return view('admin.services.child-service', compact('services', 'breads'));
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
