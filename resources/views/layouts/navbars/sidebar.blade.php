<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li class="nav-item  active" data-item="admin">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">Admin</span>
                </a>
                <div class="triangle"></div>
            </li>
        </ul>
    </div>
    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <i class="sidebar-close i-Close" (click)="toggelSidebar()"></i>
        <header>
            <div class="logo">
                <img src="{{ asset('admin/dist-assets/images/logo.png')}}" alt="">
            </div>
        </header>
        <!-- Submenu Dashboards -->
        
        <div class="submenu-area" data-parent="admin">
            <header>
                @if(Auth::user()->hasRole(['sadmin']))
                <h6>HQ Abuja</h6>
                <p>Super Admin</p>
                @endif
                @if(Auth::user()->hasRole(['state_office']))
                <h6>PCN State Office</h6>
                <p>{{ucfirst(Auth::user()->user_state->name)}} State</p>
                @endif
                @if(Auth::user()->hasRole(['registry']))
                <h6>PCN HQ</h6>
                <p>Registry</p>
                @endif
                @if(Auth::user()->hasRole(['pharmacy_practice']))
                <h6>PCN HQ Abuja</h6>
                <p>Pharmacy Practice</p>
                @endif
                @if(Auth::user()->hasRole(['inspection_monitoring']))
                <h6>PCN HQ Abuja</h6>
                <p>Inspection Monitoring</p>
                @endif
                @if(Auth::user()->hasRole(['registration_licencing']))
                <h6>PCN HQ Abuja</h6>
                <p>Registration and Licencing</p>
                @endif
                @if(Auth::user()->hasRole(['hospital_pharmacy']))
                <h6>Hospital Pharmacy</h6>
                <p>PCN Hospital Pharmacy</p>
                @endif
                @if(Auth::user()->hasRole(['community_pharmacy']))
                <h6>Community Pharmacy</h6>
                <p>PCN Community Pharmacy</p>
                @endif
                @if(Auth::user()->hasRole(['distribution_premises']))
                <h6>Distribution Premises</h6>
                <p>PCN Distribution Premises</p>
                @endif
                @if(Auth::user()->hasRole(['manufacturing_premises']))
                <h6>Manufacturing Premises</h6>
                <p>PCN Manufacturing Premises</p>
                @endif
                @if(Auth::user()->hasRole(['ppmv']))
                <h6>PPMV</h6>
                <p>PCN PPMV</p>
                @endif
                
            </header>
            <ul class="childNav">
                <li class="nav-item">
                    <a href="{{route('dashboard')}}">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('profile')}}">
                        <i class="nav-icon i-Security-Settings"></i>
                        <span class="item-name">Manage Profile</span>
                    </a>
                </li>
                
                <!-- Super admin routes start  -->
                @can('isAdmin')
                <li class="nav-item">
                    <a href="{{route('users.index')}}">
                        <i class="nav-icon i-Professor"></i>
                        <span class="item-name">Admin Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('premises.index')}}">
                        <i class="nav-icon i-Gears"></i>
                        <span class="item-name">Premises</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('services.index')}}">
                        <i class="nav-icon i-Money-2"></i>
                        <span class="item-name">Service Fees</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('payments.index')}}">
                        <i class="nav-icon i-Coins"></i>
                        <span class="item-name">Payments</span>
                    </a>
                </li>
                @endcan
                <!-- Super admin routes end  -->

                <!-- State office routes start  -->
                @can('isSOffice')
                <li class="nav-item">
                    <a href="{{route('state-office-documents.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Documents Review </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('state-office-locations.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Location Inspection - Report Upload</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('state-office-location-reports.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Location Inspection - Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('state-office-registration.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Facility Inspection - Report Upload</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('state-office-registration-reports.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Facility Inspection - Reports</span>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Renewal Inspection - Report Upload</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Renewal Inspection - Reports</span>
                    </a>
                </li> -->
                @endcan
                <!-- State office routes end  -->

                <!-- Registry routes start  -->
                @can('isRegistry')
                <li class="nav-item">
                    <a href="{{route('registry-locations.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Location Inspection</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('registry-location-recommendation.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Location Inspection Recommendation</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('registry-documents.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Facility Inspection</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('registry-recommendation.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Facility Inspection Recommendation</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('registry-renewal-pending.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Renewal Inspection</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('registry-renewal-recommendation.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Renewal Inspection Recommendation</span>
                    </a>
                </li>
                @endcan
                <!-- Registry routes end  -->

                <!-- Pharmacy practice routes start  -->
                @can('isPPractice')
                <li class="nav-item">
                    <a href="{{route('pharmacy-practice-documents.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Facility Inspection - Report Upload</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('pharmacy-practice-reports.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Facility Inspection - Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('pharmacy-renewal-pending.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Renewal Inspection - Report Upload</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('pharmacy-renewal-reports.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Renewal Inspection - Reports</span>
                    </a>
                </li>
                @endcan
                <!-- Pharmacy practice routes end  -->

                 <!-- Inspection Monitoring routes start  -->
                 @can('isIMonitoring')
                <li class="nav-item">
                    <a href="{{route('monitoring-inspection.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Location Inspection - Report Upload</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('monitoring-inspection-reports.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Location Inspection - Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('monitoring-inspection-flt.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Facility Inspection - Report Upload</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('monitoring-inspection-flt-reports.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Facility Inspection - Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('monitoring-inspection-renewal.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Renewal Inspection - Report Upload</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('monitoring-renewal-reports.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Renewal Inspection - Reports</span>
                    </a>
                </li>
                @endcan
                <!-- Inspection Monitoring routes end  -->

                <!-- Registration licencing routes start  -->
                @can('isRLicencing')
                <li class="nav-item">
                    <a href="{{route('licence-pending.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Facility Registration Licence Pending</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('licence-issued.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Facility Registration Licence Issued</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('renewal-pending.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Facility Renewal Licence Pending</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('renewal-issued.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Facility Renewal Licence Issued</span>
                    </a>
                </li>
                @endcan
                <!-- Registration licencing routes end  -->

                <!-- Hospital Pharmacy routes start  -->
                @can('isHPharmacy')
                <li class="nav-item">
                    <a href="{{route('hospital-registration-form')}}">
                        <i class="nav-icon i-Notepad"></i>
                        <span class="item-name">Registration</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('hospital-registration-status')}}">
                        <i class="nav-icon i-Notepad"></i>
                        <span class="item-name">Registration Status</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('hospital-renewals.index')}}">
                        <i class="nav-icon i-Notepad"></i>
                        <span class="item-name">Retention (Annual Renewal)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('invoices.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Invoices</span>
                    </a>
                </li>
                @endcan
                <!-- Hospital Pharmacy routes end  -->

                <!-- Community Pharmacy routes start  -->
                @can('isCPharmacy')
                <li class="nav-item">
                    <a href="{{route('company-profile')}}">
                        <i class="nav-icon i-Security-Settings"></i>
                        <span class="item-name">Company Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('location-approval-form')}}">
                        <i class="nav-icon i-Map2"></i>
                        <span class="item-name">Location Approval</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('location-approval-status')}}">
                        <i class="nav-icon i-Map2"></i>
                        <span class="item-name">Location Approval Status</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('facility-registration-form')}}">
                        <i class="nav-icon i-Notepad"></i>
                        <span class="item-name">Registration</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('facility-registration-status')}}">
                        <i class="nav-icon i-Notepad"></i>
                        <span class="item-name">Registration Status</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('cp-dp-renewals.index')}}">
                        <i class="nav-icon i-Notepad"></i>
                        <span class="item-name">Renewal</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('invoices.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Invoices</span>
                    </a>
                </li>
                @endcan
                <!-- Community Pharmacy routes end  -->

                <!-- Distribution Premises routes start  -->
                @can('isDpremises')
                <li class="nav-item">
                    <a href="{{route('company-profile')}}">
                        <i class="nav-icon i-Security-Settings"></i>
                        <span class="item-name">Company Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('location-approval-form')}}">
                        <i class="nav-icon i-Map2"></i>
                        <span class="item-name">Location Approval</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('location-approval-status')}}">
                        <i class="nav-icon i-Map2"></i>
                        <span class="item-name">Location Approval Status</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('facility-registration-form')}}">
                        <i class="nav-icon i-Notepad"></i>
                        <span class="item-name">Registration</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('facility-registration-status')}}">
                        <i class="nav-icon i-Notepad"></i>
                        <span class="item-name">Registration Status</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('cp-dp-renewals.index')}}">
                        <i class="nav-icon i-Notepad"></i>
                        <span class="item-name">Renewal</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('invoices.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Invoices</span>
                    </a>
                </li>
                @endcan
                <!-- Distribution Premises routes end  -->

                <!-- Manufacturing Premises routes start  -->
                @can('isMpremises')
                <li class="nav-item">
                    <a href="{{route('company-profile')}}">
                        <i class="nav-icon i-Security-Settings"></i>
                        <span class="item-name">Company Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="">
                        <i class="nav-icon i-Map2"></i>
                        <span class="item-name">Location Approval</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="">
                        <i class="nav-icon i-Map2"></i>
                        <span class="item-name">Location Approval Status</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="">
                        <i class="nav-icon i-Notepad"></i>
                        <span class="item-name">Registration</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="">
                        <i class="nav-icon i-Notepad"></i>
                        <span class="item-name">Registration Status</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="">
                        <i class="nav-icon i-Notepad"></i>
                        <span class="item-name">Renewal</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('invoices.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Invoices</span>
                    </a>
                </li>
                @endcan
                <!-- Manufacturing Premises routes end  -->

                <!-- PPMV routes start  -->
                @can('isPPMV')
                <li class="nav-item">
                    <a href="{{route('ppmv-application-form')}}">
                        <i class="nav-icon i-Map2"></i>
                        <span class="item-name">Location Approval</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('ppmv-application-status')}}">
                        <i class="nav-icon i-Map2"></i>
                        <span class="item-name">Location Approval Status</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('ppmv-facility-application-form')}}">
                        <i class="nav-icon i-Notepad"></i>
                        <span class="item-name">Registration</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('ppmv-facility-application-status')}}">
                        <i class="nav-icon i-Notepad"></i>
                        <span class="item-name">Registration Status</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('ppmv-renewals.index')}}">
                        <i class="nav-icon i-Notepad"></i>
                        <span class="item-name">Renewal</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('invoices.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Invoices</span>
                    </a>
                </li>
                @endcan
                <!-- PPMV routes end  -->
            </ul>
        </div>
    </div>
</div>