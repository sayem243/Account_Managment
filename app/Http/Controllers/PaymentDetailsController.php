<?php

namespace App\Http\Controllers;

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


    public function printPDF($id){
        $payment=Payment::find($id);

        $pdf = PDF::loadView('payment.pdf_view', compact('payment'));
        return $pdf->download('invoice.pdf');

    }


//    public function view($id)
//    {
//        $document_name = Payment_details::find($id);
//         if($document_name){
//             $file =  base_path().'/public/uploads/documents/'.$document_name;
//                if (file_exists($file)){
//
//                    $ext =File::extension($file);
//
//                    if($ext=='pdf'){
//                        $content_types='application/pdf';
//                    }elseif ($ext=='doc') {
//                        $content_types='application/msword';
//                    }elseif ($ext=='docx') {
//                        $content_types='application/vnd.openxmlformats-officedocument.wordprocessingml.document';
//                    }elseif ($ext=='xls') {
//                        $content_types='application/vnd.ms-excel';
//                    }elseif ($ext=='xlsx') {
//                        $content_types='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
//                    }elseif ($ext=='txt') {
//                        $content_types='application/octet-stream';
//                    }
//
//                    return response(file_get_contents($file),200)
//                        ->header('Content-Type',$content_types);
//
//                }else{
//                    exit('Requested file does not exist on our server!');
//                }
//
//           }else{
//        exit('Invalid Request');
//    }
//    }




}
