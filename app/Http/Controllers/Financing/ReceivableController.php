<?php

declare(strict_types=1);

namespace App\Http\Controllers\Financing;

use App\Account;
use App\Http\Controllers\Controller;
use App\Http\Requests\PayReceivableRequest;
use App\Http\Requests\StoreReceivableRequest;
use App\Http\Requests\UpdateReceivableRequest;
use App\IncomeCategory;
use App\Models\Company;
use App\Receivable;
use App\Service\Core\Transformation\ArrayTransformer;
use App\Service\Core\Transformation\Operations\FloatToMoney;
use App\Service\Core\Transformation\Operations\UsaDateToBr;
use App\Service\Financing\IncomeCategory\IncomeCategoryRepository;
use App\Service\Financing\Receivable\CreateReceivable;
use App\Service\Financing\Receivable\ReceivableRepository;
use App\Traits\ActionTable;
use Carbon\Carbon;
use Datatables;
use DB;
use Throwable;

class ReceivableController extends Controller
{
    use ActionTable;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(IncomeCategoryRepository $incomeCategoryRepository)
    {
        return view('financing.receivable.index', [
            'title' => 'Contas a Receber',
            'incomeCategories' => IncomeCategory::all(),
            'accounts' => Account::all(),
            'companies' => Company::all(),
        ]);
    }

    public function store(
        StoreReceivableRequest $request,
        CreateReceivable $createReceivable
    ) {
        try {
            $createReceivable->execute($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Conta a receber salva com sucesso'
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível salvar, tente novamente'
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            Receivable::destroy($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Conta removida com sucesso!'
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível remover essa conta'
            ], 500);
        }
    }

    public function show(string $id, ReceivableRepository $repository, ArrayTransformer $transformer)
    {
        $receivable = $repository->find($id)
            ->jsonSerialize();
        $receivable = $transformer->transform($receivable, [
            'due_date' => [new UsaDateToBr()],
            'amount' => [new FloatToMoney()]
        ]);
        return response()->json($receivable);
    }

    public function update(string $id, UpdateReceivableRequest $request, ReceivableRepository $repository)
    {
        try {
            $repository->update($id, $request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Conta salva com sucesso'
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível atualizar a conta'
            ]);
        }
    }

    public function payReceivable(
        string $id,
        PayReceivableRequest $request,
        ReceivableRepository $repository
    ) {
        try {
            $repository->update($id, $request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Conta efetivada com sucesso'
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível efetivar a conta'
            ]);
        }
    }

    public function dataTable()
    {
        $now = Carbon::now();

        $query = DB::table('receivable')
            ->select([
                'receivable.id',
                'receivable.due_date',
                'receivable.payment_date',
                'receivable.description',
                'income_category.name as category',
                'account.name as account',
                'receivable.amount',
                'companies.company_fantasy as customer',
                'receivable.sequence_number',
                'receivable.sequence_count',
            ])
            ->join(
                'income_category',
                'receivable.income_category_id',
                '=',
                'income_category.id'
            )
            ->join(
                'account',
                'receivable.account_id',
                '=',
                'account.id'
            )
            ->leftJoin(
                'companies',
                'receivable.company_id',
                'companies.company_id'
            )
            ->whereNull('payment_date')
            ->where(function ($query) use ($now) {
                $query
                    ->whereDate('due_date', '<=', $now->format('Y-m-d'))
                    ->orWhere(function ($query) use ($now) {
                        $query->whereMonth('due_date', '<=', (int) $now->format('t'))
                            ->whereYear('due_date', '<=', (int) $now->format('Y'));
                    });
                ;
            })
        ;

        $dataTable = Datatables::of($query);

        $dataTable->addColumn('action', function ($receivable) {
            return $this->actionButtons($receivable->id, [
                ['Efetivar conta', 'payReceivable', 'fa fa-check'],
                ['Editar', 'editReceivable', 'fa fa-pencil'],
                ['Remover', 'deleteReceivable', 'fa fa-ban', 'btn-danger'],
            ]);
        });

        $dataTable->editColumn('due_date', function ($receivable) {
            return Carbon::createFromFormat('Y-m-d', $receivable->due_date)
                ->format('d/m/Y');
        });

        $dataTable->editColumn('amount', function ($receivable) {
            return number_format(
                $receivable->amount,
                2,
                ',',
                '.'
            );
        });

        $dataTable->editColumn('description', function ($receivable) {
            if (! $receivable->sequence_number) {
                return $receivable->description;
            }

            return sprintf(
                '%s (%d/%d)',
                $receivable->description,
                $receivable->sequence_number,
                $receivable->sequence_count
            );
        });

        return $dataTable->make(true);
    }
}
