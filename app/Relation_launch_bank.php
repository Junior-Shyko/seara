<?php

namespace Seara;

use Seara\Seara\Monetary;
use Illuminate\Database\Eloquent\Model;

class Relation_launch_bank extends Model
{
    private $account_parent;
    private $account_child;
    private $value;
    private $type;
    private $accountBank_parent;
    private $accountBank_child;
    protected $table = 'relation_launch_bank';

    protected $fillable = [
        'account_parent',
        'account_child',
        'value',
        'type',
        'accountBank_parent',
        'accountBank_child'
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
    public function create_relation($request, $idParent, $idChild, $type)
    {
        $data['account_parent']     = $request['idAccountEnd'];
        $data['account_child']      = $request['idAccountEntry'];
        $data['value']              = Monetary::money_real($request['value']);
        $data['type']               = $type;
        $data['accountBank_parent'] = $idParent;
        $data['accountBank_child']  = $idChild;
        Relation_launch_bank::create($data);
    }
}
