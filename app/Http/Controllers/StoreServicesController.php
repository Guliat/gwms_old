<?php

namespace App\Http\Controllers;

use App\StoreServices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreServicesController extends Controller {
    public function getStoreServices() {
        if(\Auth::user()) {
            $g = new StoreServices;
            $g->getStoreServices();
            return view('store_services');
        } else {
            return redirect('/login');
        }
    }
    public function storeStoreService(Request $request) {
        if(\Auth::user()) {
            $data = $request->all();
            $g = new StoreServices;
            $g->storeStoreService($data);
            return redirect()->back();
        } else {
            return redirect('/login');
        } 
    }
    public function storeStoreServicesCategory(Request $request) {
        if(\Auth::user()) {
            $data = $request->all();
            $g = new StoreServices;
            $g->storeStoreServicesCategory($data);
            return redirect()->back();
        } else {
            return redirect('/login');
        } 
    }
    public function updateStoreService(Request $request) {
        if(\Auth::user()) {
            $data = $request->all();
            $g = new StoreServices;
            $g->updateStoreService($data);
            return redirect()->back();
        } else {
            return redirect('/login');
        } 
    }    
    public function updateStoreServicesCategory(Request $request) {
        if(\Auth::user()) {
            $data = $request->all();
            $g = new StoreServices;
            $g->updateStoreServicesCategory($data);
            return redirect()->back();
        } else {
            return redirect('/login');
        } 
    }
}