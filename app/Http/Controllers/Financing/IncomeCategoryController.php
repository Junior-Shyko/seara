<?php

declare(strict_types=1);

namespace App\Http\Controllers\Financing;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIncomeCategoryRequest;
use App\Http\Requests\UpdateIncomeCategoryRequest;
use App\Service\Core\Transactor\Transactor;
use App\Service\Financing\IncomeCategory\CreateIncomeCategory;
use App\Service\Financing\IncomeCategory\IncomeCategoryRepository;
use App\Traits\ActionTable;
use Carbon\Carbon;
use DateTime;
use DB;
use Throwable;
use Yajra\Datatables\Facades\Datatables;

class IncomeCategoryController extends Controller
{
    use ActionTable;

    /**
     * @var Transactor
     */
    private $transactor;

    public function __construct(Transactor $transactor)
    {
        $this->middleware('auth');
        $this->transactor = $transactor;
    }

    public function index()
    {
        return view('financing.income_category', [
            'title' => 'Categorias de Receita'
        ]);
    }

    public function store(StoreIncomeCategoryRequest $request, CreateIncomeCategory $createIncomeCategory)
    {
        try {
            $this->transactor->perform(function () use ($request, $createIncomeCategory) {
                $createIncomeCategory->execute($request->all());
            });
            return response()->json([
                'status' => 'success',
                'message' => 'Categoria salva com sucesso!'
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível salvar a categoria, tente novamente!'
            ]);
        }
    }

    public function show(string $id, IncomeCategoryRepository $repository)
    {
        $incomeCategory = $repository->find($id)
            ->jsonSerialize();
        return response()->json($incomeCategory);
    }

    public function update(
        string $id,
        UpdateIncomeCategoryRequest $request,
        IncomeCategoryRepository $repository
    ) {
        try {
            $repository->update($id, $request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Categoria atualizada com sucesso'
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível atualizar a categoria, tente novamente'
            ]);
        }
    }

    public function destroy(string $id, IncomeCategoryRepository $repository)
    {
        $repository->update($id, [
            'archived_at' => new DateTime(),
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Categoria arquivada com sucesso'
        ]);
    }

    public function dataTable()
    {
        $query = DB::table('income_category')
            ->select()
            ->whereNull('archived_at');

        $datatable = Datatables::of($query);

        $datatable->addColumn('action', function ($incomeCategory) {
            return $this->actionButtons($incomeCategory->id, [
                ['Editar categoria', 'editIncomeCategory', 'fa fa-pencil'],
                ['Arquivar categoria', 'archiveIncomeCategory', 'fa fa-ban', 'btn-danger']
            ]);
        });

        $datatable->editColumn(
            'created_at',
            function($account) {
                $created_at = new Carbon($account->created_at);
                return $created_at->format('d/m/Y à\s H:i:s');
            }
        );

        return $datatable->make(true);
    }
}
