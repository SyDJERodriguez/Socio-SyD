<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LogRegistersExport;
use App\Http\Controllers\Controller;
use App\LogRegisters;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class LogRegistersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    //$errors = LogRegisters::all();

	    return view('Admin.LogRegisters.index');
    }

    public function datatable(Request $request) {
    	$data = LogRegisters::all();

    	return DataTables::of($data)
		    ->addColumn('detail', function ($row){
		    	return "<button class='btn btn-sm btn-success btn-detail' data-form='".$row['form_data']."'> Ver Datos</button>";
		    })
		    ->rawColumns(['detail'])
		    ->make(true);
    }

	public function export_all(){
    	return Excel::download(new LogRegistersExport, 'ClubDarAlertasDelSistema.xlsx');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LogRegisters  $logRegisters
     * @return \Illuminate\Http\Response
     */
    public function show(LogRegisters $logRegisters)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LogRegisters  $logRegisters
     * @return \Illuminate\Http\Response
     */
    public function edit(LogRegisters $logRegisters)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LogRegisters  $logRegisters
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LogRegisters $logRegisters)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LogRegisters  $logRegisters
     * @return \Illuminate\Http\Response
     */
    public function destroy(LogRegisters $logRegisters)
    {
        //
    }
}
