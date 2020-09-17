<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class StoreServices extends Model { 
    public function getStoreServices(){
        $g = DB::table('store_services')
             ->leftJoin('store_services_categories', 'store_services.service_category_id', '=', 'store_services_categories.services_category_id')
             ->paginate(10);
        return $g;
    }
    public function getStoreServicesCategories() {
        $g = DB::table('store_services_categories')
             ->get();
        return $g;
    }
    public function storeStoreService($data) {
        $authid = \Auth::id();
        $now = date('Y-m-d');
        DB::insert('INSERT INTO store_services'
                  .'(general_employee_id, service_category_id, service, service_price, service_quantity_type, service_added)'
                  .'VALUES (?, ?, ?, ?, ?, ?)',
                  [$authid, $data['categoryid'], $data['service'] ,$data['price'], $data['quantitytype'], $now]
                  );
    }
    public function storeStoreServicesCategory($data) {
        $authid = \Auth::id();
        $now = date('Y-m-d');
        DB::insert('INSERT INTO store_services_categories'
                  .'(general_employee_id, services_category, services_category_added)'
                  .'VALUES (?, ?, ?)',
                  [$authid, $data['category'], $now]
                  );
    }
    public function updateStoreService($data) {
        DB::table('store_services')
          ->where('service_id', '=', $data['serviceid'])
          ->update([
                    'service_category_id' => $data['categoryid'],
                    'service' => $data['service'],
                    'service_price' => $data['price']
                   ]);
    }
    public function updateStoreServicesCategory($data) {
        DB::table('store_services_categories')
          ->where('services_category_id', '=', $data['categoryid'])
          ->update([
                    'services_category' => $data['category'],
                   ]);
    } 
}