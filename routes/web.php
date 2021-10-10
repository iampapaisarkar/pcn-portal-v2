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

Route::group(['middleware' => ['auth','verified', 'can:isCPharmacy, isDPremisis, isMPremisis']], function () {
    Route::get('/company-profile', 'App\Http\Controllers\CompanyProfileController@profile')->name('company-profile');
    Route::post('/company-profile-update', 'App\Http\Controllers\CompanyProfileController@profileUpdate')->name('company-profile-update');
});

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
    Route::get('ppmv-birth-certificate-download/{id}', 'App\Http\Controllers\DownloadController@downloadPPMVBirthCertificate')->name('ppmv-birth-certificate-download');
    Route::get('ppmv-education-certificate-download/{id}', 'App\Http\Controllers\DownloadController@downloadPPMVEducationCertificate')->name('ppmv-education-certificate-download');
    Route::get('ppmv-incometax-certificate-download/{id}', 'App\Http\Controllers\DownloadController@downloadPPMVIncomeTaxCertificate')->name('ppmv-incometax-certificate-download');
    Route::get('ppmv-handwritten-certificate-download/{id}', 'App\Http\Controllers\DownloadController@downloadPPMVHandwrittenCertificate')->name('ppmv-handwritten-certificate-download');
    Route::get('ppmv-reference-letter-1-download/{id}', 'App\Http\Controllers\DownloadController@downloadPPMVReferenceLetter1')->name('ppmv-reference-letter-1-download');
    Route::get('ppmv-reference-letter-2-download/{id}', 'App\Http\Controllers\DownloadController@downloadPPMVReferenceLetter2')->name('ppmv-reference-letter-2-download');
    Route::get('ppmv-location-inspection-report-download/{id}', 'App\Http\Controllers\DownloadController@downloadPPMVLocationInspectionReport')->name('ppmv-location-inspection-report-download');
    Route::get('ppmv-registration-inspection-report-download/{id}', 'App\Http\Controllers\DownloadController@downloadPPMVRegistrationInspectionReport')->name('ppmv-registration-inspection-report-download');
    Route::get('location-inspection-report-download/{id}', 'App\Http\Controllers\DownloadController@downloadPRegistrationInspectionReport')->name('location-inspection-report-download');
    
});


