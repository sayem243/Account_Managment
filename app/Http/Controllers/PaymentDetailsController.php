<?php

namespace App\Http\Controllers;

use App\Ammendment;
use App\Payment;
use App\Payment_details;
use App\Project;
use Illuminate\Http\Request;
use PDF;

class PaymentDetailsController extends Controller
{
    Public function index($id){
        $payment=Payment::find($id);
        return view('payment_details.index',['payment'=>$payment]);
    }

    public function paymentPDF($id){
        $payment=Payment::find($id);
        $pdf = PDF::loadView('payment.pdf_view', compact('payment'));
        return $pdf->stream("invoice.pdf",array("Attachment" => false));
     }

    public function printpdf($id){
        $payment=Payment::find($id);
        return view('payment.payment-print',compact('payment'));
    }

    public function approved($id){
        $amendment=Ammendment::find($id);
        $amendment->status=2;
        $amendment->save();
        return response()->json(['success'=>'Got Simple Ajax Request.','status'=>200]);
    }

    public function delete($id){
        $payment=Payment_details::find($id);
        $payment->delete();
        return redirect()->route('payment');
    }

}
