<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
	use Notifiable;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = [
		'name',
		'email',
		'password',
		'user_phone',
		'user_position',
		'user_id_company',
		'user_id_profile',
		'user_birth',
		'user_sex',
		'user_cpf',
		'user_addr_street',
		'user_addr_number',
		'user_addr_complement',
		'user_addr_district',
		'user_addr_city',
		'user_addr_state',
		'user_addr_cep',
	];

	/**
	* The attributes that should be hidden for arrays.
	*
	* @var array
	*/
	protected $hidden = [
		'password', 'remember_token',
	];

	protected $appends = [
		'profile'
	];

	public function getProfileAttribute()
	{
		$id_profile = $this->attributes['user_id_profile'];
		$profile = '';

		switch ($id_profile) 
		{
			case 1:
				$profile = 'owner';
				break;
			
			case 2:
				$profile = 'employee';
				break;

			case 3:
				$profile = 'admin';
				break;
		}

		return $profile;
	}

	/**
	* Envia a notificação de redefinição de senha
	*
	* @param  string  $token
	* @return void
	*/
	public function sendPasswordResetNotification($token)
	{
		$this->notify(new ResetPasswordNotification($token, $this));
	}

	public function company()
	{
		return $this->belongsTo('App\Models\Company', 'user_id_company');
	}

	public static function totalActiveUsers()
	{
		$query = DB::raw("
			SELECT 
				count(*) AS total
			FROM users
			LEFT JOIN companies
			ON users.user_id_company = companies.company_id
			WHERE companies.company_status = 1
		");

		$result = DB::select( $query );

		return $result[0]->total;
	}

}
