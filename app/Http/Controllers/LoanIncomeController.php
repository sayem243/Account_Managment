<?php

namespace App\Http\Controllers;

use App\CashTransaction;
use App\CheckRegistry;
use App\Client;
use App\Company;
use App\ExpenditureSector;
use App\Income;
use App\Loan;
use App\Payment;
use App\PaymentSettlement;
use App\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanIncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('auth');
    }

    public function createLoanAndIncome(Request $request){

        $type = $request->request->get('type');

        $companies= Company::all();
        $arrayCompanies=array();
        foreach ($companies as $company){
            $arrayCompanies[]=array('id'=>$company->id,'name'=>$company->name);
        }
        array_multisort(array_map(function($element) {
            return $element['name'];
        }, $arrayCompanies), SORT_ASC, $arrayCompanies);

        $projects = Project::orderBy('p_name', 'ASC')->get();
        $users = User::orderBy('name', 'ASC')->get();
        $clients = Client::orderBy('name', 'ASC')->get();
        $expenditureSectors = ExpenditureSector::all()->sortBy('name');

        return view('loan_income.add',['expenditureSectors'=>$expenditureSectors ,'companies'=>$arrayCompanies ,'projects'=>$projects, 'users'=>$users, 'clients'=>$clients, 'type'=>$type]);
    }

}
