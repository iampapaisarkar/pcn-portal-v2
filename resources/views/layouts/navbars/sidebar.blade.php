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
                @if(Auth::user()->hasRole(['registration_licencing']))
                <h6>PCN HQ Abuja</h6>
                <p>Registration and Licencing</p>
                @endif
                @if(Auth::user()->hasRole(['vendor']))
                <h6>PPMV</h6>
                <p>Tiered PPMV</p>
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
                <!-- <li class="nav-item">
                    <a href="{{route('vendor-profiles.index')}}">
                        <i class="nav-icon i-Professor"></i>
                        <span class="item-name">Vendor Profiles</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('schools.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Training Schools</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('batches.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">MEPTP Batches</span>
                    </a>
                </li> -->
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
                    <a href="">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Location Inspection - Report Upload</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Location Inspection - Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Facility Inspection - Report Upload</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Facility Inspection - Reports</span>
                    </a>
                </li>
                <li class="nav-item">
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
                </li>
                @endcan
                <!-- State office routes end  -->

                <!-- Registry routes start  -->
                @can('isRegistry')
                <li class="nav-item">
                    <a href="">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Location Inspection</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="">
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
                    <a href="">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Facility Inspection Recommendation</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Renewal Inspection</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="">
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
                </li>
                @endcan
                <!-- Pharmacy practice routes end  -->

                <!-- Registration licencing routes start  -->
                @can('isRLicencing')
                <li class="nav-item">
                    <a href="{{route('ppmv-licence-pending-lists')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">PPMV Registration - Licence Pending</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('ppmv-licence-issued-lists')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">PPMV Registration - Licence Issued</span>
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
                    <a href="">
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
                <!-- Vendor routes end  -->
            </ul>
        </div>
    </div>
</div>