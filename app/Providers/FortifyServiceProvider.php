<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use App\Models\User;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
   public function boot()
{
    $this->app->singleton(LoginResponse::class, function () {
        return new class implements LoginResponse {
            public function toResponse($request)
            {
                $user = $request->user();
                return redirect($user->role === 'admin' 
                    ? '/dashboard' 
                    : '/dashboard');
            }
        };
    });
}
}
