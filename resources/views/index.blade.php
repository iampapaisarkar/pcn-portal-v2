@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Dashboard', 'route' => 'dashboard'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <!-- CARD ICON-->
        <!-- Super admin cards start -->
        @can('isAdmin')
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Professor"></i>
                        <p class="text-muted mt-2 mb-2">ADMIN USERS</p>
                        <p class="text-primary text-20 line-height-1 m-0">{{$data['admin_users']}}</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-MaleFemale"></i>
                        <p class="text-muted mt-2 mb-2">USER PROFILES</p>
                        <p class="text-primary text-20 line-height-1 m-0">{{$data['vendor_users']}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        <!-- Super admin cards end -->
        
        <!-- State office cards start  -->
        @can('isSOffice')
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <h3 class="text-muted mt-2 mb-2">Doc. Verification Pending</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['pending_document']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <h3 class="text-muted mt-2 mb-2">Doc. Verification Approved</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['approved_document']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Location Inspection Pending</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['pending_inspection']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Location Inspection Uploaded</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['report_inspection']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Facility Inspection Pending</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['pending_facility']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Facility Inspection Uploaded</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['report_facility']}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        <!-- State office cards end  -->

        <!-- Registry cards start  -->
        @can('isRegistry')
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <h3 class="text-muted mt-2 mb-2">Location Approval Inspection Pending</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['location_inspection']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <h3 class="text-muted mt-2 mb-2">Location Approval Inspection Approved</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['location_report']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Facility Inspection Pending</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['facility_inspection']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Facility Inspection Approved</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['facility_report']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Renewal Inspection Pending</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['renewal_inspection']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Renewal Inspection Uploaded</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['renewal_report']}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        <!-- Registry cards end  -->

        <!-- Pharmacy practice cards start  -->
        @can('isPPractice')
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Facility Inspection Pending</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['facility_inspection']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Facility Inspection Uploaded</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['facility_report']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Renewal Inspection Pending</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['renewal_inspection']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Renewal Inspection Uploaded</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['renewal_report']}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        <!-- Pharmacy practice cards end  -->

         <!-- Inspection Monitoring cards start  -->
         @can('isIMonitoring')
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Location Inspection Pending</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['location_inspection']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Location Inspection Uploaded</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['location_report']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Facility Inspection Pending</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['facility_inspection']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Facility Inspection Uploaded</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['facility_report']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Renewal Inspection Pending</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['renewal_inspection']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Renewal Inspection Uploaded</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['renewal_report']}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        <!-- Inspection Monitoring cards end  -->

         <!-- Registration licencing cards start  -->
         @can('isRLicencing')
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <h3 class="text-muted mt-2 mb-2">Tiered PPMV Registration Licence Pending</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['licence_pending']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <h3 class="text-muted mt-2 mb-2">Tiered PPMV Registration Licence Approved</h3>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['licence_issued']}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        <!-- Registration licencing cards end  -->

        <!-- Hospital Pharmacy cards start  -->
        @can('isHPharmacy')
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-icon mb-4">
                            <div class="card-body text-center"><i class="i-Diploma-2"></i>
                                <p class="text-muted mt-2 mb-2">REGISTRATION</p>
                                <p class="text-primary text-20 line-height-1 m-0">DOCS. REVIEW PENDING</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-icon mb-4">
                            <div class="card-body text-center"><i class="i-Diploma-2"></i>
                                <p class="text-muted mt-2 mb-2">REGISTRATION</p>
                                <p class="text-primary text-20 line-height-1 m-0">DOCS. REVIEW PENDING</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="card mb-4">
                    <div class="card-body p-0">
                        <h5 class="card-title m-0 p-3">Sales</h5>
                        <div id="echart4" style="height: 300px; -webkit-tap-highlight-color: transparent; user-select: none; position: relative;" _echarts_instance_="ec_1631296578561"><div style="position: relative; overflow: hidden; width: 310px; height: 300px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;"><canvas data-zr-dom-id="zr_0" width="310" height="300" style="position: absolute; left: 0px; top: 0px; width: 310px; height: 300px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div><div></div></div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        <!-- Hospital Pharmacy cards end  -->

         <!-- Community Pharmacy cards start  -->
         @can('isCPharmacy')
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <p class="text-muted mt-2 mb-2">LOCATION APPROVAL</p>
                        <p class="text-primary text-20 line-height-1 m-0">DOCS. REVIEW PENDING</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <p class="text-muted mt-2 mb-2">LOCATION APPROVAL</p>
                        <p class="text-primary text-20 line-height-1 m-0">DOCS. REVIEW QUERIED</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <p class="text-muted mt-2 mb-2">LOCATION APPROVAL</p>
                        <p class="text-primary text-20 line-height-1 m-0">RECOMMENDED</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <p class="text-muted mt-2 mb-2">REGISTRATION AND LICENCING</p>
                        <p class="text-primary text-20 line-height-1 m-0">PENDING</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <p class="text-muted mt-2 mb-2">REGISTRATION AND LICENCING</p>
                        <p class="text-primary text-20 line-height-1 m-0">LICENCE ISSUSED</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        <!-- Community Pharmacy cards end  -->

        <!-- Distribution Premises cards start  -->
        @can('isDpremises')
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <p class="text-muted mt-2 mb-2">LOCATION APPROVAL</p>
                        <p class="text-primary text-20 line-height-1 m-0">DOCS. REVIEW PENDING</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <p class="text-muted mt-2 mb-2">LOCATION APPROVAL</p>
                        <p class="text-primary text-20 line-height-1 m-0">DOCS. REVIEW QUERIED</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <p class="text-muted mt-2 mb-2">LOCATION APPROVAL</p>
                        <p class="text-primary text-20 line-height-1 m-0">RECOMMENDED</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <p class="text-muted mt-2 mb-2">REGISTRATION AND LICENCING</p>
                        <p class="text-primary text-20 line-height-1 m-0">PENDING</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <p class="text-muted mt-2 mb-2">REGISTRATION AND LICENCING</p>
                        <p class="text-primary text-20 line-height-1 m-0">LICENCE ISSUSED</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        <!-- Distribution Premises cards end  -->

        <!-- Manufacturing Premises cards start  -->
        @can('isMpremises')
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <p class="text-muted mt-2 mb-2">REGISTRATION APPROVAL</p>
                        <p class="text-primary text-20 line-height-1 m-0">RECOMMENDED</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <p class="text-muted mt-2 mb-2">REGISTRATION AND LICENCING</p>
                        <p class="text-primary text-20 line-height-1 m-0">PENDING</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        <!-- Manufacturing Premises cards end  -->

        <!-- PPMV cards start  -->
        @can('isPPMV')
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-icon mb-4">
                            <div class="card-body text-center"><i class="i-Map2"></i>
                                <p class="text-muted mt-2 mb-2">LOCATION APPROVAL</p>
                                <p class="text-primary text-20 line-height-1 m-0">DOCS. REVIEW PENDING</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-icon mb-4">
                            <div class="card-body text-center"><i class="i-Map2"></i>
                                <p class="text-muted mt-2 mb-2">LOCATION APPROVAL</p>
                                <p class="text-primary text-20 line-height-1 m-0">DOCS. REVIEW QUERIED</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-icon mb-4">
                            <div class="card-body text-center"><i class="i-Map2"></i>
                                <p class="text-muted mt-2 mb-2">LOCATION APPROVAL</p>
                                <p class="text-primary text-20 line-height-1 m-0">INSPECTION PENDING</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-icon mb-4">
                            <div class="card-body text-center"><i class="i-Map2"></i>
                                <p class="text-muted mt-2 mb-2">LOCATION APPROVAL</p>
                                <p class="text-primary text-20 line-height-1 m-0">NOT RECOMMENDED</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-icon mb-4">
                            <div class="card-body text-center"><i class="i-Map2"></i>
                                <p class="text-muted mt-2 mb-2">LOCATION APPROVAL</p>
                                <p class="text-primary text-20 line-height-1 m-0">RECOMMENDED</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-icon mb-4">
                            <div class="card-body text-center"><i class="i-Diploma-2"></i>
                                <p class="text-muted mt-2 mb-2">REGISTRATION AND LICENCING</p>
                                <p class="text-primary text-20 line-height-1 m-0">PENDING</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-icon mb-4">
                            <div class="card-body text-center"><i class="i-Diploma-2"></i>
                                <p class="text-muted mt-2 mb-2">REGISTRATION AND LICENCING</p>
                                <p class="text-primary text-20 line-height-1 m-0">LICENCE ISSUSED</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        <!-- PPMV cards end  -->
    </div>
</div>
@endsection