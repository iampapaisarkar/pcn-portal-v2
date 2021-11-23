<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use DB;

class Reports
{
    public static function storeApplicationReport($id, $application_type, $activity, $status, $state_id, $approved_by = null){

        try {
            DB::beginTransaction();

            if(Report::where(['application_id' => $id, 'type' => 'application', 'application_type' => $application_type])->exists()){
                Report::where(['application_id' => $id, 'type' => 'application', 'application_type' => $application_type])
                ->update([
                    'activity' => $activity,
                    'status' => $status,
                    'approved_by' => $approved_by
                ]);
            }else{
                Report::create([
                    'type' => 'application',
                    'application_id' => $id,
                    'application_type' => $application_type,
                    'activity' => $activity,
                    'status' => $status,
                    'state_id' => $state_id,
                    'approved_by' => $approved_by
                ]);
            }

            DB::commit();

            return true;

        }catch(Exception $e) {
            DB::rollback();
            return false;
        }  
    }

    public static function storePaymentReport($id, $application_type, $activity, $status, $state_id){

        try {
            DB::beginTransaction();

            Report::create([
                'type' => 'payment',
                'application_id' => $id,
                'application_type' => $application_type,
                'activity' => $activity,
                'status' => $status,
                'state_id' => $state_id
            ]);

            if(Report::where(['application_id' => $id, 'type' => 'payment', 'application_type' => $application_type])->exists()){
                Report::where(['application_id' => $id, 'type' => 'payment', 'application_type' => $application_type])
                ->update([
                    'activity' => $activity,
                    'status' => $status,
                    'approved_by' => $approved_by
                ]);
            }else{
                Report::create([
                    'type' => 'payment',
                    'application_id' => $id,
                    'application_type' => $application_type,
                    'activity' => $activity,
                    'status' => $status,
                    'state_id' => $state_id,
                    'approved_by' => $approved_by
                ]);
            }

            DB::commit();

            return true;

        }catch(Exception $e) {
            DB::rollback();
            return false;
        }  
    }

}