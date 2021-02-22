<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $table 		= 'entries';
    protected $primaryKey 	= 'entries_id';
    protected $fillable	 	= [
        'entries_id_account' ,
        'entries_day',
        'entries_description' ,
        'entries_id_company' ,
        'entries_id_user' ,
        'entries_value' ,
        'entries_id_box' ,
        'entries_file'
    ];
}
