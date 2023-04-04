<?php

namespace Seara\Policies;

use Seara\Entry;
use Seara\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Auth\Access\HandlesAuthorization;

class EntryPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function ownerEntry(User $user, Collection $entry)
    {
        dump($user);
        dd($entry);
        return $user->user_id_company == $entry[0]->entries_id_company;
    }
}
