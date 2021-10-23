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

        Gate::define('isRegistry', function($user){
            if($user->role->code == 'registry'){
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

        Gate::define('isIMonitoring', function($user){
            if($user->role->code == 'inspection_monitoring'){
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
        
        Gate::define('isHPharmacy', function($user){
            if($user->role->code == 'hospital_pharmacy'){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('isCPharmacy', function($user){
            if($user->role->code == 'community_pharmacy'){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('isDpremises', function($user){
            if($user->role->code == 'distribution_premises'){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('isMpremises', function($user){
            if($user->role->code == 'manufacturing_premises'){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('isPPMV', function($user){
            if($user->role->code == 'ppmv'){
                return true;
            }else{
                return false;
            }
        });
    }
}
