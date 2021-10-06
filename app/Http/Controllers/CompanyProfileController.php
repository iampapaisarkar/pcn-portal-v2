<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Company;
use App\Models\Business;
use App\Models\Director;
use App\Models\OtherDirector;
use App\Http\Requests\User\CompanyProfileUpdateRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\FileUpload;
use Storage;
use DB;

class CompanyProfileController extends Controller
{
    public function profile(){
        return view('company-profile');
    }

    public function profileUpdate(CompanyProfileUpdateRequest $request){
        // dd($request->all());

        try {
            DB::beginTransaction();

            $authUser = Auth::user();


            // Check Document Validation 
            if($request->file('supporting_document') != null){
                if($authUser->company()->first() && ($authUser->company()->first()->business()->first()->supporting_document == $request->file('supporting_document')->getClientOriginalName())){
                    $supporting_document = $authUser->company()->first()->business()->first()->supporting_document;
                }else{
                    $supporting_document = FileUpload::upload($request->file('supporting_document'), $private = true, 'company', 'supporting_document');

                    if($authUser->company()->first()){
                        $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
                        DIRECTORY_SEPARATOR . $request->user_id . DIRECTORY_SEPARATOR . 'company'. DIRECTORY_SEPARATOR . $authUser->company()->first()->business()->first()->supporting_document);
                        File::Delete($path);
                    }
                }
            }else{
                $supporting_document = $authUser->company()->first() ? $authUser->company()->first()->business()->first()->supporting_document : null;
            }


            // Check Passport Validation 
            if($request->file('passport')){
                $validator = Validator::make($request->all(), [
                    'passport' => 'required|mimes:jpg,png,jpeg'
                ]);
                if ($validator->fails()) {
                    return back()->with('error','Supported files is  JPG or PNG or JPEG');
                }

                $file = $request->file('passport');
                $file_name = $file->getClientOriginalName();
                $file->move('images', $file_name);
            }
            

            if(isset($file_name) && $authUser->company()->first() && ($authUser->company()->first()->business()->first()->passport == $file_name)){
                $passport_photo = $authUser->company()->first()->business()->first()->passport;
            }else if(isset($file_name) && $authUser->company()->first() && ($authUser->company()->first()->business()->first()->passport != $file_name)){
                $destinationPath = 'images/';
                File::delete($destinationPath.$authUser->company()->first()->business()->first()->passport);
                $passport_photo = $file_name;
            }else if(!isset($file_name) && $authUser->company()->first()->business()->first()->passport){
                $passport_photo = $authUser->company()->first()->business()->first()->passport;
            }else if(isset($file_name)){
                $passport_photo = $file_name;
            }
            else{
                $passport_photo = null;
            }

            if(Company::where('user_id', $authUser->id)->exists()){
                $company = Company::where('user_id', $authUser->id)->first();

                // Update company 
                Company::where(['user_id' => $authUser->id, 'id' => $company->id])->update([
                    'name' => $request->company_name,
                    'address' => $request->copmany_address,
                    'state' => $request->state,
                    'lga' => $request->lga,
                    'category' => $request->category
                ]);

                // Update Business 
                Business::where(['company_id' => $company->id])->update([
                    'name' => $request->pharmacist_name,
                    'registration_number' => $request->pharmacist_registration_number,
                    'supporting_document' => $supporting_document,
                    'passport' => $passport_photo
                ]);

                // Director Create New 
                if(!empty($request->director)){
                    // Delete old Directors 
                    Director::where(['company_id' => $company->id])->delete();

                    foreach ($request->director as $key => $director) {
                        Director::create([
                            'company_id' => $company->id,
                            'name' => $director['director_name'],
                            'registration_number' => $director['director_registration_number'],
                            'licence_number' => $director['director_licence_number']
                        ]);
                    }
                }


                // Othre Director Create New 
                if(!empty($request->other_director)){
                    // Delete old Directors 
                    OtherDirector::where(['company_id' => $company->id])->delete();

                    foreach ($request->other_director as $key => $other_director) {
                        OtherDirector::create([
                            'company_id' => $company->id,
                            'name' => $other_director['other_director_name'],
                            'profession' => $other_director['other_director_profession'],
                        ]);
                    }
                }
                
            }else{
                // Create company 
                $company = Company::create([
                    'user_id' => $authUser->id,
                    'name' => $request->company_name,
                    'address' => $request->copmany_address,
                    'state' => $request->state,
                    'lga' => $request->lga,
                    'category' => $request->category
                ]);

                // Create Business 
                Business::create([
                    'company_id' => $company->id,
                    'name' => $request->pharmacist_name,
                    'registration_number' => $request->pharmacist_registration_number,
                    'supporting_document' => $supporting_document,
                    'passport' => $passport_photo
                ]);

                // Director Create New 
                if(!empty($request->director)){
                    foreach ($request->director as $key => $director) {
                        Director::create([
                            'company_id' => $company->id,
                            'name' => $director['director_name'],
                            'registration_number' => $director['director_registration_number'],
                            'licence_number' => $director['director_licence_number']
                        ]);
                    }
                }

                // Othre Director Create New 
                if(!empty($request->other_director)){
                    foreach ($request->other_director as $key => $other_director) {
                        OtherDirector::create([
                            'company_id' => $company->id,
                            'name' => $other_director['other_director_name'],
                            'profession' => $other_director['other_director_profession'],
                        ]);
                    }
                }
            }

            DB::commit();

                return redirect()->route('dashboard')->with('success','Company profile updated successfully');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }
    }
}
