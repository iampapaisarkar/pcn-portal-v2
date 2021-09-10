<div class="app-admin-wrap layout-sidebar-compact sidebar-dark-purple sidenav-open clearfix">
@include('layouts.navbars.sidebar')
<!--=============== Left side End ================-->
@include('layouts.navbars.app')
    <!-- ============ Body content start ============= -->
    <div class="main-content">

        @yield('content')
        <!-- Footer Start -->
        @include('layouts.footers.app') 
        <!-- fotter end -->
    </div>
</div>