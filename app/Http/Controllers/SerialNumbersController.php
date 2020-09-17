<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SerialNumbers;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SerialNumbersController extends Controller
{
    public function index()
    {
        if(\Auth::user()) {
            $getCompanies = \DB::select('SELECT * FROM general_companies');
            $getProviders = \DB::select('SELECT * FROM general_providers');
            $getCustomers = \DB::select('SELECT general_customer_names FROM general_customers');
            return view('serialnumbers',['getCompanies' => $getCompanies, 'getProviders' => $getProviders, 'getCustomers' => $getCustomers]);
        }
        else {
            return redirect('/login');
        }
    }
    
    public function store(Request $request)
    {
        $sn = new SerialNumbers();
        $data = $request->all();
        $sn->saveSerialNumber($data);
        return redirect('/products');
    }
    
}
