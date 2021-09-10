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
// Route::get('/', function () {
//     if(Auth::check()){
//         return view('index');
//     }else{
//         return view('auth.login');
//     }
// });

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
    Route::get('/download-meptp-application-document', 'App\Http\Controllers\Vendor\MEPTPApplicationController@downloadMEPTPDocument')->name('download-meptp-application-document');
    Route::get('/download-invoice/{id}', 'App\Http\Controllers\InvoiceController@downloadInvoice')->name('download-invoice');
});



// SUPER ADMIN ROUTE 
Route::group(['middleware' => ['auth','verified', 'can:isAdmin']], function () {
    Route::resource('users', 'App\Http\Controllers\Admin\UserController');
    Route::resource('vendor-profiles', 'App\Http\Controllers\Admin\VendorController');
    Route::resource('schools', 'App\Http\Controllers\Admin\SchoolController');
    Route::resource('batches', 'App\Http\Controllers\Admin\BatchController');
    Route::resource('services', 'App\Http\Controllers\Admin\Service\ServiceController');
    Route::resource('services-fee', 'App\Http\Controllers\Admin\Service\ServiceFeeController');

    Route::get('/payments', 'App\Http\Controllers\InvoiceController@index')->name('payments.index');
	Route::get('/payments/{id}', 'App\Http\Controllers\InvoiceController@show')->name('payments.show');
});

// STATE OFFICE ROUTE 
Route::group(['middleware' => ['auth','verified', 'can:isSOffice']], function () {
    // MEPTP PENDING ROUTES
	Route::get('/meptp-pending-batches', 'App\Http\Controllers\StateOffice\MEPTPPendingApplicationsController@batches')->name('meptp-pending-batches');
	Route::get('/meptp-pending-centre/{batch_id}', 'App\Http\Controllers\StateOffice\MEPTPPendingApplicationsController@centre')->name('meptp-pending-centre');
	Route::get('/meptp-pending-lists', 'App\Http\Controllers\StateOffice\MEPTPPendingApplicationsController@lists')->name('meptp-pending-lists');
	Route::get('/meptp-pending-show', 'App\Http\Controllers\StateOffice\MEPTPPendingApplicationsController@show')->name('meptp-pending-show');
	Route::get('/meptp-pending-approve', 'App\Http\Controllers\StateOffice\MEPTPPendingApplicationsController@approve')->name('meptp-pending-approve');
	Route::post('/meptp-pending-query', 'App\Http\Controllers\StateOffice\MEPTPPendingApplicationsController@query')->name('meptp-pending-query');

    // MEPTP APPROVE ROUTES
	Route::get('/meptp-approve-batches', 'App\Http\Controllers\StateOffice\MEPTPApproveApplicationsController@batches')->name('meptp-approve-batches');
	Route::get('/meptp-approve-centre/{batch_id}', 'App\Http\Controllers\StateOffice\MEPTPApproveApplicationsController@centre')->name('meptp-approve-centre');
	Route::get('/meptp-approve-lists', 'App\Http\Controllers\StateOffice\MEPTPApproveApplicationsController@lists')->name('meptp-approve-lists');
	Route::get('/meptp-approve-show', 'App\Http\Controllers\StateOffice\MEPTPApproveApplicationsController@show')->name('meptp-approve-show');

    // MEPTP TRANING APPROVED ROUTES
	Route::get('/meptp-traning-approved-batches', 'App\Http\Controllers\StateOffice\MEPTPTraningApprovedApplicationsController@batches')->name('meptp-traning-approved-batches');
	Route::get('/meptp-traning-approved-centre', 'App\Http\Controllers\StateOffice\MEPTPTraningApprovedApplicationsController@centre')->name('meptp-traning-approved-centre');
	Route::get('/meptp-traning-approved-lists', 'App\Http\Controllers\StateOffice\MEPTPTraningApprovedApplicationsController@lists')->name('meptp-traning-approved-lists');
	Route::get('/meptp-traning-approved-show/{application_id}', 'App\Http\Controllers\StateOffice\MEPTPTraningApprovedApplicationsController@show')->name('/meptp-traning-approved-show');

    // PPMV PENDING REGISTRATION ROUTES 
	Route::get('/ppmv-pending-applications', 'App\Http\Controllers\StateOffice\PPMVPendingApplicationController@applications')->name('ppmv-pending-applications');
	Route::get('/ppmv-pending-application-show/{id}', 'App\Http\Controllers\StateOffice\PPMVPendingApplicationController@show')->name('ppmv-pending-application-show');
	Route::get('/download-ppmv-application-document', 'App\Http\Controllers\StateOffice\PPMVPendingApplicationController@downloadDocument')->name('download-ppmv-application-document');
	
    Route::get('/ppmv-application-approve', 'App\Http\Controllers\StateOffice\PPMVPendingApplicationController@approve')->name('ppmv-application-approve');
    Route::post('/ppmv-application-query', 'App\Http\Controllers\StateOffice\PPMVPendingApplicationController@query')->name('ppmv-application-query');

    // PPMV INSSPECTION REGISTRATION ROUTES 
	Route::get('/ppmv-inspection-applications', 'App\Http\Controllers\StateOffice\PPMVInspectionApplicationController@applications')->name('ppmv-inspection-applications');
	Route::get('/ppmv-inspection-show/{id}', 'App\Http\Controllers\StateOffice\PPMVInspectionApplicationController@show')->name('ppmv-inspection-show');
	Route::post('/ppmv-inspection-report-submit/{id}', 'App\Http\Controllers\StateOffice\PPMVInspectionApplicationController@submitInspectionReport')->name('ppmv-inspection-report-submit');

	// PPMV INSSPECTION REPORT ROUTES 
	Route::get('/ppmv-inspection-reports', 'App\Http\Controllers\StateOffice\PPMVInspectionReportController@reports')->name('ppmv-inspection-reports');
	Route::get('/ppmv-inspection-report-show/{id}', 'App\Http\Controllers\StateOffice\PPMVInspectionReportController@show')->name('ppmv-inspection-report-show');
	Route::get('/download-ppmv-inspection-report/{id}', 'App\Http\Controllers\StateOffice\PPMVInspectionReportController@downloadReport')->name('download-ppmv-inspection-report');
});

