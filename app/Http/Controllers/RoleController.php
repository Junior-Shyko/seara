<?php

namespace Seara\Http\Controllers;

use Seara\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function alterRoleUser($request)
    {
        $user = User::find($request->user);
        $roles = $user->getRoleNames();
        
        try {
            foreach ($roles as $key => $value) {
                $user->removeRole($roles[$key]);
            }
            $user->assignRole($request->role);
            return response()->json([
            'message' => 'Nível alterado com sucesso',
            'title' => 'Sucesso',
            'type' => 'success'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ocorreu um erro inesperado.'], 400);
        }
    }
}
