<?php

namespace Seara\Repository;

use Seara\Entry;
use Carbon\Carbon;
use Seara\FileLaunch;
use Seara\AccountBank;
use Seara\FunctionGeneral;
use Seara\SettingsBox;
use Seara\AccountLaunch;
use Seara\Seara\Monetary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

class EntryRepository
{

    static public function deleteFile($id)
    {

        //exclusao dos arquivos, caso tenha
        $files = FileLaunch::where('file_launches_id_entry', '=', $id)->get();

        foreach ($files as $key => $value) {
            FileLaunch::where('id', $value->id)->delete();
        }
    }

    static public function deleteLaunchBank($idEntry)
    {
        $entry = Entry::where('entries_id', $idEntry)->first();
        if ($entry->entries_bank == 0 || !empty($entry->entries_bank) && is_null($entry->entries_parent)) {
            $account_bank = AccountBank::find($entry->entries_bank); //instanciando o conta
            if (!is_null($account_bank)) {
                $valueBank = Monetary::money_real($entry->entries_value); //formatando o valor
                $account_bank->balance  -= (float) $valueBank; //reduzindo o valor da conta
                $account_bank->save(); //salvando os dados
            }
        }

        return $entry;
    }

    static function typeAccount($id)
    {
        return AccountLaunch::join('account_types', 'account_launches.accountlaunch_type', '=', 'account_types.id')
            ->where('account_launches.id', '=', $id)
            ->select('account_types.account_types_name')->first();
    }

    /**
     * Essa funcao altera o valor da conta bancaria
     * dependendo o tipo do lançamento
     *
     * @param [string] $type
     * @param Entry $entry
     * @return \Illuminate\Http\JsonResponse
     */
    static function alterBalanceEntry($type, Entry $entry): \Illuminate\Http\JsonResponse
    {
        try {
            switch ($type) {
                case 'Receita':
                    $acc_bank = AccountBank::find($entry->entries_bank);
                    $acc_bank->balance = ($acc_bank->balance - $entry->entries_value); //remove valor da conta bancaria
                    $acc_bank->save();
                    break;
                case 'Despesa':
                    $accountBank = AccountBank::find($entry->entries_bank);
                    $accountBank->balance += $entry->entries_value; //adiciona valor da conta bancaria
                    $accountBank->save();
                    break;
            }
            return response()->json(['message' => 'success', 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 400], 400);
        }
    }

    /**
     * Retorna a informação se existe algum registro lançado no caixa no mes respectivo
     *
     * @param [type] $date
     * @return void
     */
    static public function getBoxMonthOpenClose()
    {
        setlocale(LC_TIME, 'pt_BR');
        $month = Carbon::now();

        $boxOpen = SettingsBox::where([
            'id_company' => Auth::user()->user_id_company,
            'month' => $month->month,
            'year' => $month->year
        ])->first();
        return $boxOpen;
    }

    static function verifyExistEntryMonthAndOpenBox($date)
    {
        //recebe a data em formato USA
        $month = Carbon::parse($date)->month;
        //id da igreja
        $idCompany = Auth::user()->user_id_company;
        //verifica se dentro do mes do lançamento tem algum retgistro
        $entry = Entry::whereMonth('entries_date_launch', $month)
            ->where('entries_id_company', $idCompany)
            ->get();


        //Retorna a quantidade
        // return count($entry);
        $boxOpen = SettingsBoxRepository::getExistBoxMonth($date, $idCompany);
        // dump($boxOpen);
        // dump(count($entry));
        // dd($entry);
        if ($boxOpen == false && count($entry) == 0) {
            $time = Carbon::now();

            $request['date_open'] = $date . ' ' . $time->format('H:i:s');

            //Se false é por que não tem caixa no mes respectivo
            $monthYear = SettingsBoxRepository::getMonthYear($request['date_open']);
            $request['month']           = $monthYear['month'];
            $request['year']            = $monthYear['year'];
            $request['id_company']      = $idCompany;
            $request['id_user_open']    = Auth::user()->id;
            $request['slug']            = 'open';
            // dump($boxOpen);
            // dd($request);
            try {
                SettingsBox::create($request);
                return true;
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        return false;
    }

    static public function verifyLastDayMounth(Request $request): JsonResponse
    {
        $dateString = $request['entries_date_launch']; // Ex: "20/08/2025"

       try {
            // 1) Validar se a data é válida no formato "d/m/y" (dois últimos dígitos do ano)
            $date = Carbon::createFromFormat('d/m/y', $dateString);
            if ($date === false) {
                return response()->json([
                    'error' => 'Data inválida. Formato esperado: dd/mm/yy.'
                ], 422);
            }

            // 2) Pegar o último dia do mês atual
            $lastDayOfMonth = Carbon::now()->endOfMonth();

            // Data mínima permitida
            $minDate = Carbon::create(2022, 1, 1); // 01/01/2022
            if ($date->lt($minDate)) {
                return response()->json([
                    'error' => 'A data não pode ser anterior a ' . $minDate->format('d/m/Y')
                ], 422);
            }

            // 3) Comparar se a data é maior que o último dia do mês atual
            if ($date->gt($lastDayOfMonth)) {
                return response()->json([
                    'error' => 'A data não pode ser maior que ' . $lastDayOfMonth->format('d/m/Y')
                ], 422);
            }

            // Retorno de sucesso
            return response()->json([
                'message' => 'Data válida',
                'date' => $date->format('d/m/Y'), // Formatar a data para exibição
                'status' => 200
            ]);
        } catch (\Exception $e) {
            // Capturar erro caso a data seja inválida ou o formato esteja incorreto
            return response()->json([
                'error' => 'Data inválida. Formato esperado: dd/mm/yy.'
            ], 422);
        }
    }

    static public function getFiles(Request $request)
    {
        return Entry::where([
            'entries_description' => $request->desc,
            'entries_value' => FunctionGeneral::converterStringToFloat($request->value),
            'entries_date_launch' => FunctionGeneral::DataBRtoMySQL($request->date),
            'entries_id_company' => (int) $request->comp
        ])->get();
    }
}
