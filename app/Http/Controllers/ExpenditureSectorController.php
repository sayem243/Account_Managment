<?php

namespace App\Http\Controllers;

use App\ExpenditureSector;
use Illuminate\Http\Request;

class ExpenditureSectorController extends Controller
{
   function __construct()
    {
        $this->middleware('permission:expenditure-sector-create', ['only' => ['create','store']]);
        $this->middleware('permission:expenditure-sector-list', ['only' => ['index']]);
        $this->middleware('permission:expenditure-sector-edit',['only'=>['edit','update']]);
        $this->middleware('permission:expenditure-sector-delete',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenditureSectors=ExpenditureSector::all()->sortBy('name');
        return view('expenditure_sector.index',['expenditureSectors'=>$expenditureSectors]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expenditure_sector.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' =>  ['required', 'unique:expenditure_sectors']
        ]);

        $expenditureSector =new ExpenditureSector();
        $expenditureSector->name=$request->name;
        $expenditureSector->save();

        return redirect()->route('expenditure_sector_index')->with('success', 'Expenditure sector has been successfully Created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expenditureSector =  ExpenditureSector::find($id);
        return view('expenditure_sector.edit')->with('expenditureSector' ,$expenditureSector);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "name" => 'required|unique:expenditure_sectors,name,'.$id
        ]);

        $expenditureSector = ExpenditureSector::find($id);

        $expenditureSector->name=$request->name;
        $expenditureSector->save();

        return redirect()->route('expenditure_sector_index')->with('success', 'Expenditure sector has been successfully Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExpenditureSector  $expenditureSector
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expenditure=ExpenditureSector::find($id);

        $expenditure->delete();

        return redirect()->route('expenditure_sector_index');
    }
}
