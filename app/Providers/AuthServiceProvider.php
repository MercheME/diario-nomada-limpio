<?php

namespace App\Providers;

use App\Models\Diario;
use App\Models\DiarioImagen;
use App\Policies\DiarioImagenPolicy;
use App\Policies\DiarioPolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

      /**
     * The policy mappings for the application.
     */
    protected $policies = [
        Diario::class => DiarioPolicy::class,
        DiarioImagen::class => DiarioImagenPolicy::class,
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
