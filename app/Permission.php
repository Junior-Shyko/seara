<?php

namespace Seara;

use DB;
use Seara\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    const superAdmin = 'superAdmin';//se é um superAdmin dentro da tabela permissions
    const admin = 2;//se é um admin dentro da tabela permissions

    public function profiles_permission()
    {
        //RELACIONAMENTO DE 3 TABELAS
        return $this->belongsToMany(\Seara\Models\Profile::class, 'permission_profile' , 'id', 'permission_id');
    }

    /**
     * Consulta na tabela permissions a permissao passada via parametro
     *
     * @param [type] $user
     * @param [type] $permission
     * @return void
     */
    static public function verifyAccess($user, $permission)
    {
        return $user->hasRole($permission);
    }

    public function allPermission()
    {
        return \Spatie\Permission\Models\Permission::all()->pluck('name','id');
    }
}
