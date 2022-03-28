<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Firebase\JWT\JWT;
Use Firebase\JWT\Key;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
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

        //

        $this->app['auth']->viaRequest('token', function ($request) {

            $token = $request->bearerToken();
            if(empty($token)) {
                return null;
            }
            $secret = 'password123';

            try{
                $decodeData = JWT::decode($token, new Key($secret, 'HS256'));
                return User::where('id', $decodeData->id)->firstOrFail();
            }catch (\Throwable $th){
                return null;
            }
            return null;

        });
    }
}