////////////////////////////  BACKEND USERS ROUTE   /////////////////////////////////
// SUPER ADMIN ROUTE 
Route::group(['middleware' => ['auth','verified', 'can:isAdmin']], function () {

    Route::resource('users', 'App\Http\Controllers\Admin\UserController');
    Route::resource('premises', 'App\Http\Controllers\Admin\PremisesController');
    Route::resource('public-users', 'App\Http\Controllers\Admin\PublicUserController');

    Route::resource('services', 'App\Http\Controllers\Admin\Service\ServiceController');
    Route::resource('child-services', 'App\Http\Controllers\Admin\Service\ChildServiceController');
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

    Route::get('state-office-documents-ppmv-show', 'App\Http\Controllers\StateOffice\DocumentReviewController@ppmvApprovalShow')->name('state-office-documents-ppmv-show');
    Route::post('state-office-documents-ppmv-approve', 'App\Http\Controllers\StateOffice\DocumentReviewController@ppmvApprove')->name('state-office-documents-ppmv-approve');
    Route::post('state-office-documents-ppmv-reject', 'App\Http\Controllers\StateOffice\DocumentReviewController@ppmvReject')->name('state-office-documents-ppmv-reject');

    Route::get('state-office-documents-community-show', 'App\Http\Controllers\StateOffice\DocumentReviewController@communityApprovalShow')->name('state-office-documents-community-show');
    Route::post('state-office-documents-community-approve', 'App\Http\Controllers\StateOffice\DocumentReviewController@communityApprove')->name('state-office-documents-community-approve');
    Route::post('state-office-documents-community-reject', 'App\Http\Controllers\StateOffice\DocumentReviewController@communityReject')->name('state-office-documents-community-reject');

    Route::get('state-office-documents-distribution-show', 'App\Http\Controllers\StateOffice\DocumentReviewController@distributionApprovalShow')->name('state-office-documents-distribution-show');
    Route::post('state-office-documents-distribution-approve', 'App\Http\Controllers\StateOffice\DocumentReviewController@distributionApprove')->name('state-office-documents-distribution-approve');
    Route::post('state-office-documents-distribution-reject', 'App\Http\Controllers\StateOffice\DocumentReviewController@distributionReject')->name('state-office-documents-distribution-reject');

    Route::resource('state-office-locations', 'App\Http\Controllers\StateOffice\LocationInspectionController');
    Route::get('state-office-locations-ppmv-show', 'App\Http\Controllers\StateOffice\LocationInspectionController@ppmvLocationShow')->name('state-office-locations-ppmv-show');
    Route::post('state-office-locations-ppmv-inspection-update', 'App\Http\Controllers\StateOffice\LocationInspectionController@ppmvLocationInspectionupdate')->name('state-office-locations-ppmv-inspection-update');

    Route::resource('state-office-location-reports', 'App\Http\Controllers\StateOffice\LocationReportController');
    Route::get('state-office-location-report-ppmv-show', 'App\Http\Controllers\StateOffice\LocationReportController@ppmvLocationShow')->name('state-office-location-report-ppmv-show');

    Route::resource('state-office-registration', 'App\Http\Controllers\StateOffice\FacilityApplicationController');
    Route::get('state-office-registration-ppmv-show', 'App\Http\Controllers\StateOffice\FacilityApplicationController@ppmvRegistrationShow')->name('state-office-registration-ppmv-show');
    Route::post('state-office-registration-ppmv-inspection-update', 'App\Http\Controllers\StateOffice\FacilityApplicationController@ppmvRegistrationInspectionUpdate')->name('state-office-registration-ppmv-inspection-update');

    Route::resource('state-office-registration-reports', 'App\Http\Controllers\StateOffice\FacilityReportController');
    Route::get('state-office-registration-report-ppmv-show', 'App\Http\Controllers\StateOffice\FacilityReportController@ppmvRegistrationShow')->name('state-office-registration-report-ppmv-show');
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
    
    Route::get('registry-recommendation-ppmv-show', 'App\Http\Controllers\Registry\DoumentRecommendationController@ppmvRegistrationShow')->name('registry-recommendation-ppmv-show');
    Route::post('registry-recommendation-ppmv-approve', 'App\Http\Controllers\Registry\DoumentRecommendationController@ppmvRegistrationApprove')->name('registry-recommendation-ppmv-approve');


    Route::resource('registry-renewal-pending', 'App\Http\Controllers\Registry\RenewalInspectionController');
    Route::get('registry-renewal-pending-hospital-show', 'App\Http\Controllers\Registry\RenewalInspectionController@hospitalPharmacyShow')->name('registry-renewal-pending-hospital-show');
    Route::post('registry-renewal-pending-approve-all', 'App\Http\Controllers\Registry\RenewalInspectionController@ApproveAll')->name('registry-renewal-pending-approve-all');
    Route::post('registry-renewal-pending-hospital-approve', 'App\Http\Controllers\Registry\RenewalInspectionController@hospitalPharmacyApprove')->name('registry-renewal-pending-hospital-approve');

    Route::get('registry-renewal-pending-ppmv-show', 'App\Http\Controllers\Registry\RenewalInspectionController@ppmvShow')->name('registry-renewal-pending-ppmv-show');
    Route::post('registry-renewal-pending-ppmv-approve', 'App\Http\Controllers\Registry\RenewalInspectionController@ppmvApprove')->name('registry-renewal-pending-ppmv-approve');

    Route::resource('registry-renewal-recommendation', 'App\Http\Controllers\Registry\RenewalRecommendationController');
    Route::get('registry-renewal-recommendation-show', 'App\Http\Controllers\Registry\RenewalRecommendationController@hospitalPharmacyShow')->name('registry-renewal-recommendation-show');
    Route::post('registry-renewal-recommendation-approve-all', 'App\Http\Controllers\Registry\RenewalRecommendationController@ApproveAll')->name('registry-renewal-recommendation-approve-all');
    Route::post('registry-renewal-recommendation-approve', 'App\Http\Controllers\Registry\RenewalRecommendationController@hospitalPharmacyApprove')->name('registry-renewal-recommendation-approve');
    Route::get('registry-renewal-recommendation-ppmv-show', 'App\Http\Controllers\Registry\RenewalRecommendationController@ppmvShow')->name('registry-renewal-recommendation-ppmv-show');
    Route::post('registry-renewal-recommendation-ppmv-approve', 'App\Http\Controllers\Registry\RenewalRecommendationController@ppmvApprove')->name('registry-renewal-recommendation-ppmv-approve');

    Route::resource('registry-locations', 'App\Http\Controllers\Registry\LocationApplicationController');
    Route::get('registry-location-ppmv-show', 'App\Http\Controllers\Registry\LocationApplicationController@ppmvLocationShow')->name('registry-location-ppmv-show');
    Route::post('registry-locations-approve-all', 'App\Http\Controllers\Registry\LocationApplicationController@ApproveAll')->name('registry-locations-approve-all');
    Route::post('registry-location-ppmv-approve', 'App\Http\Controllers\Registry\LocationApplicationController@ppmvLocationApprove')->name('registry-location-ppmv-approve');
    Route::get('registry-location-community-show', 'App\Http\Controllers\Registry\LocationApplicationController@communityLocationShow')->name('registry-location-community-show');
    Route::post('registry-location-community-approve', 'App\Http\Controllers\Registry\LocationApplicationController@communityLocationApprove')->name('registry-location-community-approve');
    Route::get('registry-location-distribution-show', 'App\Http\Controllers\Registry\LocationApplicationController@distributionLocationShow')->name('registry-location-distribution-show');
    Route::post('registry-location-distribution-approve', 'App\Http\Controllers\Registry\LocationApplicationController@distributionLocationApprove')->name('registry-location-distribution-approve');

    Route::resource('registry-location-recommendation', 'App\Http\Controllers\Registry\LocationApplicationRecommendation');
    Route::get('registry-location-ppmv-recommendation-show', 'App\Http\Controllers\Registry\LocationApplicationRecommendation@ppmvLocationRecommendationShow')->name('registry-location-ppmv-recommendation-show');
    Route::get('registry-location-community-recommendation-show', 'App\Http\Controllers\Registry\LocationApplicationRecommendation@communityLocationRecommendationShow')->name('registry-location-community-recommendation-show');
    Route::get('registry-location-distribution-recommendation-show', 'App\Http\Controllers\Registry\LocationApplicationRecommendation@distributionLocationRecommendationShow')->name('registry-location-distribution-recommendation-show');
    Route::post('registry-approve-location-recommendation-all', 'App\Http\Controllers\Registry\LocationApplicationRecommendation@ApproveAll')->name('registry-approve-location-recommendation-all');
    Route::post('registry-location-ppmv-recommendation-approve', 'App\Http\Controllers\Registry\LocationApplicationRecommendation@ppmvLocationRecommendationApprove')->name('registry-location-ppmv-recommendation-approve');
    Route::post('registry-location-community-recommendation-approve', 'App\Http\Controllers\Registry\LocationApplicationRecommendation@communityLocationRecommendationApprove')->name('registry-location-community-recommendation-approve');
    Route::post('registry-location-distribution-recommendation-approve', 'App\Http\Controllers\Registry\LocationApplicationRecommendation@distributionLocationRecommendationApprove')->name('registry-location-distribution-recommendation-approve');
});