// PHARMACY PRACTICE ROUTE 
Route::group(['middleware' => ['auth','verified', 'can:isPPractice']], function () {
    // MEPTP APPROVAL ROUTES
	Route::get('/meptp-approval-states', 'App\Http\Controllers\PharmacyPractice\MEPTPApprovalApplicationsController@states')->name('meptp-approval-states');
	Route::get('/meptp-approval-centre/{state_id}', 'App\Http\Controllers\PharmacyPractice\MEPTPApprovalApplicationsController@centre')->name('meptp-approval-centre');
	Route::get('/meptp-approval-lists', 'App\Http\Controllers\PharmacyPractice\MEPTPApprovalApplicationsController@lists')->name('meptp-approval-lists');
	Route::get('/meptp-approval-show', 'App\Http\Controllers\PharmacyPractice\MEPTPApprovalApplicationsController@show')->name('meptp-approval-show');
	Route::post('/meptp-select-tier', 'App\Http\Controllers\PharmacyPractice\MEPTPApprovalApplicationsController@selectForTier')->name('meptp-select-tier');
	Route::post('/meptp-approval-query', 'App\Http\Controllers\PharmacyPractice\MEPTPApprovalApplicationsController@query')->name('meptp-approval-query');

    // MEPTP APPROVED ROUTES
	Route::get('/meptp-approved-batches', 'App\Http\Controllers\PharmacyPractice\MEPTPApprovedApplicationsController@batches')->name('meptp-approved-batches');
	Route::get('/meptp-approved-states/{batch_id}', 'App\Http\Controllers\PharmacyPractice\MEPTPApprovedApplicationsController@states')->name('meptp-approved-states');
	Route::get('/meptp-approved-centre/{state_id}', 'App\Http\Controllers\PharmacyPractice\MEPTPApprovedApplicationsController@centre')->name('meptp-approved-centre');
	Route::get('/meptp-approved-lists', 'App\Http\Controllers\PharmacyPractice\MEPTPApprovedApplicationsController@lists')->name('meptp-approved-lists');
	Route::post('/meptp-generate-index-number', 'App\Http\Controllers\PharmacyPractice\MEPTPApprovedApplicationsController@generateIndexNumber')->name('meptp-generate-index-number');

    // MEPTP RESULTS ROUTES
	Route::get('/meptp-results-batches', 'App\Http\Controllers\PharmacyPractice\MEPTPResultsApplicationsController@batches')->name('meptp-results-batches');
	Route::get('/meptp-results-states/{batch_id}', 'App\Http\Controllers\PharmacyPractice\MEPTPResultsApplicationsController@states')->name('meptp-results-states');
	Route::get('/meptp-results-centre/{state_id}', 'App\Http\Controllers\PharmacyPractice\MEPTPResultsApplicationsController@centre')->name('meptp-results-centre');
	Route::get('/meptp-results-lists', 'App\Http\Controllers\PharmacyPractice\MEPTPResultsApplicationsController@lists')->name('meptp-results-lists');
	Route::get('/meptp-donwload-result-template', 'App\Http\Controllers\PharmacyPractice\MEPTPResultsApplicationsController@downloadResultTemplate')->name('meptp-donwload-result-template');
	Route::post('/meptp-upload-results', 'App\Http\Controllers\PharmacyPractice\MEPTPResultsApplicationsController@uploadResult')->name('meptp-upload-results');

	// PPMV REPORT ROUTES 
	Route::get('/ppmv-reports', 'App\Http\Controllers\PharmacyPractice\PPMVApplicationController@reports')->name('ppmv-reports');
	Route::get('/ppmv-report-show/{id}', 'App\Http\Controllers\PharmacyPractice\PPMVApplicationController@show')->name('ppmv-report-show');
	Route::get('/download-ppmv-report/{id}', 'App\Http\Controllers\PharmacyPractice\PPMVApplicationController@downloadReport')->name('download-ppmv-report');
});

