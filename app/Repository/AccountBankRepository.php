<?php

namespace Seara\Repository;

use Seara\Bank;
use App\Account;
use Carbon\Carbon;
use Seara\AccountBank;
use Seara\Seara\Monetary;
use Illuminate\Http\Request;
use Doctrine\DBAL\Tools\Dumper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Seara\Repository\BankRepository;
use Seara\Service\Launch\CreateLaunch;
use Seara\Service\AccountBank\AccountBankService;

class AccountBankRepository
{


    const INTERNAL_TO_BANK = 1; //TRANSAÇÃO CAIXA INTERNO PARA BANCO
    const BANK_TO_INTERNAL = 2; //TRANSAÇÃO DO BANCO PARA CAIXA INTERNO
    /**
     * Retorna o relacionamento de todas as tabelas relacionadas
     *
     * @return void
     */
    static public function getRelationAccountBank()
    {
        $user = Auth::user();
        return AccountBank::with('account')
            ->join('companies', 'account_banks.company_id', '=', 'companies.company_id')
            ->join('type_banks', 'account_banks.typeBank_id', '=', 'type_banks.id')
            ->join('banks', 'account_banks.bank_id', '=', 'banks.id')
            ->join('users', 'account_banks.owner', '=', 'users.id')
            ->select(
                'type_banks.id',
                'type_banks.name',
                'type_banks.name as nameTypeBank',
                'banks.id',
                'banks.name as nameBank',
                'account_banks.*',
                'users.id',
                'users.name as nameUser',
                'account_banks.id as idAccountBank'
            )
            ->where('companies.company_id', $user->user_id_company)
            ->get();
    }

    static public function getBalance($idCompany)
    {
        $balance = AccountBank::where('company_id', $idCompany)->get();
        $balanceActual = 0;
        //SOMANDO TODOS OS VALORES
        foreach ($balance as $value) {
            $balanceActual = ($balanceActual + $value->balance);
        }
        return $balanceActual;
    }

    static public function update($request)
    {
        $money = Monetary::money_real($request['balance']);
        $request['balance'] = $money;
        $accountBank = AccountBank::findOrFail($request['idAccontBank']);
        unset($request['idAccontBank']);
        return $accountBank->update($request);
    }

    /**
     * Retorna a relação entre conta bancaria, tipo de conta bancaria e banco de acordo
     * com o id da igreja
     * Condicional
     * @return void
     */
    static public function getAccountBankAndTypeToCompany($idCompany, $idAccount = null)
    {
        //se tiver um where então faz a condição buscando a conta de acondo com o id
        return DB::table('account_banks')
            ->join('type_banks', 'account_banks.typeBank_id', '=', 'type_banks.id')
            //->join('banks', 'account_banks.bank_id', '=', 'banks.id')                   
            ->join('banks', function ($query) use ($idAccount) {
                if ($idAccount != null) {
                    $query->on('account_banks.bank_id', '=', 'banks.id')
                        ->where('account_banks.id', $idAccount);
                } else {
                    $query->on('account_banks.bank_id', '=', 'banks.id');
                }
            })
            ->select(
                'type_banks.*',
                'account_banks.*',
                'type_banks.name as nameTypeBank',
                'banks.name as nameBank',
                'account_banks.id as idAccountBank'
            )
            ->where('account_banks.company_id', $idCompany)->get();
    }

    /**
     * Retorna todas as informações de uma conta definida
     *
     * @return void
     */
    static public function getInfoAccountBank($id)
    {
        $account = AccountBank::findOrFail($id);
        return $account;
    }