// PHARMACY PRACTICE ROUTES 
Route::group(['middleware' => ['auth','verified', 'can:isPPractice']], function () {
    Route::resource('pharmacy-practice-documents', 'App\Http\Controllers\PharmacyPractice\DocumentInspectionController');
    Route::get('pharmacy-practice-documents-hospital-show', 'App\Http\Controllers\PharmacyPractice\DocumentInspectionController@hospitalPharmacyShow')->name('pharmacy-practice-documents-hospital-show');
    Route::post('pharmacy-practice-documents-hospital-inspection-update', 'App\Http\Controllers\PharmacyPractice\DocumentInspectionController@hospitalPharmacyInspectionupdate')->name('pharmacy-practice-documents-hospital-inspection-update');

    Route::resource('pharmacy-practice-reports', 'App\Http\Controllers\PharmacyPractice\DocumentReportController');
    Route::get('pharmacy-practice-reports-show', 'App\Http\Controllers\PharmacyPractice\DocumentReportController@hospitalPharmacyShow')->name('pharmacy-practice-reports-show');

    Route::resource('pharmacy-renewal-pending', 'App\Http\Controllers\PharmacyPractice\RenewalInspectionController');
    Route::get('pharmacy-renewal-pending-hospital-show', 'App\Http\Controllers\PharmacyPractice\RenewalInspectionController@hospitalPharmacyShow')->name('pharmacy-renewal-pending-hospital-show');
    Route::post('pharmacy-renewal-hospital-inspection', 'App\Http\Controllers\PharmacyPractice\RenewalInspectionController@hospitalPharmacyInspectionupdate')->name('pharmacy-renewal-hospital-inspection');

    Route::get('pharmacy-renewal-pending-ppmv-show', 'App\Http\Controllers\PharmacyPractice\RenewalInspectionController@ppmvShow')->name('pharmacy-renewal-pending-ppmv-show');
    Route::post('pharmacy-renewal-ppmv-inspection', 'App\Http\Controllers\PharmacyPractice\RenewalInspectionController@ppmvInspectionupdate')->name('pharmacy-renewal-ppmv-inspection');

    Route::resource('pharmacy-renewal-reports', 'App\Http\Controllers\PharmacyPractice\RenewalReportController');
    Route::get('pharmacy-renewal-reports-show', 'App\Http\Controllers\PharmacyPractice\RenewalReportController@hospitalPharmacyShow')->name('pharmacy-renewal-reports-show');
    Route::get('pharmacy-renewal-reports-ppmv-show', 'App\Http\Controllers\PharmacyPractice\RenewalReportController@ppmvShow')->name('pharmacy-renewal-reports-ppmv-show');
});

