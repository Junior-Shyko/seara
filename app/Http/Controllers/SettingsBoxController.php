<?php

namespace Seara\Http\Controllers;

use Carbon\Carbon;
use Seara\Models\User;
use Seara\SettingsBox;
use Seara\FunctionGeneral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Seara\Repository\SettingsBoxRepository;
use Seara\Http\Requests\StoreSettinsRequest;

class SettingsBoxController extends Controller
{
    use \Seara\Traits\ActionTable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        setlocale(LC_TIME, 'pt_BR');
        $dateNow = Carbon::now();
        $boxOpen = SettingsBoxRepository::getBoxOpenClose($dateNow, Auth::user()->user_id_company);
        return view('setting_box.index', compact('boxOpen'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dt = Carbon::parse($request['date_open']);
        if($dt < date('2000-01-01'))
        {
            dump('mostrar um alerta');
        }
        dd($dt);
        // dump($request->all());
        $time = Carbon::now();
        $dtOpen = FunctionGeneral::DataBRtoMySQL($request['date_open']);
        $request['date_open'] = $dtOpen.' '.$time->format('H:i:s');

        //Se false é por que não tem caixa no mes respectivo
        $monthYear = SettingsBoxRepository::getMonthYear($request['date_open']);
        $request['month']   = $monthYear['month'];
        $request['year']    = $monthYear['year'];
        $request['id_company'] = Auth::user()->user_id_company;
        $boxOpen = SettingsBoxRepository::getBoxOpenClose($dtOpen, Auth::user()->user_id_company);
        $request['slug'] = 'open';
        if(!$boxOpen)
        {
            try {
                SettingsBox::create($request->all());
                return back()->with(['success' => 'Caixa aberto com sucesso']);
              } catch (\Throwable $th) {
               throw $th;
              }
        }else{
            return back()->with(['error' => 'Já tem caixa aberto no mes da data escolhida']);
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \Seara\SettingsBox  $settingsBox
     * @return \Illuminate\Http\Response
     */
    public function show(SettingsBox $settingsBox)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Seara\SettingsBox  $settingsBox
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $setBox = SettingsBox::join('users', 'settings_boxes.id_user_open', '=', 'users.id')
        ->select('users.*', 'settings_boxes.*')    
        ->where(
            'settings_boxes.id' ,'=', $id
        )->first();
        $role = $user->getRoleNames()->first();
        if($role == 'superAdmin' || ($setBox->id_company == Auth::user()->user_id_company) )
        {
            return view('setting_box.edit', compact('setBox'));
        }else{
            return back()->with(['error' => 'Permissão Negada']);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Seara\SettingsBox  $settingsBox
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $time = Carbon::now();
        $dtOpen = FunctionGeneral::DataBRtoMySQL($request['date_open']);
        $request['date_open'] = $dtOpen.' '.$time->format('H:i:s');
        //Para data do fechamento preenchida
        if(!is_null($request['date_close']))
        {
            $request['date_close'] = Carbon::parse($request['date_close'])->format('Y-m-d H:i:s');
            $request['slug'] = 'close';
            $request['id_user_close'] = Auth::user()->id;
        }
        try {
            $box = SettingsBox::find($id);
            $box->update($request->all());
            return response()->json(['message' => 'Caixa alterado com sucesso', 'status' => 200], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ocorreu um erro inesperado.', 'status' => 400], 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Seara\SettingsBox  $settingsBox
     * @return \Illuminate\Http\Response
     */
    public function destroy(SettingsBox $settingsBox)
    {
        //
    }

    public function dataTable()
    {
        $boxOpen = SettingsBox::join('users', 'settings_boxes.id_user_open', '=', 'users.id')
        // ->join('users', 'settings_boxes.id_user_close', '=','users.id')
        ->select('users.*', 'settings_boxes.*')    
        ->where(
            'id_company' ,'=', Auth::user()->user_id_company
        )->get();

        $dataTable = DataTables::of($boxOpen);
        $dataTable->addColumn(
            'action',
            function($box) {
                return $this->actions($box->id);
            }
        );
        $dataTable->editColumn(
            'date_open',
            function($box) {
                $created_at = new Carbon($box->date_open);
                return $created_at->format('d/m/Y à\s H:i:s');
            }
        );
        $dataTable->editColumn(
            'month',
            function($box) {
               return SettingsBoxRepository::getMonthToNumner($box->month);
            }
        );
        
        $dataTable->editColumn(
            'date_close',
            function($box) {
                if($box->date_close !== null)
                {
                    $created_at = new Carbon($box->created_at);
                    return $created_at->format('d/m/Y à\s H:i:s');
                }
                return '--';        
            }
        );
        
        $dataTable->editColumn(
            'id_user_open',
            function($box) {
               
                return $box->name;
            }
        );

        $dataTable->editColumn(
            'id_user_close',
            function($box) {
                if($box->id_user_close > 0){
                    return User::find($box->id_user_close)->name;
                }
               return '--';
            }
        );

        return $dataTable->make(true);
    }

    private function actions($id)
    {
        return implode("", [
            $this->actionButton(
                $id,
                'Editar Caixa',
                'editBoxOpenClose',
                'fa-pencil'
            ),
            $this->actionButton(
                $id,
                'Fechar Caixa',
                'editBoxOpenClose',
                'fa-times-circle-o',
                'btn-danger'
            )
        ]);
    }
}
