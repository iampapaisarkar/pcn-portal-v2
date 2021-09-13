<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// CHECK IF AUTH LOGGED IN REDIRECT DASHBOARD 
if(Auth::check()){
	Route::get('/', 'App\Http\Controllers\HomeController@index')->name('dashboard');
}else{
	Route::get('/', function () { return view('auth.login'); });
}

// ADMIN USER'S ACTICATION ROUTE
Route::get('/active-account', 'App\Http\Controllers\ProfileController@activeAccount')->name('active-account');
Route::post('/activision-account', 'App\Http\Controllers\ProfileController@activisionAccount')->name('activision-account');

Auth::routes(['verify' => true]);


// USER'S PROFILE ROUTES 
Route::get('/profile', 'App\Http\Controllers\ProfileController@index')->name('profile')->middleware('auth', 'verified');
Route::post('/profile-update', 'App\Http\Controllers\ProfileController@update')->name('profile-update')->middleware('auth', 'verified');
Route::post('/profile-password-update', 'App\Http\Controllers\ProfileController@updatePassword')->name('profile-password-update')->middleware('auth', 'verified');
// Route::post('/remove-photo', 'App\Http\Controllers\ProfileController@removeProfilePhoto')->name('remove-profile-photo')->middleware('auth', 'verified');

// DASHBOARD ROUTE 
Route::group(['middleware' => ['auth','verified', 'CheckProfileStatus']], function () {
    Route::get('/', 'App\Http\Controllers\HomeController@index')->name('dashboard');
    Route::get('/download-invoice/{id}', 'App\Http\Controllers\InvoiceController@downloadInvoice')->name('download-invoice');

    Route::get('/invoices', 'App\Http\Controllers\InvoiceController@index')->name('invoices.index');
	Route::get('/invoices/{id}', 'App\Http\Controllers\InvoiceController@show')->name('invoices.show');

    Route::get('/payment-failed/{token}', 'App\Http\Controllers\CheckoutController@paymentError')->name('payment-failed');
    Route::get('/payment-success/{token}', 'App\Http\Controllers\CheckoutController@paymentSuccess')->name('payment-success');

    // Donwload routes
    Route::get('hospital-inspection-report-download/{id}', 'App\Http\Controllers\DownloadController@downloadHospitalInspectionReport')->name('hospital-inspection-report-download');
});


////////////////////////////  BACKEND USERS ROUTE   /////////////////////////////////
// SUPER ADMIN ROUTE 
Route::group(['middleware' => ['auth','verified', 'can:isAdmin']], function () {
    Route::resource('users', 'App\Http\Controllers\Admin\UserController');
    // Route::resource('vendor-profiles', 'App\Http\Controllers\Admin\VendorController');
    Route::resource('services', 'App\Http\Controllers\Admin\Service\ServiceController');
    Route::resource('services-fee', 'App\Http\Controllers\Admin\Service\ServiceFeeController');
    Route::get('/payments', 'App\Http\Controllers\InvoiceController@index')->name('payments.index');
	Route::get('/payments/{id}', 'App\Http\Controllers\InvoiceController@show')->name('payments.show');
});

// STATE OFFICE ROUTES 
Route::group(['middleware' => ['auth','verified', 'can:isSOffice']], function () {
    Route::resource('state-office-documents', 'App\Http\Controllers\StateOffice\DocumentReviewController');
    Route::get('state-office-documents-hospital-show', 'App\Http\Controllers\StateOffice\DocumentReviewController@hospitalPharmacyShow')->name('state-office-documents-hospital-show');
    Route::post('state-office-documents-hospital-approve', 'App\Http\Controllers\StateOffice\DocumentReviewController@hospitalPharmacyApprove')->name('state-office-documents-hospital-approve');
    Route::post('state-office-documents-hospital-reject', 'App\Http\Controllers\StateOffice\DocumentReviewController@hospitalPharmacyReject')->name('state-office-documents-hospital-reject');
});

// REFISTRY ROUTES 
Route::group(['middleware' => ['auth','verified', 'can:isRegistry']], function () {
    Route::resource('registry-documents', 'App\Http\Controllers\Registry\DocumentInspectionController');
    Route::get('registry-documents-hospital-show', 'App\Http\Controllers\Registry\DocumentInspectionController@hospitalPharmacyShow')->name('registry-documents-hospital-show');
    Route::post('registry-documents-approve-all', 'App\Http\Controllers\Registry\DocumentInspectionController@ApproveAll')->name('registry-documents-approve-all');
    Route::post('registry-documents-hospital-approve', 'App\Http\Controllers\Registry\DocumentInspectionController@hospitalPharmacyApprove')->name('registry-documents-hospital-approve');

    Route::resource('registry-recommendation', 'App\Http\Controllers\Registry\DoumentRecommendationController');
    Route::get('registry-recommendation-show', 'App\Http\Controllers\Registry\DoumentRecommendationController@hospitalPharmacyShow')->name('registry-recommendation-show');
    Route::post('registry-approve-recommendation-all', 'App\Http\Controllers\Registry\DoumentRecommendationController@ApproveAll')->name('registry-approve-recommendation-all');
    Route::post('registry-recommendation-approve', 'App\Http\Controllers\Registry\DoumentRecommendationController@hospitalPharmacyApprove')->name('registry-recommendation-approve');
});

