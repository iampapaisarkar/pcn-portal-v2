<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;
use DB;

class AllActivity
{
    public static function storeActivity($applicationID, $adminName, $activity, $type){

        try {
            DB::beginTransaction();

            Activity::create([
                'application_id' => $applicationID,
                'admin_name' => $adminName,
                'activity' => $activity,
                'type' => $type
            ]);

            DB::commit();

            return true;

        }catch(Exception $e) {
            DB::rollback();
            return false;
        }  
    }


}