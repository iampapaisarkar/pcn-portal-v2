<div class="breadcrumb">
    @if(Auth::user()->hasRole(['sadmin']))
        <h1 class="mr-2">PCN | HQ Abuja</h1>
    @endif
    @if(Auth::user()->hasRole(['state_office']))
        <h1 class="mr-2">PCN State Office | State Office</h1>
    @endif
    @if(Auth::user()->hasRole(['registry']))
        <h1 class="mr-2">PCN | HQ Abuja</h1>
    @endif
    @if(Auth::user()->hasRole(['pharmacy_practice']))
        <h1 class="mr-2">PCN | HQ Abuja</h1>
    @endif
    @if(Auth::user()->hasRole(['inspection_monitoring']))
        <h1 class="mr-2">PCN | HQ Abuja</h1>
    @endif
    @if(Auth::user()->hasRole(['registration_licencing']))
        <h1 class="mr-2">PCN Registration and Licencing | HQ Abuja</h1>
    @endif

    @if(Auth::user()->hasRole(['hospital_pharmacy']))
        <h1 class="mr-2">Hospital Pharmacy</h1>
    @endif
    @if(Auth::user()->hasRole(['community_pharmacy']))
        <h1 class="mr-2">Community Pharmacy</h1>
    @endif
    @if(Auth::user()->hasRole(['distribution_premisis']))
        <h1 class="mr-2">Premisis</h1>
    @endif
    @if(Auth::user()->hasRole(['manufacturing_premisis']))
        <h1 class="mr-2">Premisis</h1>
    @endif
    @if(Auth::user()->hasRole(['ppmv']))
        <h1 class="mr-2">PPMV</h1>
    @endif
    <ul>
        <li><a href="{{route($route)}}">{{$page}}</a></li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>