<?php

namespace App\Http\Controllers;

use App\OwnCompanies;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OwnCompaniesController extends Controller
{
    public function all() {
        if(\Auth::user()) {
            $all = new OwnCompanies();
            $getContent = $all->getContent();
            $getOwnCompanies = $getContent['getOwnCompanies'];
            $getEmployees = $getContent['getEmployees'];
            return view('owncompanies', ['getOwnCompanies' => $getOwnCompanies, 'getEmployees' => $getEmployees]);
        } else {
            return redirect('/login');
        }
    }
    public function storeOwnCompany(Request $request) {
        $storeOwnCompany = new OwnCompanies();
        $dataOwnCompany = $request->all();
        $storeOwnCompany->storeOwnCompany($dataOwnCompany);
        return redirect()->back();
    }
    public function updateOwnCompany(Request $request) {
        $updateOwnCompany = new OwnCompanies();
        $dataOwnCompany = $request->all();
        $updateOwnCompany->updateOwnCompany($dataOwnCompany);
        return redirect()->back();
    }
    public function removeOwnCompany(Request $request) {
        $removeOwnCompany = new OwnCompanies();
        $dataOwnCompany = $request->all();
        $removeOwnCompany->removeOwnCompany($dataOwnCompany);
        return redirect()->back();
    }
    public function storeEmployee(Request $request) {
        $storeEmployee = new OwnCompanies();
        $dataEmployee = $request->all();
        $storeEmployee->storeEmployee($dataEmployee);
        return redirect()->back();
    }
    public function updateEmployee(Request $request) {
        $updateEmployee = new OwnCompanies();
        $dataEmployee = $request->all();
        $updateEmployee->updateEmployee($dataEmployee);
        return redirect()->back();
    }
    public function removeEmployee(Request $request) {
        $removeEmployee = new OwnCompanies();
        $dataEmployee = $request->all();
        $removeEmployee->removeEmployee($dataEmployee);
        return redirect()->back();
    }
}