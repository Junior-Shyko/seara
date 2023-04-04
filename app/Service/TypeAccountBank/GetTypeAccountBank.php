<?php

declare(strict_types=1);
namespace Seara\Service\TypeAccountBank;

use Seara\TypeBank;

class GetTypeAccountBank 
{

    static public function getTyppeAccountBank()
    {
        $type = TypeBank::select('id', 'name as text')->get();
        return $type;
    }
}