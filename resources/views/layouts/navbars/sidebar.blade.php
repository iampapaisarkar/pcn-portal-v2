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
                        <i class="nav-icon i-Bar-Chart"></i>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('profile')}}">
                        <i class="nav-icon i-Bar-Chart"></i>
                        <span class="item-name">Profile</span>
                    </a>
                </li>
                
                <!-- Super admin routes start  -->
                @can('isAdmin')
                <li class="nav-item">
                    <a href="{{route('users.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Admin Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('vendor-profiles.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
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
                </li>
                <li class="nav-item">
                    <a href="{{route('services.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Service Fees</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('payments.index')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Payments</span>
                    </a>
                </li>
                @endcan
                <!-- Super admin routes end  -->

                <!-- State office routes start  -->
                @can('isSOffice')
                <li class="nav-item">
                    <a href="{{route('meptp-pending-batches')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">MEPTP - Doc. Review Pending </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('meptp-approve-batches')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">MEPTP - Doc. Review Approved </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('meptp-traning-approved-batches')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">MEPTP - Training Approved </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('ppmv-pending-applications')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">PPMV Registration - Doc. Review</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('ppmv-inspection-applications')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">PPMV Registration - Inspection</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('ppmv-inspection-reports')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">PPMV Registration - Report</span>
                    </a>
                </li>
                @endcan
                <!-- State office routes end  -->

                <!-- Pharmacy practice routes start  -->
                @can('isPPractice')
                <li class="nav-item">
                    <a href="{{route('meptp-approval-states')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">MEPTP - Pending PP Approval</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('meptp-approved-batches')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">MEPTP - Training PP Approved</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('meptp-results-batches')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">MEPTP - Training Results</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('ppmv-reports')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">PPMV Registration</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('dashboard')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">PPMV Status</span>
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

                <!-- Vendor routes start  -->
                @can('isVendor')
                <li class="nav-item">
                    <a href="{{route('meptp-application')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">MEPTP Application</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('meptp-application-status')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">MEPTP Application Status</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('meptp-application-result')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">MEPTP Result</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('ppmv-application')}}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Registration</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('ppmv-renewal')}}">
                        <i class="nav-icon i-Receipt-4"></i>
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
                <!-- Vendor routes end  -->
            </ul>
        </div>
    </div>
</div>