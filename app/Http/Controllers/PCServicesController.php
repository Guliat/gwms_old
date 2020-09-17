<?php

namespace App\Http\Controllers;

use App\PCServices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PCServicesController extends Controller {
    
    public function storeCustomerToDevice(Request $request) {
        if(\Auth::user()) {
            $g = new PCServices();
            $data = $request->all();
            $g->storeCustomerToDevice($data);
            return redirect()->back();
        } else {
            return redirect('/login');
        }
    }
    
    public function getServicesActive() {
        if(\Auth::user()) {
            $g = new PCServices();
            $content = $g->getServicesActive();
            return view('pcservices_active', ['content' => $content]);
        }
        else {
            return redirect('/login');
        }
    }
    public function getService($serviceid) {
        
        if(\Auth::user()) {
       
            $getService = \DB::table('computers_services')
                         ->where('computers_service_id', '=', $serviceid)
                         ->leftJoin('general_customers', 'general_customers.general_customer_id', '=', 'computers_services.general_customer_id')
                         ->get();
            return view('pcservice', ['getService' => $getService]);
        } else {
            return redirect('/login');
        }
    }
    public function getDevices() {
        if(\Auth::user()) {
            $all = new PCServices();
            $getContent = $all->getDevices();
            $getDevices = $getContent['getDevices'];
            $getCategories = $getContent['getCategories'];
            return view('pcservices_devices', ['getDevices' => $getDevices, 'getCategories' => $getCategories]);
        } else {
            return redirect('/login');
        }
    }
    public function getDevice($deviceid) {
        if(\Auth::user()) {
            $all = new PCServices();
            $check = $all->getDevice($deviceid);
            
            $checkid = null;
            foreach(\App\getDeviceContent($deviceid) as $checkrows) {
                $checkid = $checkrows->computers_device_id;
            }
            
            if(!empty($checkid)) {
                return view('pcservices_device', ['deviceid' => $deviceid]);
            } else {
                return redirect('/pcs/devices')->with('nondevice', 'Това устройство още не е добавено !');
            }
        } else {
            return redirect('/login');
        }
    }
    public function getCategories() {
        if(\Auth::user()) {
            $all = new PCServices();
            $getContent = $all->getCategories();
            $getCategories = $getContent['getCategories'];
            return view('pcservices_categories', ['getCategories' => $getCategories]);
        } else {
            return redirect('/login');
        }
    }
    public function getBrandsModels() {
        if(\Auth::user()) {
            $all = new PCServices();
            $all->getBrandsModels();
            return view('pcservices_brandsmodels');
        } else {
            return redirect('/login');
        }
    }
    public function printPCService($serviceid) {
        if(\Auth::user()) {
            $getService = \DB::table('computers_services')
                         ->where('computers_service_id', '=', $serviceid)
                         ->leftJoin('general_customers', 'general_customers.general_customer_id', '=', 'computers_services.general_customer_id')
                         ->get();
            return view('pcservice_print', ['getService' => $getService]);
        } else {
            return redirect('/login');   
        }
    }
    public function storeNewPCServiceToDevice(Request $request) {
        if(\Auth::user()) {
            $update = new PCServices();
            $data = $request->all();
            $update->storeNewPCServiceToDevice($data);
            return redirect()->back();    
        } else {
            return redirect('/login');   
        }
    }     
    public function completePCService(Request $request) {
        if(\Auth::user()) {
            $update = new PCServices();
            $data = $request->all();
            $update->completePCService($data);
            $serviceid = $data['confirmid'];
            return redirect('/pcs/service/print/'.$serviceid);  
        } else {
            return redirect('/login');   
        }
    }
    public function goToService(Request $request) {
        if(\Auth::user()) {
            $data = $request->all();
            if(!empty($data['serviceid'])) {
                $check = new PCServices();
                $checkid = $check->checkServiceNumber($data['serviceid']);
                if(!empty($checkid)) {
                    $serviceid = $data['serviceid'];
                } else {
                    return redirect()->back()->withErrors('НЯМА ТАКЪВ НОМЕР УСЛУГА');
                }
            } else {
                return redirect()->back()->withErrors('НЕ СТЕ ВЪВЕЛИ НОМЕР НА УСЛУГА');
            }
            return redirect('/pcs/service/'.$serviceid);
        } else {
            return redirect('/login');
        }    
    }
    public function goToDevice(Request $request) {
        if(\Auth::user()) {
            $data = $request->all();
            if(!empty($data['deviceid'])) {
                $check = new PCServices();
                $checkid = $check->checkDeviceNumber($data['deviceid']);
                if(!empty($checkid)) {
                    $deviceid = $data['deviceid'];
                } else {
                    return redirect()->back()->withErrors('НЯМА ТАКЪВ НОМЕР УСТРОЙСТВО');
                }
            } else {
                return redirect()->back()->withErrors('НЕ СТЕ ВЪВЕЛИ НОМЕР НА УСТРОЙСТВО');
            }
            return redirect('/pcs/device/'.$deviceid);
        } else {
            return redirect('/login');
        }    
    }
    public function updatePCServiceBagPwrBat(Request $request) {
        if(\Auth::user()) {
            $update = new PCServices();
            $data = $request->all();
            $update->updatePCServiceBagPwrBat($data);
            return redirect()->back();
        } else {
            return redirect('/login');
        }
    }
    public function updatePCServicePrice(Request $request) {
        if(\Auth::user()) {
            $update = new PCServices();
            $data = $request->all();
            $update->updatePCServicePrice($data);
            return redirect()->back();
        } else {
            return redirect('/login');
        }
    }
    public function updatePCPartsPrice(Request $request) {
        if(\Auth::user()) {
            $update = new PCServices();
            $data = $request->all();
            $update->updatePCPartsPrice($data);
            return redirect()->back();
        } else {
            return redirect('/login');
        }
    }
    public function updatePCDiscountPrice(Request $request) {
        if(\Auth::user()) {
            $update = new PCServices();
            $data = $request->all();
            $update->updatePCDiscountPrice($data);
            return redirect()->back();
        } else {
            return redirect('/login');
        }
    }
    public function updatePCDescription(Request $request) {
        if(\Auth::user()) {
            $update = new PCServices();
            $data = $request->all();
            $update->updatePCDescription($data);
            return redirect()->back();
        } else {
            return redirect('/login');
        }
    }
    public function updatePCHiddenDescription(Request $request) {
        if(\Auth::user()) {
            $update = new PCServices();
            $data = $request->all();
            $update->updatePCHiddenDescription($data);
            return redirect()->back();
        } else {
            return redirect('/login');
        }
    }
    public function updatePCComplaint(Request $request) {
        if(\Auth::user()) {
            $update = new PCServices();
            $data = $request->all();
            $update->updatePCComplaint($data);
            return redirect()->back();
        } else {
            return redirect('/login');
        }
    }
    public function storePCServiceUpdate(Request $request) {
        if(\Auth::user()) {
            $update = new PCServices();
            $data = $request->all();
            if(!empty($data['storepcserviceupdate'])) {
                $update->storePCServiceUpdate($data);
                return redirect()->back();
            } else {
                return redirect()->back();
            }
        } else {
            return redirect('/login');
        }
    }
    public function newPCServiceFromCustomer() {
        if(\Auth::user()) {
            $customerid = $_POST['general_customer_id'];
            $deviceid = $_POST['computers_device_id'];
            $categoryid = $_POST['computers_device_category_id'];
            return view('computerservicenew', ['customerid' => $customerid, 'deviceid' => $deviceid, 'categoryid' => $categoryid]);
        } else {
            return redirect('/login');
        }
    }
    public function storeNewPCService(Request $request) {
        if(\Auth::user()) {
            $store = new PCServices();
            $data = $request->all();
            $store->storeNewPCService($data);
            $serviceid = \DB::getPdo()->lastInsertId();
            return redirect('/pcs/service/'.$serviceid);
        } else {
            return redirect('/login');
        }
    }
    public function newPCServiceDevice() {
        if(\Auth::user()) {
            return view('pcservices_device_new');
        } else {
            return redirect('/login');
        }
    }
    public function storePCDevice(Request $request) {
        $store = new PCServices();
        $data = $request->all();
        $store->storePCDevice($data);
        $deviceid = \DB::getPdo()->lastInsertId();
        $customerid = $data['customerid'];
        $store->storeRELCustomerDevice($customerid, $deviceid);
        return redirect('/pcs/device/'.$deviceid);
    }
    public function storePCDCategory(Request $request) {
        $store = new PCServices();
        $data = $request->all();
        $store->storePCDCategory($data);
        return redirect()->back()->withErrors(['Добавено!']);
    }
    public function updatePCDCategory(Request $request) {
        $update = new PCServices();
        $data = $request->all();
        $update->updatePCDCategory($data);
        return redirect()->back()->withErrors(['Обновено!']);
    }
    public function storePCDBrandModel(Request $request) {
        $data = $request->all();
        $rules = array('computers_device_brandmodel' => 'required|unique:computers_devices_bm,computers_device_brandmodel');
        $validator = \Illuminate\Support\Facades\Validator::make($data, $rules);
        if ($validator->fails()) {
            $validator->messages();
            return redirect('/pcs/brandsmodels')->withErrors($validator);
        } else {
            $store = new PCServices();
            $store->storePCDBrandModel($data);
            return redirect()->back()->with('added', 'Добавено!');
        }
    }
    public function updatePCDBrandModel(Request $request) {
        $update = new PCServices();
        $data = $request->all();
        $update->updatePCDBrandModel($data);
        return redirect()->back()->with('updated', 'Обновено!');
    } 
}