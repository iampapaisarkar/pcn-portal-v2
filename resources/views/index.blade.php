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
                        <p class="text-primary text-20 line-height-1 m-0">52</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-MaleFemale"></i>
                        <p class="text-muted mt-2 mb-2">USER PROFILES</p>
                        <p class="text-primary text-20 line-height-1 m-0">PENDING</p>
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
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <h3 class="text-muted mt-2 mb-2">Doc. Verification Approved</h3>
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Location Inspection Pending</h3>
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Location Inspection Uploaded</h3>
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Facility Inspection Pending</h3>
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Facility Inspection Uploaded</h3>
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Renewal Inspection Pending</h3>
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Renewal Inspection Uploaded</h3>
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
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
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <h3 class="text-muted mt-2 mb-2">Location Approval Inspection Approved</h3>
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Location Approval Recommendation Pending</h3>
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Location Approval Recommendation Approved</h3>
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Facility Inspection Pending</h3>
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Facility Inspection Approved</h3>
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Facility Inspection Recommendation Pending</h3>
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Facility Inspection Recommendation Approved</h3>
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Renewal Inspection Pending</h3>
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Renewal Inspection Uploaded</h3>
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
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
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Facility Inspection Uploaded/h3>
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Renewal Inspection Pending</h3>
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <h3 class="text-muted mt-2 mb-2">Renewal Inspection Uploaded</h3>
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        <!-- Pharmacy practice cards end  -->

        <!-- Registration licencing cards start  -->
        @can('isRLicencing')
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <h3 class="text-muted mt-2 mb-2">Tiered PPMV Registration Licence Pending</h3>
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <h3 class="text-muted mt-2 mb-2">Tiered PPMV Registration Licence Approved</h3>
                        <p class="text-primary text-60 line-height-1 m-0">60</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        <!-- Registration licencing cards end  -->
        
         <!-- Vendor cards start  -->
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
        <!-- Vendor cards end  -->
    </div>
</div>
@endsection