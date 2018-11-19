<?php

namespace App\Providers;

use function foo\func;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('super-admin-only',function($user){
            if($user->role_id == IDofRole('Super Admin')){
                return true;
            }
            return false;
        });

        Gate::define('hcd-admin-or-higher',function($user){
            if($user->role_id == IDofRole('HCD Admin') || $user->role_id == IDofRole('Super Admin')){
                return true;
            }
            return false;
        });

        Gate::define('data-management-admin-or-higher',function($user){
            if($user->role_id == IDofRole('Data Management Admin') || $user->role_id == IDofRole('Super Admin')){
                return true;
            }
            return false;
        });
    }
}
