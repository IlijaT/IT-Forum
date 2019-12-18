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
        'App\Thread' => 'App\Policies\ThreadPolicy',
        'App\Reply' => 'App\Policies\ReplyPolicy',
        'App\USer' => 'App\Policies\UserPolicy',

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /**
         * IF WE HAVE SUPER ADMIN USER WE CAN IMPLEMENT 
         * LOGIC HERE TO RUN BEFORE POLICIES
         */
        // Gate::before(function ($user) {
        //     if ($user->name === 'Marijana Mirkovic') {
        //         return true;
        //     }
        // });
    }
}
