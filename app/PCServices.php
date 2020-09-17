<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PCServices extends Model {
    
    public function storeCustomerToDevice($data) {
        $authid = \Auth::id();
        $added = date('Y-m-d');
        \DB::insert('INSERT INTO computers_customersdevices'
                    .'(general_employee_id, general_customer_id, computers_device_id, computers_customerdevice_added)'
                    .'VALUES (?, ?, ?, ?)',
                    [$authid, $data['customer_id'], $data['update_id'], $added]
                   );
    }
    public function getServicesActive() {
        $g = \DB::table('computers_services')
                 ->where('computers_service_isactive', '=', 1)
                 ->leftJoin('computers_devices', 'computers_services.computers_device_id', '=', 'computers_devices.computers_device_id')
                 ->leftJoin('computers_devices_bm', 'computers_devices.computers_device_bm_id', '=', 'computers_devices_bm.computers_device_bm_id')
                 ->leftJoin('computers_devices_categories', 'computers_devices_bm.computers_device_category_id', '=', 'computers_devices_categories.computers_device_category_id')
                 ->leftJoin('general_customers', 'computers_services.general_customer_id', '=', 'general_customers.general_customer_id')
                 ->orderBy('computers_device_category', 'DESC')
                 ->get();
        return $g;
    }
    static public function getServiceUpdates($serviceid) {
        $g = \DB::table('computers_services_updates')
             ->where('computers_service_id', '=', $serviceid)
             ->leftJoin('users', 'users.id', '=', 'computers_services_updates.general_employee_id')
             ->get();
        return $g;
    }
    static public function getLastServiceUpdate($serviceid) {
        $g = \DB::table('computers_services_updates')
             ->where('computers_service_id', '=', $serviceid)
             ->limit(1)
             ->orderBy('computers_service_update_added', 'DESC')
             ->get();
        $content = null;
        foreach($g as $cnt) {
            $content = $cnt->computers_service_update;
        }
        return $content;
        
    }
    public function getDeviceContent($deviceid) {
            $g = \DB::table('computers_devices')
                 ->where('computers_device_id', '=', $deviceid)
                 ->leftJoin('users', 'computers_devices.general_employee_id', '=', 'users.id')
                 ->leftJoin('computers_devices_bm', 'computers_devices.computers_device_bm_id', '=', 'computers_devices_bm.computers_device_bm_id')   
                 ->leftJoin('computers_devices_categories', 'computers_devices_bm.computers_device_category_id', '=', 'computers_devices_categories.computers_device_category_id')
                 ->get();
            return $g;
        }   
    public function getDevice($deviceid) {
        function showDate($showDate) {
            $showDateIn = strtotime($showDate);
            $dateStyle = date("d F Y", $showDateIn);
            $showDateArray1 = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            $showDateArray2 = array("Януари", "Февруари", "Март", "Април", "Май", "Юни", "Юли", "Август", "Септември", "Октомври", "Ноември", "Декември");
            $showDateOut = str_replace($showDateArray1, $showDateArray2, $dateStyle);
            echo $showDateOut;
        }
        function getDeviceContent($deviceid) {
            $g = \DB::table('computers_devices')
                 ->where('computers_device_id', '=', $deviceid)
                 ->leftJoin('users', 'computers_devices.general_employee_id', '=', 'users.id')
                 ->leftJoin('computers_devices_bm', 'computers_devices.computers_device_bm_id', '=', 'computers_devices_bm.computers_device_bm_id')   
                 ->leftJoin('computers_devices_categories', 'computers_devices_bm.computers_device_category_id', '=', 'computers_devices_categories.computers_device_category_id')
                 ->get();
            return $g;
        }
        function getDeviceCustomers($deviceid) {
            $g = \DB::table('computers_customersdevices')
                 ->where('computers_device_id', '=', $deviceid)
                 ->leftJoin('general_customers', 'computers_customersdevices.general_customer_id', '=', 'general_customers.general_customer_id')
                 ->get();
            return $g;
        }
        function getDeviceServices($deviceid, $customerid) {
            $g = \DB::table('computers_services')
                 ->where('computers_device_id', '=', $deviceid)
                 ->where('general_customer_id', '=', $customerid)
                 ->get();
            return $g;
        }
    }
    public function getDevices() {
        function showDate($showDate) {
            $showDateIn = strtotime($showDate);
            $dateStyle = date("d F Y", $showDateIn);
            $showDateArray1 = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            $showDateArray2 = array("Януари", "Февруари", "Март", "Април", "Май", "Юни", "Юли", "Август", "Септември", "Октомври", "Ноември", "Декември");
            $showDateOut = str_replace($showDateArray1, $showDateArray2, $dateStyle);
            echo $showDateOut;
        }
        $getDevices = \DB::table('computers_devices')
                    ->leftJoin('computers_devices_bm', 'computers_devices.computers_device_bm_id', '=', 'computers_devices_bm.computers_device_bm_id')
                    ->leftJoin('computers_devices_categories', 'computers_devices_bm.computers_device_category_id', '=', 'computers_devices_categories.computers_device_category_id')
                    ->paginate(10);
        $getCategories = \DB::table('computers_devices_categories')
                         ->select('computers_device_category_id', 'computers_device_category')
                         ->get();
        
        $devices['getDevices'] = $getDevices;
        $devices['getCategories'] = $getCategories;
        return $devices;
    }
    static public function getDeviceServices($deviceid) {
        $g = \DB::table('computers_services')
              ->where('computers_device_id', '=', $deviceid)
              ->select('computers_service_id', 'computers_service_complaint')
			->orderBy('computers_service_id', 'ASC')
              ->get();
        return $g;
    }
    static public function getNextPCService() {
        $g = \DB::table('computers_services')
              ->select('computers_service_id')
              ->limit(1)
              ->orderBy('computers_service_id', 'DESC')
              ->get();
        foreach($g as $v) { $result = $v->computers_service_id+1; }
        echo $result;
    }
    public function getCategories() {
        function showDate($showDate) {
            $showDateIn = strtotime($showDate);
            $dateStyle = date("d F Y", $showDateIn);
            $showDateArray1 = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            $showDateArray2 = array("Януари", "Февруари", "Март", "Април", "Май", "Юни", "Юли", "Август", "Септември", "Октомври", "Ноември", "Декември");
            $showDateOut = str_replace($showDateArray1, $showDateArray2, $dateStyle);
            echo $showDateOut;
        }
        $getCategories = \DB::table('computers_devices_categories')
                         ->leftJoin('users', 'computers_devices_categories.general_employee_id', '=', 'users.id')
                         ->paginate(10);
        $categories['getCategories'] = $getCategories;
        return $categories;
    }
    public function getBrandsModels() {
        function showDate($showDate) {
            $showDateIn = strtotime($showDate);
            $dateStyle = date("d F Y", $showDateIn);
            $showDateArray1 = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            $showDateArray2 = array("Януари", "Февруари", "Март", "Април", "Май", "Юни", "Юли", "Август", "Септември", "Октомври", "Ноември", "Декември");
            $showDateOut = str_replace($showDateArray1, $showDateArray2, $dateStyle);
            echo $showDateOut;
        }
        function getBrandsModels() {
            $g = \DB::table('computers_devices_bm')
                 ->leftJoin('users', 'computers_devices_bm.general_employee_id', '=', 'users.id')
                 ->leftJoin('computers_devices_categories', 'computers_devices_bm.computers_device_category_id', '=', 'computers_devices_categories.computers_device_category_id')
                 ->orderBy('computers_device_brandmodel', 'asc')
                 ->paginate(10);
            return $g;
        }
        function getBMCategories() {
            $g = \DB::table('computers_devices_categories')
                 ->select('computers_device_category_id', 'computers_device_category')
                 ->get();
            return $g;
        }

    }
    public function storeNewPCServiceToDevice($data) {
        $authid = \Auth::id();
        if(empty($data['serviceadded'])) {
            $added = date('Y-m-d H:i:s');
        } else {
            $added = $data['serviceadded'];
        }
        
        $havebag = null;
        if(isset($data['bag'])) { $havebag = 1; } else { $havebag = 0; }
        $havepower = null;
        if(isset($data['power'])) { $havepower = 1; } else { $havepower = 0; }
        $havebattery = null;
        if(isset($data['battery'])) { $havebattery = 1; } else { $havebattery = 0; }
        
        \DB::insert('INSERT INTO computers_services'
                    .'(computers_service_id, general_employee_id, general_customer_id, computers_device_id, computers_service_complaint, computers_service_description, computers_service_aboutprice, computers_service_havebag, computers_service_havepower, computers_service_havebattery, computers_service_added)'
                    .'VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                    [$data['serviceid'], $authid, $data['customerid'], $data['deviceid'], $data['complaint'], $data['description'], $data['aboutprice'], $havebag, $havepower, $havebattery, $added]
                   );
    }  
    public function completePCService($data) {
        $now = date('Y-m-d H:i:s');
        $g = \DB::table('computers_services')
             ->where('computers_service_id', '=', $data['confirmid'])
             ->update(['computers_service_isactive' => 0, 'computers_service_completed' => $now]);
    }      
    public function checkServiceNumber($serviceid) {
        $g = \DB::table('computers_services')
             ->where('computers_service_id', '=', $serviceid)
             ->get();
        return $g;
    }
    public function checkDeviceNumber($serviceid) {
        $g = \DB::table('computers_devices')
             ->where('computers_device_id', '=', $serviceid)
             ->get();
        return $g;
    }
    public function updatePCServicePrice($data) {
        \DB::table('computers_services')
        ->where('computers_service_id', '=', $data['updateid'])
        ->update(['computers_service_price' => $data['updatepcsp']]);
    }
    public function updatePCPartsPrice($data) {
        \DB::table('computers_services')
        ->where('computers_service_id', '=', $data['updateid'])
        ->update(['computers_service_partsprice' => $data['updatepcpp']]);
    }
    public function updatePCDiscountPrice($data) {
        \DB::table('computers_services')
        ->where('computers_service_id', '=', $data['updateid'])
        ->update(['computers_service_discountprice' => $data['updatepcdp']]);
    }
    public function updatePCComplaint($data) {
        \DB::table('computers_services')
        ->where('computers_service_id', '=', $data['updateid'])
        ->update(['computers_service_complaint' => $data['updatepccomplaint']]);
    }
    public function updatePCDescription($data) {
        \DB::table('computers_services')
        ->where('computers_service_id', '=', $data['updateid'])
        ->update(['computers_service_description' => $data['updatepcdesc']]);
    }
    public function updatePCHiddenDescription($data) {
        \DB::table('computers_services')
        ->where('computers_service_id', '=', $data['updateid'])
        ->update(['computers_service_hiddendescription' => $data['updatepchiddesc']]);
    }
    public function updatePCServiceBagPwrBat($data) {
        $havebag = null;
        if(isset($data['bag'])) { $havebag = 1; } else { $havebag = 0; }
        $havepower = null;
        if(isset($data['power'])) { $havepower = 1; } else { $havepower = 0; }
        $havebattery = null;
        if(isset($data['battery'])) { $havebattery = 1; } else { $havebattery = 0; }
        
        \DB::table('computers_services')
        ->where('computers_service_id', '=', $data['updateid'])
        ->update(['computers_service_havebag' => $havebag, 'computers_service_havepower' => $havepower, 'computers_service_havebattery' => $havebattery]);
    }
    public function storePCServiceUpdate($data) {
        $authid = \Auth::id();
        if(empty($data['serviceupdateadded'])) {
            $added = date('Y-m-d H:i:s');
        } else {
            $added = $data['serviceupdateadded'];
        }
        \DB::insert('INSERT INTO computers_services_updates'
                    .'(computers_service_id, general_employee_id, computers_service_update, computers_service_update_added)'
                    .'VALUES (?, ?, ?, ?)',
                    [$data['storeid'], $authid, $data['storepcserviceupdate'], $added]
                   );
    }
    public function storeNewPCService($data) {
        $authid = \Auth::id();
        if(empty($data['serviceadded'])) {
            $added = date('Y-m-d H:i:s');
        } else {
            $added = $data['serviceadded'];
        }        
        $havebag = null;
        if(isset($data['bag'])) { $havebag = 1; } else { $havebag = 0; }
        $havepower = null;
        if(isset($data['power'])) { $havepower = 1; } else { $havepower = 0; }
        $havebattery = null;
        if(isset($data['battery'])) { $havebattery = 1; } else { $havebattery = 0; }
        
        \DB::insert('INSERT INTO computers_services'
                    .'(general_employee_id, general_customer_id, computers_device_id, computers_service_complaint, computers_service_description, computers_service_aboutprice, computers_service_havebag, computers_service_havepower, computers_service_havebattery, computers_service_added)'
                    .'VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                    [$authid, $data['general_customer_id'], $data['computers_device_id'], $data['computers_service_complaint'], $data['computers_service_description'], $data['computers_service_aboutprice'], $havebag, $havepower, $havebattery, $added]
                   );
    }   
    public function storePCDevice($data) {
        $authid = \Auth::id();
        if(empty($data['deviceadded'])) {
            $added = date('Y-m-d');
        } else {
            $added = $data['deviceadded'];
        }
        $brandsmodelstoexplode = $data['computers_device_brandmodel'];
        $brandsmodelsarr = explode(" -", $brandsmodelstoexplode, 2);
        $brandsmodelsid = $brandsmodelsarr[0];
        \DB::insert('INSERT INTO computers_devices'
                    . '(computers_device_id, general_employee_id, computers_device_bm_id, computers_device_submodel, computers_device_color, computers_device_note, computers_device_added)'
                    . 'VALUES (?, ?, ?, ?, ?, ?, ?)',
                    [$data['deviceid'],
                     $authid,
                     $brandsmodelsid,
                     $data['computers_device_submodel'],
                     $data['computers_device_color'],
                     $data['computers_device_note'],
                     $added]);
    }
    public function storeRELCustomerDevice($customerid, $deviceid) {
        $authid = \Auth::id();
        $now = date('Y-m-d');
        \DB::insert('INSERT INTO computers_customersdevices'
                   . '(general_employee_id, general_customer_id, computers_device_id, computers_customerdevice_added)'
                   . 'VALUES (?, ?, ?, ?)',
                   [$authid, $customerid, $deviceid, $now]);
    } 
    public function storePCDBrandModel($data) {
        $authid = \Auth::id();
        $now = date('Y-m-d');
        \DB::insert('INSERT INTO computers_devices_bm'
                    . '('
                    . 'general_employee_id,'
                    . 'computers_device_category_id,'
                    . 'computers_device_brandmodel,'
                    . 'computers_device_bm_added'
                    . ')'
                    . 'VALUES (?, ?, ?, ?)',
                    [
                     $authid,
                     $data['computers_device_category_id'],
                     $data['computers_device_brandmodel'],
                     $now
                    ]);
    }
    public function updatePCDBrandModel($data) {
        \DB::table('computers_devices_bm')
        ->where('computers_device_bm_id', $data['update_id'])
        ->update(['computers_device_brandmodel' => $data['computers_device_brandmodel']]);
    }
    public function storePCDCategory($data) {
        $authid = \Auth::id();
        $now = date('Y-m-d');
        \DB::insert('INSERT INTO computers_devices_categories'
                    . '('
                    . 'general_employee_id,'
                    . 'computers_device_category,'
                    . 'computers_device_category_added'
                    . ')'
                    . 'VALUES (?, ?, ?)',
                    [
                     $authid,
                     $data['computers_device_category'],
                     $now
                    ]);
    }
    public function updatePCDCategory($data) {
        \DB::table('computers_devices_categories')
        ->where('computers_device_category_id', $data['update_id'])
        ->update(['computers_device_category' => $data['computers_device_category']]);
    }
}