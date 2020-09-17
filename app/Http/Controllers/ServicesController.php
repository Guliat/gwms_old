<?php

namespace App\Http\Controllers;

use App\Services;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServicesController extends Controller {
    
    public function getServices() {
        $all = new Services();
        $all->getServices();
        return view('services');
    }
    
}