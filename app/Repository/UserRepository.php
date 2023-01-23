<?php

namespace Seara\Repository;

use Seara\Models\User;


Class UserRepository {
    
    public function getUserPermission()
    {
        $users = User::join('model_has_roles', 'users.id','=','model_has_roles.model_id')
                ->leftJoin('companies', 'users.user_id_company','=','companies.company_id')
                ->leftJoin('roles', 'model_has_roles.role_id','=','roles.id')
                ->leftJoin('role_has_permissions', 'roles.id', '=', 'role_has_permissions.role_id')
                ->leftJoin('permissions','role_has_permissions.permission_id', '=', 'permissions.id')
                ->select('users.id as idUser', 'users.name as nameUsers', 'users.email', 'users.user_id_profile',
                'model_has_roles.*',
                'companies.company_id as idComp', 'companies.company_name as nameComp',
                'roles.id as idRoles', 'roles.name as nameRoles',
                'role_has_permissions.*',
                'permissions.id as idPerm', 'permissions.name as namePerm')
                ->get();
        return $users;
    }
}