// INSPECTION & MONITORING ROUTES 
Route::group(['middleware' => ['auth','verified', 'can:isIMonitoring']], function () {
  
});

// REGISTERING & LECENCING ROUTES 
Route::group(['middleware' => ['auth','verified', 'can:isRLicencing']], function () {
    Route::resource('licence-pending', 'App\Http\Controllers\Licencing\DocumentPendingLicenceController');
    Route::post('licence-pending-approve-all', 'App\Http\Controllers\Licencing\DocumentPendingLicenceController@ApproveAll')->name('licence-pending-approve-all');
    Route::get('licence-pending-hospital-show', 'App\Http\Controllers\Licencing\DocumentPendingLicenceController@hospitalPharmacyShow')->name('licence-pending-hospital-show');
    Route::post('licence-pending-hospital-approve', 'App\Http\Controllers\Licencing\DocumentPendingLicenceController@hospitalPharmacyApprove')->name('licence-pending-hospital-approve');

    Route::get('licence-pending-ppmv-show', 'App\Http\Controllers\Licencing\DocumentPendingLicenceController@ppmvShow')->name('licence-pending-ppmv-show');
    Route::post('licence-pending-ppmv-approve', 'App\Http\Controllers\Licencing\DocumentPendingLicenceController@ppmvApprove')->name('licence-pending-ppmv-approve');

    Route::resource('licence-issued', 'App\Http\Controllers\Licencing\DocumentIssuedLicenceController');
    Route::get('licence-issued-hospital-show', 'App\Http\Controllers\Licencing\DocumentIssuedLicenceController@hospitalPharmacyShow')->name('licence-issued-hospital-show');
    Route::get('licence-issued-ppmv-show', 'App\Http\Controllers\Licencing\DocumentIssuedLicenceController@ppmvShow')->name('licence-issued-ppmv-show');

    Route::resource('renewal-pending', 'App\Http\Controllers\Licencing\RenewalPendingLicenceController');
    Route::get('renewal-pending-hospital-show', 'App\Http\Controllers\Licencing\RenewalPendingLicenceController@hospitalPharmacyShow')->name('renewal-pending-hospital-show');
    Route::post('renewal-pending-approve-all', 'App\Http\Controllers\Licencing\RenewalPendingLicenceController@ApproveAll')->name('renewal-pending-approve-all');
    Route::post('renewal-pending-hospital-approve', 'App\Http\Controllers\Licencing\RenewalPendingLicenceController@hospitalPharmacyApprove')->name('renewal-pending-hospital-approve');
    Route::get('renewal-pending-ppmv-show', 'App\Http\Controllers\Licencing\RenewalPendingLicenceController@ppmvShow')->name('renewal-pending-ppmv-show');
    Route::post('licence-renewal-pending-ppmv-approve', 'App\Http\Controllers\Licencing\RenewalPendingLicenceController@ppmvApprove')->name('licence-renewal-pending-ppmv-approve');

    Route::resource('renewal-issued', 'App\Http\Controllers\Licencing\RenewalIssuedLicenceController');
    Route::get('renewal-issued-hospital-show', 'App\Http\Controllers\Licencing\RenewalIssuedLicenceController@hospitalPharmacyShow')->name('renewal-issued-hospital-show');
    Route::get('renewal-issued-ppmv-show', 'App\Http\Controllers\Licencing\RenewalIssuedLicenceController@ppmvShow')->name('renewal-issued-ppmv-show');

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
    Route::get('/hospital-renew', 'App\Http\Controllers\HospitalPharmacy\RenewalController@renew')->name('hospital-renew');
    Route::post('/hospital-renewal-submit', 'App\Http\Controllers\HospitalPharmacy\RenewalController@renewalSubmit')->name('hospital-renewal-submit');
    Route::get('/hospital-renewal-edit/{id}', 'App\Http\Controllers\HospitalPharmacy\RenewalController@renewalEdit')->name('hospital-renewal-edit');
    Route::post('/hospital-renewal-update/{id}', 'App\Http\Controllers\HospitalPharmacy\RenewalController@renewalUpdate')->name('hospital-renewal-update');
});

