<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Companies;
#use App\Http\Requests;
use App\Http\Controllers\Controller;

class CompaniesController extends Controller
{
    public function all()
    {
        if(\Auth::user()) {
            $getAllCompanies = \DB::table('general_companies')
                             ->paginate(10);
            return view('companies',['getAllCompanies' => $getAllCompanies]);
        }
        else {
            return redirect('/login');
        }
    }
    
    public function company($id)
    {
        if(\Auth::user()) {
            #$getCompany = \DB::select('SELECT * FROM general_companies WHERE general_company_id ='.$id);
            $getCompany = \DB::table('general_companies')
                         ->leftJoin('users', 'general_companies.general_employee_id', '=', 'users.id')
                         ->where('general_company_id', '=', $id)
                         ->get();
            return view('company',['getCompany' => $getCompany]);
        }
        else {
            return redirect('/login');
        }
    }
    
    public function add(Request $request)
    {
        if(\Auth::user()) {
            return view('companyadd');
        }
        else {
            return redirect('/login');
        }
    }
    
    public function store(Request $request)
    {
        $store = new Companies();
        $data = $request->all();
        $store->storeCompany($data);
        $companyid = \DB::getPdo()->lastInsertId();
        return redirect('/company/'.$companyid);
    }
    
    public function update(Request $request)
    {
        $update = new Companies();
        $data = $request->all();
        $update->updateCompany($data);
        $companyid = $data['update_id'];
        return redirect('/company/'.$companyid);
    }
    
    public function gotocompany(Request $request) {
        $data = $request->all();
        $companytoexplode = $data['gotocompany'];
        $companyarr = explode(" -", $companytoexplode, 2);
        $companyid = $companyarr[0];
        if(!empty($companyid)){
            return redirect('/company/'.$companyid);
        } else {
            return redirect('/companies');
            
        }
    }
    
}
