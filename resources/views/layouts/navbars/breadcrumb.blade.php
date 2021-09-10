<div class="breadcrumb">
    @if(Auth::user()->hasRole(['sadmin']))
        <h1 class="mr-2">PCN Pharmacy Practice | HQ Abuja</h1>
    @endif
    @if(Auth::user()->hasRole(['state_office']))
        <h1 class="mr-2">PCN State Office | State Office</h1>
    @endif
    @if(Auth::user()->hasRole(['pharmacy_practice']))
        <h1 class="mr-2">PCN Pharmacy Practice | HQ Abuja</h1>
    @endif
    @if(Auth::user()->hasRole(['registration_licencing']))
        <h1 class="mr-2">PCN Registration and Licencing | HQ Abuja</h1>
    @endif
    @if(Auth::user()->hasRole(['vendor']))
        <h1 class="mr-2">Tiered PPMV</h1>
    @endif
    <ul>
        <li><a href="{{route($route)}}">{{$page}}</a></li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>