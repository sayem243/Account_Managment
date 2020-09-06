<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
//        $this->middleware('permission:comp_profile', ['only' => ['index','create','store']]);

    }

    public function create(){

        return view('client.add');
    }

    public function index(){

        $clients=Client::withTrashed()->get();
        return view('client.index')->with('clients' ,$clients);
    }

    public function store(Request $request){

        //dd('ok');

        $this->validate($request, [
            'name' => ['required'],
        ]);


        $client =new Client();
        $client->name=$request->name;
        $client->phone=$request->phone;
        $client->address=$request->address;

        $client->save();
        return redirect()->route('client_index');


    }

    public  function view($id){

        $client=Client::find($id);
        return view('client.view')->with('client' ,$client);
    }

    public  function edit($id){

        $client=Client::find($id);
        return view('client.edit')->with('client',$client);

    }


    public  function update(Request $request,$id){

        $this->validate($request, [
            'name' => ['required'],
        ]);

        $client=Client::find($id);

        //$client =new Client;
        $client->name=$request->name;
        $client->phone=$request->phone;
        $client->address=$request->address;

        $client->save();
        return redirect()->route('client_index');

    }


    public function delete($id){

        $client=Client::find($id);

        if(auth()->user()->hasRole('superadmin')){
            $client->delete();
            return redirect()->route('client_index')->with('success','Client deleted successfully.');
        }

        return redirect()->route('client_index')->with('error','Error! This are not permitted.');

    }

    public function clientRestore($id){
        Client::withTrashed()
            ->where('id', $id)
            ->restore();
        return redirect()->route('client_index')->with('success','Client restored successfully');
    }




}
