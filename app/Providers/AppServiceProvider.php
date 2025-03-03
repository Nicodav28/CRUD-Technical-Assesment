<?php

namespace App\Providers;

use App\Contracts\IAreaRepository;
use App\Contracts\IEmployeeRepository;
use App\Contracts\IRoleRepository;
use App\Repositories\AreaRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\RoleRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IEmployeeRepository::class, EmployeeRepository::class);
        $this->app->bind(IAreaRepository::class, AreaRepository::class);
        $this->app->bind(IRoleRepository::class, RoleRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
