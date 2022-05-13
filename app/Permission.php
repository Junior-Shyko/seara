<?php

namespace Seara;

use DB;
use Seara\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function profiles_permission()
    {
        //RELACIONAMENTO DE 3 TABELAS
        return $this->belongsToMany(\Seara\Models\Profile::class, 'permission_profile' , 'id', 'permission_id');
    }
}
