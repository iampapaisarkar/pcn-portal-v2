<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\ChildService;
use App\Models\ServiceFeeMeta;
use App\Models\Payment;
use DB;
use Mail;
use App\Mail\PaymentSuccessEmail;
use App\Mail\StateOfficeQueryEmail;
use App\Mail\PharmacyRecommendationEmail;
use App\Mail\StateRecommendationEmail;
use App\Mail\LicencingIssuedEmail;

class EmailSend
{
    public static function sendPaymentSuccessEMAIL($data){

        try {
            DB::beginTransaction();

            Mail::to($data['user']['email'])->send(new PaymentSuccessEmail($data));

            DB::commit();
            return ['success' => true];
        }catch(Exception $e) {
            DB::rollback();
            return ['success' => false];
        }  
    }

    public static function sendStateOfficeQueryEMAIL($data){

        try {
            DB::beginTransaction();

            Mail::to($data['user']['email'])->send(new StateOfficeQueryEmail($data));

            DB::commit();
            return ['success' => true];
        }catch(Exception $e) {
            DB::rollback();
            return ['success' => false];
        }  
    }

    public static function sendPharmacyRecommendationEMAIL($data){

        try {
            DB::beginTransaction();

            Mail::to($data['user']['email'])->send(new PharmacyRecommendationEmail($data));

            DB::commit();
            return ['success' => true];
        }catch(Exception $e) {
            DB::rollback();
            return ['success' => false];
        }  
    }

    public static function sendInspectionRecommendationEMAIL($data){

        try {
            DB::beginTransaction();

            Mail::to($data['user']['email'])->send(new InspectionRecommendationEmail($data));

            DB::commit();
            return ['success' => true];
        }catch(Exception $e) {
            DB::rollback();
            return ['success' => false];
        }  
    }

    public static function sendStateRecommendationEMAIL($data){

        try {
            DB::beginTransaction();

            Mail::to($data['user']['email'])->send(new StateRecommendationEmail($data));

            DB::commit();
            return ['success' => true];
        }catch(Exception $e) {
            DB::rollback();
            return ['success' => false];
        }  
    }

    public static function sendLicencingIssuedEMAIL($data){

        try {
            DB::beginTransaction();

            Mail::to($data['user']['email'])->send(new LicencingIssuedEmail($data));

            DB::commit();
            return ['success' => true];
        }catch(Exception $e) {
            DB::rollback();
            return ['success' => false];
        }  
    }

    // public static function sendMail($data){

    //     try {
    //         DB::beginTransaction();

    //         Mail::to($data['user']['email'])->send(new ApproveTierEmail($data));

    //         foreach ($data['state_officer'] as $state) {
    //             Mail::to($state['email'])->send(new ApproveTierEmail($data));
    //         }

    //         DB::commit();
    //         return ['success' => true];
    //     }catch(Exception $e) {
    //         DB::rollback();
    //         return ['success' => false];
    //     }  
    // }

}