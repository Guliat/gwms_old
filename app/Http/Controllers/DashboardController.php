<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller {
    
    
    public function gwmsredirect() {
        if(\Auth::user()) {
            if(\Auth::user()->general_employee_level == 5) {
                return redirect('/invoices');
            } else { 
                return $this->getDashboard(); 
            }
        } else {
            return redirect('/login');
        }
    }
        
    
    public function getDashboard() {
        if(\Auth::user()) {
            return view('dashboard');
        } else {
            return redirect('/login');
        }
    }
}
