<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Videosurveillance extends Model {
  
    public function getProject($projectid) {
        
        function getProject($projectid) {
            $g = \DB::table('videosurveillance_projects')
            ->where('videosurveillance_project_id', '=', $projectid)
            ->leftJoin('general_customers', 'videosurveillance_projects.general_customer_id', '=', 'general_customers.general_customer_id')
            ->leftJoin('general_companies', 'videosurveillance_projects.general_company_id', '=', 'general_companies.general_company_id')
            ->leftJoin('users', 'videosurveillance_projects.general_employee_id', '=', 'users.id')
            ->get();
            return $g;
        }
        
        function getUpgrades($projectid) {
        $g = \DB::table('videosurveillance_upgrades')
              ->where('videosurveillance_project_id', '=', $projectid)
              ->get();
        return $g;
        }
        function getProducts($orderid) {                          
            $g = \DB::table('orders_products')
                  ->where('order_id', '=', $orderid)
                  ->leftJoin('store_products', 'orders_products.product_id', '=', 'store_products.product_id')
                  ->leftJoin('store_products_bmd', 'store_products.product_bmd_id', '=', 'store_products_bmd.product_bmd_id')
                  ->leftJoin('store_products_categories', 'store_products_bmd.product_category_id', '=', 'store_products_categories.product_category_id')
                  ->get();
            return $g;
        }
        function getServices($orderid) {
            $g = \DB::table('orders_services')
                    ->where('order_id', '=', $orderid)
                    ->leftJoin('store_services', 'orders_services.service_id', '=', 'store_services.service_id')
                    ->leftJoin('store_services_categories', 'store_services.service_category_id', '=', 'store_services_categories.services_category_id')
                    ->get();
            return $g;
        }
    }
    
    public function storeProject() {
        $authid = \Auth::id();
        $now = date('Y-m-d');
        \DB::insert('INSERT INTO videosurveillance_projects'
                    . '(general_employee_id, videosurveillance_project_startdate, videosurveillance_project_enddate, videosurveillance_project_added) '
                    . 'VALUES (?, ?, ?, ?)', 
                    [$authid, $now, $now, $now]
                    );
        
    }
    public function storeProjectUpgrade($data) {
        $authid = \Auth::id();
        $now = date('Y-m-d');
        $projectid = $data['project_id'];
        $startdate = date("Y-m-d", strtotime($data['videosurveillance_upgrade_startdate']));
        $enddate = date("Y-m-d", strtotime($data['videosurveillance_upgrade_enddate']));
        \DB::insert('INSERT INTO videosurveillance_upgrades'
                    . '('
                    . 'general_employee_id,'
                    . 'videosurveillance_project_id,'
                    . 'videosurveillance_upgrade_description,'
                    . 'videosurveillance_upgrade_startdate,'
                    . 'videosurveillance_upgrade_enddate,'
                    . 'videosurveillance_upgrade_added'
                    . ') '
                    . 'VALUES (?, ?, ?, ?, ?, ?)', 
                    [$authid,
                    $projectid,
                    $data['videosurveillance_upgrade_description'],
                    $startdate,
                    $enddate,
                    $now]
                    );
    }
    public function updateProjectUpgrade($data) {
        $upgradeid = $data['update_id'];
        $startdate = date("Y-m-d", strtotime($data['videosurveillance_upgrade_startdate']));
        $enddate = date("Y-m-d", strtotime($data['videosurveillance_upgrade_enddate']));
        \DB::table('videosurveillance_upgrades')
                ->where('videosurveillance_upgrade_id', '=', $upgradeid)
                ->update([
                        'videosurveillance_upgrade_description' => $data['videosurveillance_upgrade_description'],
                        'videosurveillance_upgrade_startdate' => $startdate,
                        'videosurveillance_upgrade_enddate' => $enddate
                        ]);
    }
    
    
    public function storeOrderToProject($data, $orderid) {
        \DB::table('videosurveillance_projects')
            ->where('videosurveillance_project_id', '=', $data['project_id'])
            ->update(['orders_order_id' => $orderid]);
    }
    public function storeOrderToProjectUpgrade($data, $orderid) {
        \DB::table('videosurveillance_upgrades')
            ->where('videosurveillance_upgrade_id', '=', $data['upgrade_id'])
            ->update(['orders_order_id' => $orderid]);
    }
    public function storeNewOrderToProject() {
        $authid = \Auth::id();
        $now = date('Y-m-d');
        \DB::insert('INSERT INTO orders_orders'
                    . '(general_employee_id, order_added)'
                    . 'VALUES (?, ?)', 
                    [$authid,
                     $now]
                    );  
    }
    public function storeNewOrderToProjectUpgrade() {
        $authid = \Auth::id();
        $now = date('Y-m-d');
        \DB::insert('INSERT INTO orders_orders'
                    . '(general_employee_id, order_added)'
                    . 'VALUES (?, ?)', 
                    [$authid,
                     $now]
                    );  
    }
    public function updateProject($data) {
        $projectid = $data['update_id'];
        $startdate = date("Y-m-d", strtotime($data['videosurveillance_project_startdate']));
        $enddate = date("Y-m-d", strtotime($data['videosurveillance_project_enddate']));
        \DB::table('videosurveillance_projects')
            ->where('videosurveillance_project_id', '=', $projectid)
            ->update([
                'videosurveillance_project_dvr_name' => $data['videosurveillance_project_dvr_name'],
                'videosurveillance_project_dvr_password' => $data['videosurveillance_project_dvr_password'],
                'videosurveillance_project_ip_domain' => $data['videosurveillance_project_ip_domain'],
                'videosurveillance_project_mac_address' => $data['videosurveillance_project_mac_address'],
                'videosurveillance_project_description' => $data['videosurveillance_project_description'],
                'videosurveillance_project_coordinates' => $data['videosurveillance_project_coordinates'],
                'videosurveillance_project_startdate' => $startdate,
                'videosurveillance_project_enddate' => $enddate,
                ]);
    }
    public function storeCustomerToProject($data) {
        $projectid = $data['update_id'];
        $explode = $data['customer_id'];
        $array = explode(" -", $explode, 2);
        $result = $array[0];
        \DB::table('videosurveillance_projects')
            ->where('videosurveillance_project_id', '=', $projectid)
            ->update(['general_customer_id' => $result]);
    }
    public function storeCompanyToProject($data) {
        $projectid = $data['update_id'];
        $explode = $data['company_id'];
        $array = explode(" -", $explode, 2);
        $result = $array[0];
        \DB::table('videosurveillance_projects')
            ->where('videosurveillance_project_id', '=', $projectid)
            ->update(['general_company_id' => $result]);
    }
}
