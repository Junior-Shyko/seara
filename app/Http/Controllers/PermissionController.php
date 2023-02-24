<?php

namespace Seara\Http\Controllers;

use Seara\Models\User;
use Illuminate\Http\Request;
use Seara\Repository\UserRepository;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    use \Seara\Traits\ActionTable;
    
    private function actionsPermissions($id)
    {

        return $this->actionButtons(

            $id,

            [
                [ 'Editar Permissão', 'editarPermission', 'fa-pencil' ],
                [ 'Excluir Usuário', 'deletePermission', 'fa-trash-o', 'btn-danger' ]
            ]

        );

    }
    public function getUserPermission()
    {
        $users = new UserRepository;
        $dataTable =  DataTables::of($users->getUserPermission());

        $dataTable->addColumn(
           
            'action',

            function ($user) 
            {
              return $this->actionsPermissions($user->idUser);
            }
        );
        return $dataTable->make(true);
    }

    public function userDeletePermission($id) {
        try {
            $user = User::find($id);           
            $user->roles()->detach();
            $user->delete();
            return response()->json([
                'message' => 'Nível excluído com sucesso',
                'type' => 'success'
            ], 200);
        } catch (\Exception $th) {
            return response()->json([
                'message' => 'Ocorreu um erro inesperado',
                'type' => 'error'
            ], 400);
        }
           
    }
}
