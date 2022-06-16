<?php

namespace Seara;

use DB;
use Seara\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    const superAdmin = 6;//se é um superAdmin dentro da tabela permissions
    const admin = 7;//se é um admin dentro da tabela permissions

    public function profiles_permission()
    {
        //RELACIONAMENTO DE 3 TABELAS
        return $this->belongsToMany(\Seara\Models\Profile::class, 'permission_profile' , 'id', 'permission_id');
    }

    static public function verifyAccess($user, $permission, $idCompany)
    {
        $permission = !$user->hasPermissionTo(Permission::find($permission)->id);
    }
}
