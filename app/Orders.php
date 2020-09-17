<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model {
    
    public function getOrders() {
        function showDate($showDate) {
            $showDateIn = strtotime($showDate);
            $dateStyle = date("d F Y", $showDateIn);
            $showDateArray1 = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            $showDateArray2 = array("Януари", "Февруари", "Март", "Април", "Май", "Юни", "Юли", "Август", "Септември", "Октомври", "Ноември", "Декември");
            $showDateOut = str_replace($showDateArray1, $showDateArray2, $dateStyle);
            echo $showDateOut;
        }
        function getOrderContent() {
            $g = \DB::table('orders_orders')
                 ->where('order_isactive', '=', 1)
                 ->leftJoin('general_customers', 'orders_orders.general_customer_id', '=', 'general_customers.general_customer_id')
                 ->leftJoin('general_companies', 'orders_orders.general_company_id', '=', 'general_companies.general_company_id')
                 ->get();
            return $g;
        }
        function getOrderProducts($orderid) {
            $g = \DB::table('orders_products')
                 ->where('order_id', '=', $orderid)
                 ->leftJoin('store_products', 'orders_products.product_id', '=', 'store_products.product_id')
                 ->get();
            return $g;
        }
        function getOrderServices($orderid) {
            $g = \DB::table('orders_services')
                 ->where('order_id', '=', $orderid)
                 ->leftJoin('store_services', 'orders_services.service_id', '=', 'store_services.service_id')
                 ->get();
            return $g;
        }
    }
    public function getOrder($orderid) {
        function showDate($showDate) {
            $showDateIn = strtotime($showDate);
            $dateStyle = date("d F Y", $showDateIn);
            $showDateArray1 = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            $showDateArray2 = array("Януари", "Февруари", "Март", "Април", "Май", "Юни", "Юли", "Август", "Септември", "Октомври", "Ноември", "Декември");
            $showDateOut = str_replace($showDateArray1, $showDateArray2, $dateStyle);
            echo $showDateOut;
        }
        function getOrderContent($orderid) {
            $g = \DB::table('orders_orders')
                 ->where('order_id', '=', $orderid)
                 ->leftJoin('general_customers', 'orders_orders.general_customer_id', '=', 'general_customers.general_customer_id')
                 ->leftJoin('general_companies', 'orders_orders.general_company_id', '=', 'general_companies.general_company_id')
                 #->leftJoin('orders_invoices', 'orders_orders.order_id', '=', 'orders_invoices.orders_order_id')
                 ->get();
            return $g;
        } 
        function getOrderProducts($orderid) {
            $g = \DB::table('orders_products')
                 ->where('order_id', '=', $orderid)
                 ->where('orders_products_isactive', '=', 1)
                 ->leftJoin('store_products', 'orders_products.product_id', '=', 'store_products.product_id')
                 ->leftJoin('store_products_bmd', 'store_products.product_bmd_id', '=', 'store_products_bmd.product_bmd_id')
                 ->leftJoin('store_products_categories', 'store_products_bmd.product_category_id', '=', 'store_products_categories.product_category_id')
                 ->get();
            return $g;
        }
        function getOrderServices($orderid) {
            $g = \DB::table('orders_services')
                 ->where('order_id', '=', $orderid)
                 ->leftJoin('store_services', 'orders_services.service_id', '=', 'store_services.service_id')
                 ->leftJoin('store_services_categories', 'store_services.service_category_id', '=', 'store_services_categories.services_category_id')
                 ->get();
            return $g;
        }
    }
    public function storeNewOrder($data) {
        $authid = \Auth::id();
        $now = date('Y-m-d');
        if(!empty($data['geleral_company_id'])){
            $companyid = $data['geleral_company_id'];
        } else {
            $companyid = null;
        }
        \DB::insert('INSERT INTO orders_orders'
                    . '(general_employee_id, general_company_id, order_added)'
                    . 'VALUES (?, ?, ?)',
                    [$authid,
                     $companyid,
                     $now
                    ]);
    }
    public function storeProductsToOrder($data){ 
        $authid = \Auth::id();
        $now = date('Y-m-d');
        $producttoexplode = $data['productid'];
        $productarr = explode(" -", $producttoexplode, 2);
        $productid = $productarr[0];
        if(!empty($data['orders_products_soldprice'])) {    
            $soldprice = str_replace(',', '.',$data['orders_products_soldprice']);
        } else {
            $soldprice = 0;
        }
        \DB::insert('INSERT INTO orders_products '
                        . '(general_employee_id, order_id, product_id, orders_products_soldquantity, orders_products_soldprice, orders_products_added) '
                        . 'VALUES (?, ?, ?, ?, ?, ?)', 
                        [
                         $authid,
                         $data['orderid'],
                         $productid,
                         $data['orders_products_soldquantity'],
                         $soldprice,
                         $now
                        ]
                    );
    }
    public function storeCompanyToOrder($data){ 
        $companytoexplode = $data['company_id'];
        $companyarr = explode(" -", $companytoexplode, 2);
        $companyid = $companyarr[0];
        \DB::table('orders_orders')
                ->where('order_id', '=', $data['update_id'])
                ->update(['general_company_id' => $companyid]);
    }
    public function storeCustomerToOrder($data){ 
        $customertoexplode = $data['customer_id'];
        $customerarr = explode(" -", $customertoexplode, 2);
        $customerid = $customerarr[0];
        \DB::table('orders_orders')
                ->where('order_id', '=', $data['update_id'])
                ->update(['general_customer_id' => $customerid]);
    }
    public function storeServicesToOrder($data){ 
        $authid = \Auth::id();
        $now = date('Y-m-d');
        $servicetoexplode = $data['serviceid'];
        $servicesarr = explode(" -", $servicetoexplode, 2);
        $serviceid = $servicesarr[0];
        if(!empty($data['orders_service_soldprice'])) {
            $soldprice = str_replace(',', '.',$data['orders_service_soldprice']);
        } else {
            $soldprice = 0;
        }
        \DB::insert('INSERT INTO orders_services '
                        . '(general_employee_id, order_id, service_id, orders_service_soldquantity, orders_service_soldprice, orders_service_added) '
                        . 'VALUES (?, ?, ?, ?, ?, ?)', 
                        [
                         $authid,
                         $data['orderid'],
                         $serviceid,
                         $data['orders_service_soldquantity'],
                         $soldprice,
                         $now
                        ]
                    );
    }
    public function updateOrder($uodata){
        \DB::table('orders_orders')
        ->where('order_id', '=', $uodata['updateid'])
        ->update([
            'order_note' => $uodata['order_note']
        ]);
    }
    public function updateOrderProduct($data) {
        \DB::table('orders_products')
         ->where('orders_products_id', '=', $data['update_id'])
         ->update([
                  'orders_products_soldquantity' => str_replace(',', '.',$data['orders_products_soldquantity']),
                  'orders_products_soldprice' => str_replace(',', '.',$data['orders_products_soldprice'])
                  ]);
    }
    public function updateOrderService($data) {
        \DB::table('orders_services')
         ->where('orders_service_id', '=', $data['update_id'])
         ->update([
                  'orders_service_soldquantity' => str_replace(',', '.',$data['orders_service_soldquantity']),
                  'orders_service_soldprice' => str_replace(',', '.',$data['orders_service_soldprice'])
                  ]);
    }
    public function returnOrderProduct($data) {
        \DB::table('orders_products')
         ->where('orders_products_id', '=', $data['update_id'])
         ->update([
                  'orders_products_soldquantity' => 0,
                  'orders_products_isactive' => 0
                  ]);
    }
    public function closeOrder($orderid) {
        $now = date('Y-m-d');
        \DB::table('orders_orders')
            ->where('order_id', '=', $orderid)
            ->update(['order_isactive' => 0, 'order_finished' => $now]);
    }
    
}    
