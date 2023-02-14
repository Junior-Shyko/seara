<?php

namespace Seara;

use Illuminate\Database\Eloquent\Model;
use \Spatie\Permission\Models\Role as RoleSpatie;

class Role extends Model
{
    public function allRole()
    {
        return RoleSpatie::all()->pluck('name','id');
    }
}
