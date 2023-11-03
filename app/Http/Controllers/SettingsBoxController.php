<?php

namespace Seara\Http\Controllers;

use Carbon\Carbon;
use Seara\SettingsBox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
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
        $month = Carbon::now();
        $boxOpen = SettingsBox::where([
            'id_company' => Auth::user()->id,
            'month' => $month->localeMonth
        ])->get();
 
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
        $request['data_open'] = $request['data_open'] .' '.$time->format('H:i:s');
        $dtOpen = Carbon::parse($request['data_open'])->format('Y-m-d H:i:s');
        $request['data_open'] = $dtOpen;
        
        $month = Carbon::parse($request['data_open'])->localeMonth;
        $request['month'] = $month;
        $request['id_company'] = Auth::user()->user_id_company;

        $boxOpen = SettingsBox::where([
            'id_company' => Auth::user()->id,
            'month' => $month
        ])->get();
          
        if(count($boxOpen) == 0)
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
    public function edit(SettingsBox $settingsBox)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Seara\SettingsBox  $settingsBox
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SettingsBox $settingsBox)
    {
        //
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
