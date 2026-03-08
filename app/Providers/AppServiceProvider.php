<?php

namespace App\Providers;

use App\Enums\Entity;
use App\Models\Address;
use App\Models\Addressable;
use App\Models\Bank;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            Entity::USER->value => User::class,
            Entity::ADDRESS->value => Addressable::class,
            Entity::BANK->value => Bank::class,
        ]);
    }
}
