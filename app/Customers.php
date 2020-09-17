<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model {
    
    static public function getCustomerContent($customerid) {
        $g = \DB::table('general_customers')
              ->where('general_customer_id', '=', $customerid)
              ->get();
        return $g;
    }
    // GET CUSTOMER BY ID
    public function getCustomer($customerid) {
        $getCustomerContent = \DB::table('general_customers')
                                ->where('general_customer_id', '=', $customerid)
                                ->leftJoin('users', 'general_customers.general_employee_id', '=', 'users.id')
                                ->get();
        $getCustomerOrders = \DB::table('orders_orders')
                                ->where('general_customer_id', '=', $customerid)
                                ->get();
        $getCustomerInvoices = \DB::table('orders_invoices')
                                ->where('general_customer_id', '=', $customerid)
                                ->get();
        $getCustomerComputersServices = \DB::table('computers_services')
                                ->where('general_customer_id', '=', $customerid)
                                ->get();
        $getCustomerDevices = \DB::table('computers_customersdevices')
                                ->where('general_customer_id', '=', $customerid)
                                ->leftJoin('computers_devices', 'computers_customersdevices.computers_device_id', '=', 'computers_devices.computers_device_id')
                                ->leftJoin('computers_devices_bm', 'computers_devices.computers_device_bm_id', '=', 'computers_devices_bm.computers_device_bm_id')
                                ->leftJoin('computers_devices_categories', 'computers_devices_bm.computers_device_category_id', '=', 'computers_devices_categories.computers_device_category_id')
                                ->get();
        $customernames = null;
        foreach($getCustomerContent as $getCustomerContentRows) {
            $customernames = $getCustomerContentRows->general_customer_names;
        }
        $customerid = null;
        foreach($getCustomerContent as $getCustomerContentRows) {
            $customerid = $getCustomerContentRows->general_customer_id;
        }
        $g['getCustomerContent'] = $getCustomerContent;
        $g['getCustomerOrders'] = $getCustomerOrders;
        $g['getCustomerInvoices'] = $getCustomerInvoices;
        $g['getCustomerComputersServices'] = $getCustomerComputersServices;
        $g['getCustomerDevices'] = $getCustomerDevices;
        $g['customernames'] = $customernames;
        $g['customerid'] = $customerid;
        return $g;
    }
    // GET ALL CUSTOMERS
    public function getCustomers() {
        function showDate($showDate) {
            $showDateIn = strtotime($showDate);
            $dateStyle = date("d F Y", $showDateIn);
            $showDateArray1 = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            $showDateArray2 = array("Януари", "Февруари", "Март", "Април", "Май", "Юни", "Юли", "Август", "Септември", "Октомври", "Ноември", "Декември");
            $showDateOut = str_replace($showDateArray1, $showDateArray2, $dateStyle);
            echo $showDateOut;
        }
        $g = \DB::table('general_customers')->leftJoin('users', 'general_customers.general_employee_id', '=', 'users.id')->paginate(10);
        return $g;
    }
    // STORE NEW CUSTOMER
    public function storeCustomer($data) {
        $authid = \Auth::id();
        if(empty($data['customeradded'])) {
            $added = date('Y-m-d');
        } else {
            $added = $data['customeradded'];
        }
        \DB::insert('INSERT INTO general_customers '
                    . '('
                    . 'general_customer_id,'
                    . 'general_employee_id,'
                    . 'general_customer_names,'
                    . 'general_customer_nick,'
                    . 'general_customer_phone,'
                    . 'general_customer_phone2,'
                    . 'general_customer_added'
                    . ')'
                    . 'VALUES (?, ?, ?, ?, ?, ?, ?)',
                    [
                    $data['customerid'],
                    $authid,
                    $data['customernames'],
                    $data['customernick'],
                    $data['customerphone'],
                    $data['customerphone2'],
                    $added
                    ]);
    }
    // UPDATE CUSTOMER
    public function updateCustomer($data) {
        \DB::table('general_customers')
        ->where('general_customer_id', $data['update_id'])
        ->update([
                'general_customer_names' => $data['general_customer_names'],
                'general_customer_nick' => $data['general_customer_nick'],
                'general_customer_phone' => $data['general_customer_phone'],
                'general_customer_phone2' => $data['general_customer_phone2'],
                'general_customer_added' => $data['general_customer_added'],
                'general_customer_level' => $data['general_customer_level']
                ]);
    }
}