    /**
     * Faz transferencia de valores entre contas
     */
    static public function transfer($request)
    {
        $idaccountBank = 0;
        $idaccountBank2 = 0;
        //verifica se tem saldo para transferencia
        $verifyBalanceToAccount = self::verifyBalanceToAccount($request);

        //false em caso de nao ter saldo suficiente
        if (!$verifyBalanceToAccount)
            return response()->json([
                'type' => 'error',
                'message' => 'Confira o valor para ser transferido por que o saldo está insuficiente.'
            ], 400);
        //  dd($request);
        //preenchendo array com os campos e valores para um lancamento
        try {
            //se for caixa interno não registra saida de valor
            $valueBalance = Monetary::money_real($request['value']);
            //Retirando o valor do saldo da conta bancaria          
            if ($request['idAccountEnd'] > 0) {
                $accountBank = AccountBank::findOrFail($request['idAccountEnd']);
                $accountBank->balance = $accountBank->balance - $valueBalance;
                $idaccountBank = $accountBank->id;
                $accountBank->save();
            }


            if ($request['idAccountEntry'] > 0) {
                $accountBank2 = AccountBank::findOrFail($request['idAccountEntry']);
                $accountBank2->balance = $accountBank2->balance + $valueBalance;
                $idaccountBank2 = $accountBank2->id;
                $accountBank2->save();
            }

            return response()->json([
                'type' => 'success',
                'id_bank_end' => $idaccountBank,
                'id_bank_entry' => $idaccountBank2
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'type' => 'error',
                'message' => 'Erro ao transferir valores ' . $th->getMessage()
            ], 400);
        }
    }

    /**
     * Monta os campos para gerar a string de registro de lançamento
     */
    static public function fieldsEntry($request, $type)
    {
        $user_id_company = 1;
        $user_id = 1;
        //PARA REGISTRAR DA CONTA BANCARIA NO LANÇAMENTO
        $bankEntries = isset($request['entries_bank']) ? $request['entries_bank'] : 0;
        $bank = [];
        $bank2 = [];
        $transaction_id = 1;
        $account = new AccountBank('Caixa Interno', 0);
        $bank['nameBank'] = $account->nameBank;
        $bank['number'] = $account->number;

        $account2 = new AccountBank('Caixa Interno', 0);
        $bank2['nameBank'] = $account2->nameBank;
        $bank2['number'] = $account2->number;
    
        //So PEGA AS INFO SE NÃO FOR CAIXA INTERNO
        if ($request['idAccountEnd'] > 0) {
            $account = self::getAccountBankAndTypeToCompany($user_id_company, $request['idAccountEnd']);
            //primeiro registro, mas o retorno é somente um registro de uma collection
            $bank['nameBank'] = $account[0]->nameBank;
            $bank['number'] = $account[0]->number;
            $bankEntries = $account[0]->id;
        }

        if ($request['idAccountEntry'] > 0) {
            $account2 = self::getAccountBankAndTypeToCompany($user_id_company, $request['idAccountEntry']);
            $bank2['nameBank'] = $account2[0]->nameBank;
            $bank2['number'] = $account2[0]->number;
            //FORÇANDO QNDO FOR CAIXA INTERNO, O VALOR FICAR 0;
            $bankEntries = $account2[0]->id;
        }

        // if ($request['idAccountEnd'] == 0) {
        //     $bankEntries = 0;
        // }

        $desc = '';
        $idAccountLaunch = 0;
        switch ($type) {
            case 'despesa':
                $desc = 'Transferência da conta nº ' . $bank['number'] . ' ' . $bank['nameBank'] . ' 
                para conta nº ' . $bank2['number'] . ' ' . $bank2['nameBank'];
                $idAccountLaunch = 57;
                //transferencia do banco para caixa interno
                if ($bank['number'] > 0 && $bank2['number'] == 0) {
                    $transaction_id = AccountBankRepository::BANK_TO_INTERNAL;
                }
                break;
            case 'receita':
                $desc = 'Trasnferência recebida de conta nº ' . $bank['number'] . ' ' . $bank['nameBank'];
                $idAccountLaunch = 56;
                //transferencia do caixa interno para conta bancaria
                if ($bank['number'] == 0 && $bank2['number'] > 0) {
                    $transaction_id = AccountBankRepository::INTERNAL_TO_BANK;
                }
                break;
            case 'transferencia':
                $desc = 'Trasnferência bancária entre caixas: '.
                $bank['number'] . ' ' . $bank['nameBank']. ' e '.
                $bank2['number'] . ' ' . $bank2['nameBank'];
                $idAccountLaunch = 58;
                //transferencia do caixa interno para conta bancaria
                if ($bank['number'] == 0 && $bank2['number'] > 0) {
                    $transaction_id = AccountBankRepository::INTERNAL_TO_BANK;
                }
                break;
        }


        //CASO SEJA CAIXA INTERNO TRANSFERINDO OU RECEBENDO TRANSFERENCIA
        if (empty($account2)) {
            $desc = 'Transferencia da conta ' . $bank['number'] . ' ' . $bank['nameBank'] . ' para o CAIXA INTERNO';
            $idAccountLaunch = 1;
        }

        $launch['entries_id_account'] = $idAccountLaunch;
        $launch['entries_description'] = $desc;
        $launch['entries_id_company'] = $user_id_company;
        $launch['entries_id_user'] = $user_id;
        $launch['entries_value'] = Monetary::money_real($request['value']);
        $launch['entries_date_launch'] = Carbon::now();
        $launch['transaction_id'] = $transaction_id;
        $launch['entries_bank'] = $bankEntries;
        return $launch;
    }

