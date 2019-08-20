<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use App\Models\Passport\Client;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use 
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

        Passport::routes();

	Passport::loadKeysFrom('/home/rroyce/secret-keys/');

    	Passport::tokensExpireIn(now()->addDays(15));

	Passport::withoutCookieSerialization();

    	Passport::refreshTokensExpireIn(now()->addDays(30));

    	Passport::personalAccessTokensExpireIn(now()->addMonths(6));

    	Passport::useClientModel(Client::class);

	Auth::provider('ldap', function($app, array $config) {
		return new Adldap\Laravel\Auth\DatabaseUserProvider($app['hash'], $config['model']);
	});
    }
}
