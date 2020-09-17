<?php

namespace App\Http\Controllers;

use App\Invoices;
use App\Orders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class InvoicesController extends Controller {
    
//    public function invoiceToPDF() {
//        $invoiceid = 1;
//        $pdf = \PDF::loadView('invoicetopdf',['invoiceid' => $invoiceid]);
//        return $pdf->stream();
//        #return $pdf->download($invoicecompany.'-'.$invoicenumber.'.pdf');
//        #$pdf->save($invoicecompany.'-'.$invoicenumber.'.pdf');
//        #return redirect()->back();
//    }
    
    
    
    public function updateInvoice($invoiceid) {
        if(\Auth::user()) {
            return view('invoice_update', ['invoiceid' => $invoiceid]);
        } else {
            return redirect('/login');
        }
    }    
        
    public function updateInvoicePaid(Request $request) {
        if(\Auth::user()) {
            $data = $request->all();
            $g = new Invoices();    
            $g->updateInvoicePaid($data);
            return view('invoices_filters');
        } else {
            return redirect('/login');
        }     
    }
    public function searchInvoices(Request $request) {
        if(\Auth::user()) {    
            $data = $request->all();
            $g = new Invoices();
            $data1 = null;
            
            if((empty($data['invoice_id'])) && (empty($data['date'])) && (empty($data['company_id'])) && (empty($data['customer_id']))) {
                return view('invoices_filters2')->withErrors('НЕ СТЕ ВЪВЕЛИ ДАННИ ЗА ТЪРСЕНЕ !');
            } else {
                if(!empty($data['invoice_id'])) {
                    $data1 = $g->getInvoicesByNumber($data['invoice_id']);
                    return view('invoices_filters2', ['data1' => $data1]);
                }
                if(!empty($data['date'])) {
                    $data1 = $g->getInvoicesByDate($data['date']);
                    return view('invoices_filters2', ['data1' => $data1]);

                }
                if(!empty($data['company_id'])) {
                    $companytoexplode = $data['company_id'];
                    $companyarr = explode(" -", $companytoexplode, 2);
                    $companyid = $companyarr[0];
                    $data1 = $g->getInvoicesByCompany($companyid);
                    return view('invoices_filters2', ['data1' => $data1, 'company_id' => $companyid]);
                }
                if(!empty($data['customer_id'])) {
                    $customertoexplode = $data['customer_id'];
                    $customerarr = explode(" -", $customertoexplode, 2);
                    $customerid = $customerarr[0];
                    $data1 = $g->getInvoicesByCustomer($customerid);
                    return view('invoices_filters2', ['data1' => $data1, 'customer_id' => $customerid]);
                }
            }
        } else {
            return redirect('/login');
        }
    }
    
    
    
    public function getInvoices() {
        if(\Auth::user()) {
            return view('invoices_filters');
        } else {
            return redirect('/login');
        }
    }
    
    public function getNonPaid() {
        if(\Auth::user()) {
            return view('invoices_nonpaid');
        } else {
            return redirect('/login');
        }
    }
    
    
    public function getInvoice($invoiceid) {
        if(\Auth::user()) {
            return view('invoice', ['invoiceid' => $invoiceid]);
        } else {
            return redirect('/login');
        }
    }
    public function newInvoice(Request $request) {
        if(\Auth::user()) {
            $g = new Invoices();
            $getOwnCompanies = $g->getOwnComapnies();
            $data = $request->all();
            $orderid = $data['orderid'];
            $invoicetotal = $data['invoicetotal'];
            $general_company_id = $data['general_company_id'];
            $general_company_name = $data['general_company_name'];
            $general_company_number = $data['general_company_number'];
            $general_company_address = $data['general_company_address'];
            $general_company_owner = $data['general_company_owner'];
            $orders_invoice_tax = $data['orders_invoice_tax'];
            $o = new Orders();
            $o->closeOrder($orderid);
            if($general_company_id != 0) {
            return view('invoicenew', ['getOwnCompanies' => $getOwnCompanies,
                                       'orderid' => $orderid,
                                       'invoicetotal' => $invoicetotal,
                                       'companyid' =>$general_company_id,
                                       'general_company_name' => $general_company_name,
                                       'general_company_number' => $general_company_number,
                                       'general_company_address' => $general_company_address,
                                       'general_company_owner' => $general_company_owner,
                                       'orders_invoice_tax' => $orders_invoice_tax]);
            } else {
                return view('invoice_new_to_customer',[
                            'getOwnCompanies' => $getOwnCompanies,
                            'orderid' => $orderid,
                            'invoicetotal' => $invoicetotal,
                            'companyid' => 0,
                            'general_company_owner' => ' ',
                            'general_customer_id' => $data['general_customer_id'],
                            'general_customer_names' => $data['general_customer_names'],
                            'orders_invoice_tax' => $orders_invoice_tax]
                            );
            }
        } else {
            return redirect('/login');
        }
    }
    public function getInvoicesNumbers(Request $request) { 
        if(\Auth::user()) {
            $data = $request->all();
            $now = date('Y-m-d');
		  if(!empty($data['general_customer_id'])) {
			$customerid = $data['general_customer_id'];
		   } else { 
			$customerid = 0;
		   }
            return view('invoicesnumbers', 
                    ['owncompanyid' => $data['general_owncompany_id'],
                     'companyid' => $data['general_company_id'],
                     'orderid' => $data['orderid'],
                     'invoicetotal' => $data['invoicetotal'],
                     'owner' => $owner = $data['owner'],
                     'general_customer_id' => $customerid,
                     'orders_invoice_tax' => $data['orders_invoice_tax'],
                     'now' => $now
                    ]);
        } else {
            return redirect('/login');
        }
    }
    public function storeNewInvoice(Request $request) {
        if(\Auth::user()) {
            $data = $request->all();
            $g = new Invoices();
            $g->storeNewInvoice($data);
            $invoiceid = \DB::getPdo()->lastInsertId();
            $invoicetotal = $data['invoicetotal']*$data['orders_invoice_tax'];
            return redirect('/num2bgmoneysnap.php?invoiceid='.$invoiceid.'&translate='.$invoicetotal);
        } else {
            return redirect('/login');
        }
    }
    public function getSnapshotToSave($invoiceid) {
        if(\Auth::user()) {
            $g = new Invoices();
            return view('invoicesnapshottosave', ['invoiceid' => $invoiceid]);
        } else {
            return redirect('/login');
        }
    }
    public function storeInvoiceSnapshot(Request $request) {
        if(\Auth::user()) {
            $data = $request->all();
            $g = new Invoices();
            $g->storeInvoiceSnapshot($data);
            $invoicetotal = $data['invoicetotal'];
            return redirect('/num2bgmoney.php?invoiceid='.$data['invoiceid'].'&translate='.$invoicetotal);
        } else {
            return redirect('/login');
        }
    }
    public function getInvoiceSnapshot($invoiceid) {
        $g = new Invoices();
        return view('invoicesnapshot',['invoiceid' => $invoiceid]);
    }
    public function newInvoicePrefix(Request $request) {
        if(\Auth::user()) {
            $data = $request->all();
            $now = date('Y-m-d');
            $companyid = $data['general_company_id'];
            $owncompanyid = $data['general_owncompany_id'];
            $orderid = $data['orderid'];
            $invoicetotal = $data['invoicetotal'];
            $orders_invoice_tax = $data['orders_invoice_tax'];
            return view('invoicesnewprefix', ['owncompanyid' => $owncompanyid, 'companyid' => $companyid, 'orderid' => $orderid, 'invoicetotal' => $invoicetotal, 'orders_invoice_tax' => $orders_invoice_tax, 'now'=> $now]);
        } else {
            return redirect('/login');
        }
    } 
    public function storeNewInvoicePrefix(Request $request) {
        if(\Auth::user()) {
            $g = new Invoices();
            $data = $request->all();
            $g->storeNewInvoicePrefix($data);
            $prefixid = \DB::getPdo()->lastInsertId();
            $g->storeFirstInvoiceToPrefix($data, $prefixid);
            $invoiceid = \DB::getPdo()->lastInsertId();
            $invoicetotalar = $g->getTotal($invoiceid);
            $invoicetotal = null;
            foreach($invoicetotalar as $invoicetotalrow) {
                $invoicetotal = $invoicetotalrow->orders_invoice_total;
            }
            return redirect('/num2bgmoneysnap.php?invoiceid='.$invoiceid.'&translate='.$invoicetotal);
        } else {
            return redirect('/login');
        }
    }
    public function storeNewRecipient(Request $request) { // storeNewRecipient >>> storeNewInvoiceRecipient
        if(\Auth::user()) {
            $data = $request->all();
            $g = new Invoices();
            $g->storeNewRecipient($data);
            $invoiceid = $data['invoiceid'];
            $invoicetotal = $data['invoicetotal'];
            return redirect('/num2bgmoney.php?invoiceid='.$invoiceid.'&translate='.$invoicetotal);
        } else {
            return redirect('/login');
        }
    }
    public function updateInvoicePayment(Request $request) {
        if(\Auth::user()) {
            $data = $request->all();
            $g = new Invoices();
            $g->updateInvoicePayment($data);
            $invoiceid = $data['invoiceid'];
            $invoicetotal = $data['invoicetotal'];
            return redirect('/num2bgmoney.php?invoiceid='.$invoiceid.'&translate='.$invoicetotal);
        } else {
            return redirect('/login');
        }
    }  
}