<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Yajra\Datatables\Datatables;
use App\Models\ReceiptCompany;
use Yajra\Datatables\Facades\Datatables;

class ReceiptDatatablesController extends Controller
{
    //
    public function getIndex()
    {
      return view('receipt-company.index');
    }

    public function anyData()
    {
      $receipts = ReceiptCompany::select(
        [
          'receipt_id',
          'receipt_received_from',
          'receipt_reference',
          'receipt_value',
          'receipt_local',
          'receipt_date'
        ]
      );

      return Datatables::of($receipts)
      ->addColumn(
        'action',
        function ($receipt) {
          return $this->actions($receipt->receipt_id);
        })
        ->make(true);
      }

      private function actions($id)
      {
        return $this->actionEdit($id)
              .$this->actionClone($id)
              .$this->actionDelete($id)
              .$this->actionDownload($id, 1)
              .$this->actionDownload($id, 2);
      }

    private function actionEdit($id)
    {
      return "<button class='btn btn-primary btn-xs' data-toggle='tooltip' data-placement='top' data-original-title='Editar Recibo' onclick='editReceipt( {$id} )'> <i class='fa fa-pencil'></i> </button>";
    }

    private function actionClone($id)
    {
      return "<button class='btn btn-primary btn-xs' data-toggle='tooltip' data-placement='top' data-original-title='Clonar Recibo' onclick='cloneReceipt( {$id} )'> <i class='fa fa-clone'></i> </button>";
    }

    private function actionDelete($id)
    {
      return "<button class='btn btn-danger btn-xs' data-toggle='tooltip' data-placement='top' data-original-title='Excluir Recibo' onclick='deleteReceipt( {$id} )'> <i class='fa fa-trash-o'></i> </button>";
    }

    private function actionDownload($id, $vias)
    {
      $url = ("receipt-company/{$id}/pdf?vias={$vias}");
      return "<a href='{$url}' target='_blank' class='btn btn-info btn-xs'><i class='fa fa-print'></i> 1 Via </a>";
    }
}