    /**
     * Retorna a conta e o saldoa atual
     */
    static public function verifyBalanceToAccount($request)
    {

        $balanceActual = 0; //saldo atual

        //VERIFICA SE É CAIXA INTERNO
        if ($request['idAccountEnd'] == 0) {
            //AJUSTA PARA A VARIAVEL O VALOR DO CAIXA INTERNO
            $balanceActual = Monetary::money_real($request['valueInternal']);
            //dump($balanceActual);      
        } else {
            $verify = AccountBank::findOrFail($request['idAccountEnd']);
            //RECEBENDO O VALOR ATUAL DA CONTA
            $balanceActual = $verify->balance;
        }
        $balanceToTransfer = Monetary::money_real($request['value']); //valor a transferir
        $comparation = (float) $balanceToTransfer <=> (float) $balanceActual;
        //Comparation = 0 = igual, -1 = menor, 1 = maior
        //se o valor do saldo da transferencia for maior que o saldo atual retorna false
        if ($comparation == 1)
            return false;

        return true;
    }

    static public function getAllAccountBankCompany($idCompany)
    {
        return AccountBank::where('company_id', $idCompany)->get();
    }

    private function transfer_between_accounts($idAccountEnd, $valueEnd, $idAccountEntry, $valueEntry)
    {

        dd($idAccountEnd);
    }

    static function create_register_launch($idAccountLaunch, $desc, $idCompany, $idUser, $value, $transaction_id)
    {
        $launch['entries_id_account'] = $idAccountLaunch;
        $launch['entries_description'] = $desc;
        $launch['entries_id_company'] = $idCompany;
        $launch['entries_id_user'] = $idUser;
        $launch['entries_value'] = Monetary::money_real($value);
        $launch['entries_date_launch'] = Carbon::now();
        $launch['transaction_id'] = $transaction_id;

        return $launch;
    }

    /**
     * Atualização de valor da conta, através de um lançamento
     */
    public function updateAccountToLauch($request)
    {
        try {
            //Instanciando Serviço
            $account = new AccountBankService(new AccountBank());
            //Buscando a conta
            $service = $account->getBankAndAccount($request['idBank'], $request['idNumberAccount'], $request['agencyAccountBa'])->first();
            //Formatando para o valor em moeda
            $valueBank = Monetary::money_real($request['valueLanchBank']);
            //Alterando o valor da conta
            if($request['typeTransaction'] == 'Receita') {
                $service->balance += (float) $valueBank;
            }else{
                $service->balance -= (float) $valueBank;
            }
            
            $service->save();//salvando os dados
            return response()->json(['message' => 'success', 'value' => $service->balance ], 200);
        } catch (\Exception $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 400], 400);
        }
    }


}