<?php

namespace Seara\Providers;

use Auth;
use Seara\Entry;
use App\Models\User;
use Seara\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Collection::class => EntryPolicy::class,// add Collection por que é o parametro que passo no metodo
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $permissions = Permission::with('profiles_permission')->get();
        foreach ($permissions as $permission) {
            dump($permission->name);
           Gate::define($permission->name, function(User $user) use ($permission){
               dump($user);
               dump($permission);
               //return $user->hasPermission($permission);
            //return $user->user_id_company == $entry->entries_id_company;
           });
        }
        die;
    }


}
