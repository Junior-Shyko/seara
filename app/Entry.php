<?php

namespace Seara;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    public function fileLaunches()
    {
        return $this->hasMany(FileLaunch::class, 'file_launches_id_entry', 'entries_id');
    }

    protected $table 		= 'entries';
    protected $primaryKey 	= 'entries_id';
    protected $fillable	 	= [
        'entries_id_account' ,
        'entries_day',
        'entries_description' ,
        'entries_id_company' ,
        'entries_id_user' ,
        'entries_id_account',
        'entries_value' ,
        'entries_id_box' ,
        'entries_file',
        'entries_date_launch',
        'updated_at',
        'entries_bank',
        'transaction_id',
        'entries_parent'
    ];
}
