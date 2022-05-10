<?php

namespace Seara\Providers;

use Seara\Entry;
use Seara\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Seara\Model' => 'Seara\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('owner-entry', function (User $user, Entry $entry) {
            return $user->user_id_company == $entry->entries_id_company;
        });
    }
}
