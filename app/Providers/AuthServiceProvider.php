<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function($user){
            if($user->role->code == 'sadmin'){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('isSOffice', function($user){
            if($user->role->code == 'state_office'){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('isPPractice', function($user){
            if($user->role->code == 'pharmacy_practice'){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('isRLicencing', function($user){
            if($user->role->code == 'registration_licencing'){
                return true;
            }else{
                return false;
            }
        });
        
        Gate::define('isVendor', function($user){
            if($user->role->code == 'vendor'){
                return true;
            }else{
                return false;
            }
        });
    }
}
