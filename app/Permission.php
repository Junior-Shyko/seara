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

    /**
     * Verifica a permissão de cada usuário
     * Se o usuário não foi um superAdmin o mesmo é verificado
     * se o id_company dele bate com o da url
     * @param [type] $idCompany
     * @param [type] $user
     * @return void
     */
    static public function verifyPermission($idCompany, $user)
    {
        $access = false;
        //RECEBENDO OS PAPEIS DO USUÁRIO
        $role = $user->getRoleNames();
        //LOOP NA COLLECTION PARA COMPARAR SE O USUARIO PERTENCIA A IGREJA
        foreach ($role as $roles) {
            if($roles !== 'superAdmin'){
                if($user->user_id_company == $idCompany)
                {
                    $access = true;
                }
            }
        }

        return $access;
    }
}
