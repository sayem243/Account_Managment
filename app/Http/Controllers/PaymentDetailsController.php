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
        $amendment=Ammendment::find($id);
        return view('payment_details.index',['payment'=>$payment,'amendment'=>$amendment]);
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

/*    public function delete($id){
        $payment=Payment_details::find($id);
        $payment->delete();
        return redirect()->route('payment');
    }*/

    public function delete($id)
    {
        $payment =Payment_details::where('id',$id)->first();

        if ($payment != null) {
            $payment->delete();
            return redirect()->route('payment')->with(['message'=> 'Successfully deleted!!']);
        }

        return redirect()->route('payment')->with(['message'=> 'Wrong ID!!']);
    }

    public function deleteAjax($id){
        $paymentDetails=Payment_details::find($id);
        $paymentDetails->delete();
        $paymentId = $paymentDetails->payment_id;
        $payment=Payment::find($paymentId);
        $payment->total_paid_amount = $payment->getTotalPaidAmount();
        $payment->save();
        return response()->json(['success'=>'Record has been deleted.','status'=>200]);
    }






















//    public function delete($id){
//
//        $payment = Payment_details::where('id',$id)->first();
//        if($payment != null){
//            $payment->delete();
//        }
//        return redirect()->route('payment');
//    }



}
