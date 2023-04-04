<?php

namespace Seara\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	protected $primaryKey = 'setting_id';

	protected $fillable = [
		'setting_id_company',
		'setting_receipt_local',
		'setting_receipt_emitter',
		'setting_receipt_document',
		'setting_receipt_email',
		'setting_receipt_header'
	];
}