// COMMUNITY PHARMACY ROUTES 
Route::group(['middleware' => ['auth','verified', 'can:isCPharmacy', 'CheckProfileStatus']], function () {
    // Route::get('/company-profile', 'App\Http\Controllers\CompanyProfileController@profile')->name('company-profile');
});

// DISTRIBUTION PREMISIS ROUTES 
Route::group(['middleware' => ['auth','verified', 'can:isDPremisis', 'CheckProfileStatus']], function () {
  
});

// MANUFACTURING PREMISIS ROUTES 
Route::group(['middleware' => ['auth','verified', 'can:isMPremisis', 'CheckProfileStatus']], function () {
  
});

// COMMUNITY PHARMACY ROUTES // DISTRIBUTION PREMISIS ROUTES
Route::group(['middleware' => ['auth','verified', 'can:isCPharmacy, isDPremisis', 'CheckProfileStatus']], function () {
    Route::get('/location-approval-form', 'App\Http\Controllers\LocationApprovalController@locationForm')->name('location-approval-form');
    Route::post('/location-approval-form-submit', 'App\Http\Controllers\LocationApprovalController@locationFormSubmit')->name('location-approval-form-submit');
    Route::get('/location-approval-form-edit/{id}', 'App\Http\Controllers\LocationApprovalController@locationFormEdit')->name('location-approval-form-edit');
    Route::post('/location-approval-form-update/{id}', 'App\Http\Controllers\LocationApprovalController@locationFormUpdate')->name('location-approval-form-update');
    Route::get('/location-approval-status', 'App\Http\Controllers\LocationApprovalController@locationStatus')->name('location-approval-status');

    Route::get('/facility-registration-form', 'App\Http\Controllers\FacilityRegistrationController@facilityForm')->name('facility-registration-form');
    Route::post('/facility-registration-form-submit/{id}', 'App\Http\Controllers\FacilityRegistrationController@facilityFormSubmit')->name('facility-registration-form-submit');
    Route::get('/facility-registration-form-edit/{id}', 'App\Http\Controllers\FacilityRegistrationController@facilityFormEdit')->name('facility-registration-form-edit');
    Route::post('/facility-registration-form-update/{id}', 'App\Http\Controllers\FacilityRegistrationController@facilityFormUpdate')->name('facility-registration-form-update');
    Route::get('/facility-registration-status', 'App\Http\Controllers\FacilityRegistrationController@facilityStatus')->name('facility-registration-status');
});

// PPMV ROUTES 
Route::group(['middleware' => ['auth','verified', 'can:isPPMV', 'CheckProfileStatus']], function () {
    Route::get('/ppmv-application-form', 'App\Http\Controllers\Ppmv\ApplicationController@applicationForm')->name('ppmv-application-form');
    Route::post('/ppmv-application-form-submit', 'App\Http\Controllers\Ppmv\ApplicationController@applicationFormSubmit')->name('ppmv-application-form-submit');
    Route::get('/ppmv-application-edit/{id}', 'App\Http\Controllers\Ppmv\ApplicationController@applicationEdit')->name('ppmv-application-edit');
    Route::post('/ppmv-application-update/{id}', 'App\Http\Controllers\Ppmv\ApplicationController@applicationUpdate')->name('ppmv-application-update');
    
    Route::get('/ppmv-application-status', 'App\Http\Controllers\Ppmv\ApplicationController@status')->name('ppmv-application-status');

    Route::get('/ppmv-facility-application-form', 'App\Http\Controllers\Ppmv\FacilityApplicationController@applicationForm')->name('ppmv-facility-application-form');
    Route::post('/ppmv-facility-application-form-submit', 'App\Http\Controllers\Ppmv\FacilityApplicationController@applicationFormSubmit')->name('ppmv-facility-application-form-submit');

    Route::get('/ppmv-facility-application-status', 'App\Http\Controllers\Ppmv\FacilityApplicationController@status')->name('ppmv-facility-application-status');

    Route::resource('ppmv-renewals', 'App\Http\Controllers\Ppmv\RenewalController');
    Route::get('/ppmv-renew', 'App\Http\Controllers\Ppmv\RenewalController@renew')->name('ppmv-renew');
    Route::post('/ppmv-renewal-submit', 'App\Http\Controllers\Ppmv\RenewalController@renewalSubmit')->name('ppmv-renewal-submit');
    Route::get('/ppmv-renewal-edit/{id}', 'App\Http\Controllers\Ppmv\RenewalController@renewalEdit')->name('ppmv-renewal-edit');
    Route::post('/ppmv-renewal-update/{id}', 'App\Http\Controllers\Ppmv\RenewalController@renewalUpdate')->name('ppmv-renewal-update');
});