// PHARMACY PRACTICE ROUTES 
Route::group(['middleware' => ['auth','verified', 'can:isPPractice']], function () {
    Route::resource('pharmacy-practice-documents', 'App\Http\Controllers\PharmacyPractice\DocumentInspectionController');
    Route::get('pharmacy-practice-documents-hospital-show', 'App\Http\Controllers\PharmacyPractice\DocumentInspectionController@hospitalPharmacyShow')->name('pharmacy-practice-documents-hospital-show');
    Route::post('pharmacy-practice-documents-hospital-inspection-update', 'App\Http\Controllers\PharmacyPractice\DocumentInspectionController@hospitalPharmacyInspectionupdate')->name('pharmacy-practice-documents-hospital-inspection-update');

    Route::resource('pharmacy-practice-reports', 'App\Http\Controllers\PharmacyPractice\DocumentReportController');
    Route::get('pharmacy-practice-reports-show', 'App\Http\Controllers\PharmacyPractice\DocumentReportController@hospitalPharmacyShow')->name('pharmacy-practice-reports-show');

});

// INSPECTION & MONITORING ROUTES 
Route::group(['middleware' => ['auth','verified', 'can:isIMonitoring']], function () {
  
});

// REGISTERING & LECENCING ROUTES 
Route::group(['middleware' => ['auth','verified', 'can:isRLicencing']], function () {
    Route::resource('licence-pending', 'App\Http\Controllers\Licencing\DocumentPendingLicenceController');
    Route::get('licence-pending-hospital-show', 'App\Http\Controllers\Licencing\DocumentPendingLicenceController@hospitalPharmacyShow')->name('licence-pending-hospital-show');
    Route::post('licence-pending-approve-all', 'App\Http\Controllers\Licencing\DocumentPendingLicenceController@ApproveAll')->name('licence-pending-approve-all');
    Route::post('licence-pending-hospital-approve', 'App\Http\Controllers\Licencing\DocumentPendingLicenceController@hospitalPharmacyApprove')->name('licence-pending-hospital-approve');

    Route::resource('licence-issued', 'App\Http\Controllers\Licencing\DocumentIssuedLicenceController');
    Route::get('licence-issued-hospital-show', 'App\Http\Controllers\Licencing\DocumentIssuedLicenceController@hospitalPharmacyShow')->name('licence-issued-hospital-show');
});




////////////////////////////  FRONTEND USERS ROUTE   /////////////////////////////////
// HOSPITAL PHARMACY ROUTES 
Route::group(['middleware' => ['auth','verified', 'can:isHPharmacy', 'CheckProfileStatus']], function () {
    Route::get('/hospital-registration-form', 'App\Http\Controllers\HospitalPharmacy\RegistrationController@registrationForm')->name('hospital-registration-form');
    Route::post('/hospital-registration-submit', 'App\Http\Controllers\HospitalPharmacy\RegistrationController@registrationSubmit')->name('hospital-registration-submit');
    Route::get('/hospital-registration-edit/{id}', 'App\Http\Controllers\HospitalPharmacy\RegistrationController@registrationEdit')->name('hospital-registration-edit');
    Route::post('/hospital-registration-update/{id}', 'App\Http\Controllers\HospitalPharmacy\RegistrationController@registrationUpdate')->name('hospital-registration-update');

    Route::get('/hospital-registration-status', 'App\Http\Controllers\HospitalPharmacy\RegistrationController@registrationStatus')->name('hospital-registration-status');
    
    Route::resource('hospital-renewals', 'App\Http\Controllers\HospitalPharmacy\RenewalController');
});

// COMMUNITY PHARMACY ROUTES 
Route::group(['middleware' => ['auth','verified', 'can:isCPharmacy', 'CheckProfileStatus']], function () {
  
});

// DISTRIBUTION PREMISIS ROUTES 
Route::group(['middleware' => ['auth','verified', 'can:isDPremisis', 'CheckProfileStatus']], function () {
  
});

// MANUFACTURING PREMISIS ROUTES 
Route::group(['middleware' => ['auth','verified', 'can:isMPremisis', 'CheckProfileStatus']], function () {
  
});

// PPMV ROUTES 
Route::group(['middleware' => ['auth','verified', 'can:isPPMV', 'CheckProfileStatus']], function () {
  
});