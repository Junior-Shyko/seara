<?php

namespace Seara;

use Seara\Seara\Monetary;
use Illuminate\Database\Eloquent\Model;

class Relation_launch_bank extends Model
{
    protected $table = 'relation_launch_bank';

    protected $fillable = [
        'account_parent',
        'account_child',
        'value',
        'type',
        'entries_parent',
        'entries_child'
    ];


    /**
     * Undocumented function
     *
     * @param [data] $request
     * @param [id] $idParent
     * @param [id] $idChild
     * @param [string] $type
     * @return void
     */
    static public function create_relation($idParent, $idChild, $value, $type, $entriesParent, $entriesChild)
    {
        $data['account_parent']     = $idParent;
        $data['account_child']      = $idChild;
        $data['value']              = Monetary::money_real($value);
        $data['type']               = $type;
        $data['entries_parent']     = $entriesParent;
        $data['entries_child']      = $entriesChild;
        Relation_launch_bank::create($data);
    }
}
