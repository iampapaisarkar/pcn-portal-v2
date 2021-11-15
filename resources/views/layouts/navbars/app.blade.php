<div class="main-content-wrap d-flex flex-column">
<div class="main-header">
    <div class="logo">
        <img src="{{ asset('admin/dist-assets/images/logo.png')}}" alt="">
    </div>
    <div class="menu-toggle">
        <div></div>
        <div></div>
        <div></div>
    </div>
    
    <div style="margin: auto"></div>
    <div class="header-part-right">
        <!-- Full screen toggle -->
        <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>
        <!-- Grid menu Dropdown -->

        <!-- User avatar dropdown -->
        <div class="dropdown">
            <div class="user col align-self-end">
                @php
                if (auth()->user()->hasRole(['hospital_pharmacy'])) {
                    if(Auth::user()->registration() && Auth::user()->registration()->hospital_pharmacy()->first() && Auth::user()->registration()->hospital_pharmacy()->first()->passport){
                        $image = asset('images/' . Auth::user()->registration()->hospital_pharmacy()->first()->passport);
                    }else{
                        $image = asset('admin/dist-assets/images/avatar.jpg');
                    }
                }else if(auth()->user()->hasRole(['ppmv'])){
                    if(Auth::user()->photo){
                        $image = asset('images/' . Auth::user()->photo);
                    }else{
                        $image = asset('admin/dist-assets/images/avatar.jpg');
                    }
                }else if(auth()->user()->hasRole(['community_pharmacy', 'distribution_premises', 'manufacturing_premises'])){
                    if(Auth::user()->company && Auth::user()->company->business && Auth::user()->company->business->passport){
                        $image = asset('images/' . Auth::user()->company->business->passport);
                    }else{
                        $image = asset('admin/dist-assets/images/avatar.jpg');
                    }
                }else{
                    $image = asset('admin/dist-assets/images/avatar.jpg');
                }
                @endphp
                <img src="{{ $image }}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header">
                        <i class="i-Lock-User mr-1"></i> {{Auth::user()->firstname . ' ' . Auth::user()->lastname}}
                    </div>
                    <a class="dropdown-item" href="{{route('profile')}}">Profile Settings</a>
                    <!-- <a class="dropdown-item" href="#">Billing History</a> -->
                    <a onclick="logout(event)" class="dropdown-item" href="#">Sign Out</a>
                </div>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>

<script>
	function logout(event){
		event.preventDefault();

		$.confirm({
			title: 'Logout',
			content: 'Are you sure want to logout?',
			buttons: {   
				ok: {
					text: "YES",
					btnClass: 'btn-primary',
					keys: ['enter'],
					action: function(){
						document.getElementById('logout-form').submit();
					}
				},
				cancel: function(){
						console.log('the user clicked cancel');
				}
			}
		});

	}
</script>