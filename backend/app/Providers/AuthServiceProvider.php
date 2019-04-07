<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Support\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Bind Passport routes into controller
        Passport::routes();

        //Expire Time for refresh tokens & access tokens
        Passport::personalAccessTokensExpireIn(Carbon::now()->addDays(15)); //15days
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30)); //30days
        // Passport::tokensExpireIn(Carbon::now()->addDays(15)); //15days

        //revoke token's unnecessary
        Passport::pruneRevokedTokens();
    }
}
