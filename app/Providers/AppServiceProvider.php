<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // Importação necessária para a paginação funcionar

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Força o Laravel a usar o layout do Bootstrap (que não quebra as setas na tela)
        Paginator::useBootstrapFive();
    }
}
