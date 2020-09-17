<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model {
    static public function getQuantityTypes() {
        $g = \DB::table('store_quantity_types')
                ->get();
        return $g;
    }
}