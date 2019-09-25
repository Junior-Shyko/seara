<?php

declare(strict_types=1);

namespace App\Service\Company;

use App\DataTransferObject;

class CompanyData extends DataTransferObject
{
    /**
     * @var string
     */
    public $nome;

    /**
     * @var string
     */
    public $fantasia;

    /**
     * @var string
     */
    public $logradouro;

    /**
     * @var string
     */
    public $numero;

    /**
     * @var string
     */
    public $complemento;

    /**
     * @var string
     */
    public $cep;

    /**
     * @var string
     */
    public $bairro;

    /**
     * @var string
     */
    public $municipio;

    /**
     * @var string
     */
    public $uf;

    /**
     * @var string
     */
    public $telefone;
}