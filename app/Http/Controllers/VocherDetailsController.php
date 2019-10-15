<?php

namespace App\Http\Controllers;

use App\Vocher;
use App\Vocher_details;
//use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use PDF;

class VocherDetailsController extends Controller
{
    public function index($id){
        $details=Vocher::find($id);
        return view('voucher_details.index',['details'=>$details]);
    }

    public  function printPDF($id){
        $details=Vocher::find($id);

        $pdf=PDF::loadView('voucher_details.voucher-pdf',compact('details'));
        return $pdf->stream("voucher.pdf", array("Attachment" => false));
    }

    public function prnpriview($id)
    {
        $details=Vocher::find($id);

        return view('voucher_details.voucher-print',compact('details'));
    }


}

