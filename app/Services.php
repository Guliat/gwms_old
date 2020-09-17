<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Services extends Model {
    
    public function getServices() {
        function getServices(){
            $g = \DB::table('store_services')
                 ->leftJoin('store_services_categories', 'store_services.service_category_id', '=', 'store_services_categories.services_category_id')
                 ->paginate(10);
            return $g;
        }
        function getCategories() {
            $g = \DB::table('store_services_categories')
                 ->get();
            return $g;
        }
    }
    
    
    
    
}