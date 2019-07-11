<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings ;

class SettingsController extends Controller
{
    public function  index(){

        return view('settings.settings_index');
    }

    public function  create(){

        return view('settings.settings_create');
    }




    public function store(Request $request){

        $this->validate(request(), [
            'empl_type' => 'required',
            'des_id' => 'required',

        ]);

        $employee =new Settings;
        $employee->empl_type=$request->empl_type;
        $employee->des_id=$request->des_id;

        $employee->save();
        return redirect()->route('setting');

    }
}
