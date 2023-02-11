<?php

namespace Auth\SignedRequest;

use Illuminate\Support\ServiceProvider;

class SignedRequestServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/../config/auth-signature.php' => config_path('auth-signature.php')
            ]
        );
    }

}