// LICENCING & REGISTERING ROUTE 
Route::group(['middleware' => ['auth','verified', 'can:isRLicencing']], function () {
	Route::get('/ppmv-licence-pending-lists', 'App\Http\Controllers\Licencing\PPMVLicenceController@pendingLists')->name('ppmv-licence-pending-lists');
	Route::get('/ppmv-licence-pending-show/{id}', 'App\Http\Controllers\Licencing\PPMVLicenceController@pendingShow')->name('ppmv-licence-pending-show');
	Route::post('/issue-single-licence/{id}', 'App\Http\Controllers\Licencing\PPMVLicenceController@issueSingleLicence')->name('issue-single-licence');
	Route::post('/issue-licences', 'App\Http\Controllers\Licencing\PPMVLicenceController@issueLicences')->name('issue-licences');
	Route::get('/ppmv-licence-issued-lists', 'App\Http\Controllers\Licencing\PPMVLicenceController@issuedLists')->name('ppmv-licence-issued-lists');
	Route::get('/ppmv-licence-issued-show/{id}', 'App\Http\Controllers\Licencing\PPMVLicenceController@issuedShow')->name('ppmv-licence-issued-show');
});

// VENDOR ROUTES 
Route::group(['middleware' => ['auth','verified', 'can:isVendor', 'CheckProfileStatus']], function () {
    // MEPTP APPLICATION REGISTER ROUTES
	Route::get('/meptp-application', 'App\Http\Controllers\Vendor\MEPTPApplicationController@applicationForm')->name('meptp-application');
    Route::post('/meptp-application-submit', 'App\Http\Controllers\Vendor\MEPTPApplicationController@applicationSubmit')->name('meptp-application-submit');

    // MEPTP APPLICATION UPDATE ROUTES
    Route::get('/meptp-application-edit', 'App\Http\Controllers\Vendor\MEPTPApplicationController@applicationEdit')->name('meptp-application-edit');
    Route::post('/meptp-application-update/{application_id}', 'App\Http\Controllers\Vendor\MEPTPApplicationController@applicationUpdate')->name('meptp-application-update');

    // MEPTP APPLICATION STATUS & RESULT ROUTES
    Route::get('/meptp-application-status', 'App\Http\Controllers\Vendor\MEPTPApplicationController@applicationStatus')->name('meptp-application-status');
    Route::get('/meptp-examination-card-download/{application_id}', 'App\Http\Controllers\Vendor\MEPTPApplicationController@downlaodExaminationCard')->name('meptp-examination-card-download');
    Route::get('/meptp-application-result', 'App\Http\Controllers\Vendor\MEPTPApplicationController@applicationResult')->name('meptp-application-result');
    Route::get('/meptp-application-result-show', 'App\Http\Controllers\Vendor\MEPTPApplicationController@applicationResulDownload')->name('meptp-application-result-show');

    // MEPTP APPLICATION CHECKOUT ROUTE
    Route::get('/checkout-meptp/{token}', 'App\Http\Controllers\Vendor\CheckoutController@checkoutMEPTP')->name('checkout-meptp');
    Route::get('/payment-failed/{token}', 'App\Http\Controllers\Vendor\CheckoutController@paymentError')->name('payment-failed');
    Route::get('/payment-success/{token}', 'App\Http\Controllers\Vendor\CheckoutController@paymentSuccess')->name('payment-success');
	Route::get('/invoices', 'App\Http\Controllers\InvoiceController@index')->name('invoices.index');
	Route::get('/invoices/{id}', 'App\Http\Controllers\InvoiceController@show')->name('invoices.show');

    // PPMV APPLICATION ROUTES 
	Route::get('/ppmv-application', 'App\Http\Controllers\Vendor\PPMVApplicationController@applicationForm')->name('ppmv-application');
	Route::post('/ppmv-application-submit', 'App\Http\Controllers\Vendor\PPMVApplicationController@applicationSubmit')->name('ppmv-application-submit');
	
	Route::get('/ppmv-renewal', 'App\Http\Controllers\Vendor\PPMVApplicationController@renewal')->name('ppmv-renewal');

    Route::get('/renew-licence', 'App\Http\Controllers\Vendor\PPMVApplicationController@renewLicence')->name('renew-licence');
    Route::post('/renew-licence-submit', 'App\Http\Controllers\Vendor\PPMVApplicationController@submitRenewLicence')->name('renew-licence-submit');

	Route::get('/ppmv-application-edit/{id}', 'App\Http\Controllers\Vendor\PPMVApplicationController@applicationFormEdit')->name('ppmv-application-edit');
	Route::post('/ppmv-application-update/{id}', 'App\Http\Controllers\Vendor\PPMVApplicationController@applicationFormUpdate')->name('ppmv-application-update');
	Route::get('/download-inspection-report/{id}', 'App\Http\Controllers\Vendor\PPMVApplicationController@downloadReport')->name('download-inspection-report');
	
	Route::get('/download-licence/{id}', 'App\Http\Controllers\Vendor\PPMVApplicationController@downloadLicence')->name('download-licence');
});