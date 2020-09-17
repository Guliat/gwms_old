<?php

namespace App\Http\Controllers;

use App\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomersController extends Controller {
    // GET CUSTOMER BY ID
    public function customer($customerid) {
        if(\Auth::user()) {
            
            $ga = \DB::table('general_customers')
                        ->where('general_customer_id', '=', $customerid)
                        ->get();
                
            #foreach($ga as $cust) {
                if(!empty($ga)) {
                    $g = new Customers();
                    $getCustomerContent = $g->getCustomer($customerid);
                    return view('customer', ['getCustomerContent' => $getCustomerContent]);
                } else {
                    return redirect('customers')->withErrors('Моля, ползвайте търсачката');
                }
            #}
            
        } else {
            return redirect('/login');
        }
    }
    // GET ALL CUSTOMERS
    public function customers() {
        if(\Auth::user()) {
            $g = new Customers();
            $getCustomersContent = $g->getCustomers();
            return view('customers', ['getCustomers' => $getCustomersContent]);
        } else {
            return redirect('/login');
        }
    }
    // GO TO CUSTOMER
    public function goToCustomer(Request $request) {
        $data = $request->all();
        $customertoexplode = $data['gotocustomer'];
        $customerarr = explode(" -", $customertoexplode, 2);
        $customerid = $customerarr[0];
       
        $g = \DB::table('general_customers')
             ->select('general_customer_id')
             ->get();
        
        $custid = null;
        
        foreach($g as $cutomersids) {
            if($customerid == $cutomersids->general_customer_id) {
                $custid = $cutomersids->general_customer_id;
            }
        }
        
        
        if(!empty($custid)){
            return redirect('/customer/'.$custid);
        }
        else {
            return redirect('/customers')->withErrors('Грешни или невъведени данни за търсене');
        }
        
    }
    // STORE NEW CUSTOMER
    public function storeCustomer(Request $request) {
        $store = new Customers();
        $data = $request->all();
        $store->storeCustomer($data);
        $customerid = \DB::getPdo()->lastInsertId();
        return redirect('/customer/'.$customerid);
    }
    // UPDATE CUSTOMER
    public function updateCustomer(Request $request) {
        $update = new Customers();
        $data = $request->all();
        $update->updateCustomer($data);
        $customerid = $data['update_id'];
        return redirect('/customer/'.$customerid);
    }
}
