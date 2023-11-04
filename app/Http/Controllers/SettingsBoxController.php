<?php

namespace Seara\Http\Controllers;

use Carbon\Carbon;
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
        // dump($request->all());
        $time = Carbon::now();
        $dtOpen = FunctionGeneral::DataBRtoMySQL($request['data_open']);
        $request['data_open'] = $dtOpen.' '.$time->format('H:i:s');

        //Se false é por que não tem caixa no mes respectivo
        $request['month'] = SettingsBoxRepository::getMonthBox($request['data_open']);
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
    public function update(Request $request, SettingsBox $settingsBox, $id)
    {
        dump($request->all());
        dump($settingsBox);
        $request['data_close'] = Carbon::parse($request['data_close'])->format('Y-m-d H:i:s');
        $request['slug'] = 'close';
        $request['id_user_close'] = Auth::user()->id;
        try {
            $box = $settingsBox->find($id)->update($request->all());
            dump($box);
        } catch (\Throwable $th) {
            throw $th;
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
            'data_open',
            function($box) {
                $created_at = new Carbon($box->data_open);
                return $created_at->format('d/m/Y à\s H:i:s');
            }
        );
        
        $dataTable->editColumn(
            'data_close',
            function($box) {
                if($box->data_close !== null)
                {
                    $created_at = new Carbon($box->created_at);
                    return $created_at->format('d/m/Y à\s H:i:s');
                }               
            }
        );
        
        $dataTable->editColumn(
            'id_user_open',
            function($box) {
               
                return $box->name;
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
            )
        ]);
    }
}
