@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Dashboard', 'route' => 'dashboard'])
<div class="row">
    <div class="col-lg-6 col-md-12">
        <!-- CARD ICON-->
        <!-- Super admin cards start -->
        @can('isAdmin')
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <p class="text-muted mt-2 mb-2">METPT</p>
                        <p class="text-primary text-20 line-height-1 m-0">PASSED</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <p class="text-muted mt-2 mb-2">Tiered PPMV Registration</p>
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
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <p class="text-muted mt-2 mb-2">{{$data['meptp_pending']['type']}}</p>
                        <p class="text-muted mt-2 mb-2">{{$data['meptp_pending']['status']}}</p>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['meptp_pending']['total']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <p class="text-muted mt-2 mb-2">{{$data['meptp_approved']['type']}}</p>
                        <p class="text-muted mt-2 mb-2">{{$data['meptp_approved']['status']}}</p>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['meptp_approved']['total']}}</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <p class="text-muted mt-2 mb-2">{{$data['ppmv_pending']['type']}}</p>
                        <p class="text-muted mt-2 mb-2">{{$data['ppmv_pending']['status']}}</p>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['ppmv_pending']['total']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <p class="text-muted mt-2 mb-2">{{$data['ppmv_approved']['type']}}</p>
                        <p class="text-muted mt-2 mb-2">{{$data['ppmv_approved']['status']}}</p>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['ppmv_approved']['total']}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        <!-- State office cards end  -->

        <!-- Pharmacy practice cards start  -->
        @can('isPPractice')
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <p class="text-muted mt-2 mb-2">METPT</p>
                        <p class="text-primary text-20 line-height-1 m-0">PASSED</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <p class="text-muted mt-2 mb-2">Tiered PPMV Registration</p>
                        <p class="text-primary text-20 line-height-1 m-0">PENDING</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        <!-- Pharmacy practice cards end  -->

        <!-- Registration licencing cards start  -->
        @can('isRLicencing')
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <p class="text-muted mt-2 mb-2">{{$data['ppmv_pending']['type']}}</p>
                        <p class="text-muted mt-2 mb-2">{{$data['ppmv_pending']['status']}}</p>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['ppmv_pending']['total']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <p class="text-muted mt-2 mb-2">{{$data['ppmv_approved']['type']}}</p>
                        <p class="text-muted mt-2 mb-2">{{$data['ppmv_approved']['status']}}</p>
                        <p class="text-primary text-60 line-height-1 m-0">{{$data['ppmv_approved']['total']}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        <!-- Registration licencing cards end  -->
        
         <!-- Vendor cards start  -->
        @can('isVendor')
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <p class="text-muted mt-2 mb-2">{{$data['type']}}</p>
                        <p class="text-primary text-20 line-height-1 m-0">{{$data['status']}}</p>
                    </div>
                </div>
            </div>
            <!-- <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <p class="text-muted mt-2 mb-2">METPT</p>
                        <p class="text-primary text-20 line-height-1 m-0">DOCS. QUERIED</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <p class="text-muted mt-2 mb-2">METPT</p>
                        <p class="text-primary text-20 line-height-1 m-0">APPROVED</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <p class="text-muted mt-2 mb-2">METPT</p>
                        <p class="text-primary text-20 line-height-1 m-0">EXAM CARD</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <p class="text-muted mt-2 mb-2">METPT</p>
                        <p class="text-primary text-20 line-height-1 m-0">PASSED</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <p class="text-muted mt-2 mb-2">METPT</p>
                        <p class="text-primary text-20 line-height-1 m-0">FAILED</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Diploma-2"></i>
                        <p class="text-muted mt-2 mb-2">Tiered PPMV Registration</p>
                        <p class="text-primary text-20 line-height-1 m-0">PENDING</p>
                    </div>
                </div>
            </div> -->
        </div>
        @endcan
        <!-- Vendor cards end  -->
    </div>
</div>
@endsection