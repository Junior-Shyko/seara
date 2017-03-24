<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name',
				'user_email',
				'user_password',
				'user_phone',
				'user_cargo',
				'user_id_company',
				'user_id_profile',
				'user_birth',
				'user_sex',
				'user_cpf',
				'user_street',
				'user_number',
				'user_complement',
				'user_district',
				'user_city',
				'user_state',
				'user_cep',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
