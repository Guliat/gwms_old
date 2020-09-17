<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model {    
    public function productsByStores($storeid) {
        $g = \DB::table('store_products')
            ->where('store_id', '=', $storeid)
            ->where('product_isactive', '=', 1)
            ->leftJoin('store_products_bmd', 'store_products.product_bmd_id', '=', 'store_products_bmd.product_bmd_id')
            ->leftJoin('store_products_categories', 'store_products_bmd.product_category_id', '=', 'store_products_categories.product_category_id')
            #->leftJoin('store_stores', 'store_products.store_id', '=', 'store_stores.store_id')
            ->paginate(10);
        return $g;
    }
    public static function getStoreContent($storeid) {
        $g = \DB::table('store_stores')
            ->where('store_id', '=', $storeid)
            ->get();
        return $g;
    }
    public function avaliableProducts($productid) {
        $quantity = null;
        $sold = null;
        $products = \DB::table('store_products')
                ->where('product_id', '=', $productid)
                ->select('product_quantity')
                ->get();
        $soldquantity = \DB::table('orders_products')
                ->where('product_id', '=', $productid)
                ->select('orders_products_soldquantity')
                ->where('orders_products_isactive', '=', 1)
                ->get();
        foreach($products as $productsrows) { $quantity = $productsrows->product_quantity; }
        foreach($soldquantity as $soldrows) { $sold += $soldrows->orders_products_soldquantity; }
        $g = $quantity - $sold;
        return $g;
    }
    public static function avaliableProductsByStores($productid, $storeid = 1) {
        $quantity = null;
        $sold = null;
        $products = \DB::table('store_products')
                ->where('product_id', '=', $productid)
                ->where('store_id', '=', $storeid)
                ->select('product_quantity')
                ->get();
        $soldquantity = \DB::table('orders_products')
                ->where('product_id', '=', $productid)
                ->where('store_id', '=', $storeid)
                ->select('orders_products_soldquantity')
                ->where('orders_products_isactive', '=', 1)
                ->get();
        foreach($products as $productsrows) { $quantity = $productsrows->product_quantity; }
        foreach($soldquantity as $soldrows) { $sold += $soldrows->orders_products_soldquantity; }
        $g = $quantity - $sold;
        return $g;
    }
    public function productIsActive($productid) {
        $ava = $this->avaliableProducts($productid);
        if($ava == 0) { $this->disableProduct($productid);}
        if($ava > 0) { $this->enableProduct($productid);}
    }
    public function disableProduct($productid) {
        \DB::table('store_products')
        ->where('product_id', $productid)
        ->update(['product_isactive' => 0]);
    }
    public function enableProduct($productid) {
        \DB::table('store_products')
        ->where('product_id', $productid)
        ->update(['product_isactive' => 1]);    
    }
    public function sellProduct($data) {
        $authid = \Auth::id();
        $now = date('Y-m-d');
        
        $customertoexplode = $data['customer_id'];
        $customerarr = explode(" -", $customertoexplode, 2);
        $customerid = $customerarr[0];
        
        $companytoexplode = $data['company_id'];
        $companyarr = explode(" -", $companytoexplode, 2);
        $companyid = $companyarr[0];
        
        \DB::table('store_products')
              ->where('product_id', $data['update_id'])
              ->update([
                        'customer_id' => $data['customer_id'],
                        'company_id' => $data['company_id'],
                        'product_soldprice' => str_replace(',', '.',$data['product_soldprice']),
                        'product_soldby' => $authid,
                        'product_sold' => $now,
                        'product_isactive' => 0,
                        ]);
    }
    public function updateProduct($data) {
        \DB::table('store_products')
                ->where('product_id', $data['update_id'])
                ->update([
                    'product_category_id' => $data['product_category_id'],
                    'product_bmd_id' => $data['product_bmd_id'],
                    'product_sellprice' => str_replace(',', '.',$data['product_sellprice']),
                ]);
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
        function getCategories() {
            $g = \DB::table('store_products_categories')
                ->leftJoin('users', 'store_products_categories.general_employee_id', '=', 'users.id')
                ->get();  
            return $g;
        }
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
        function getBMDCategories() {
            $g = \DB::table('store_products_categories')
                 ->select('product_category_id', 'product_category')
                 ->get();  
            return $g;
        }
        function getBrandsModels() {
            $g = \DB::table('store_products_bmd')
                 ->leftJoin('users', 'store_products_bmd.general_employee_id', '=', 'users.id')
                 ->leftJoin('store_products_categories', 'store_products_bmd.product_category_id', '=', 'store_products_categories.product_category_id')
                 ->paginate(10);
            return $g;
        }
    }   
// STORE FUNCTIONS
    public function storeProduct($data) {
        $authid = \Auth::id();
        $now = date('Y-m-d');
        $providertoexplode = $data['providerid'];
        $providerarr = explode(" -", $providertoexplode, 2);
        $providerid = $providerarr[0];
        
        $bmdctoexplode = $data['bmdcid'];
        $bmdcarr = explode(" -", $bmdctoexplode, 2);
        $bmdcid = $bmdcarr[0];
        
        $buyprice = str_replace(',', '.', $data['product_buyprice']);
        $sellprice = str_replace(',', '.',$data['product_sellprice']);
        
                
        
        \DB::insert('INSERT INTO store_products (general_employee_id, general_company_id, product_bmd_id, product_buyprice, product_sellprice, product_serialnumber, product_quantity, product_delivered)'
                . 'VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
                [$authid, $providerid, $bmdcid, $buyprice, $sellprice, $data['product_serialnumber'], $data['product_quantity'], $now]);
    }   
    public function storeBMD($data) {
        $authid = \Auth::id();
        $now = date('Y-m-d');
        $rules = array('product_brandmodel' => 'required|min: 3');
        $validator = \Illuminate\Support\Facades\Validator::make($data, $rules);
        if ($validator->fails()) {
            $messages = $validator->messages();
            return redirect('/products/bmd')->withErrors($validator)->withInput();
        } else {
            \DB::insert('INSERT INTO store_products_bmd'
                        . ' ('
                    . 'general_employee_id,'
                    . 'product_category_id,'
                    . 'product_brandmodel,'
                    . 'product_number,'
                    . 'product_description,'
                    . 'product_bmd_added'
                    . ')'
                    . 'VALUES (?, ?, ?, ?, ?,?)',
                    [
                        $authid,
                        $data['product_category_id'],
                        $data['product_brandmodel'],
                        $data['product_number'],
                        $data['product_description'],
                        $now
                    ]);
        }
    }
    public function storeCategory($data) {
        $authid = \Auth::id();
        $now = date('Y-m-d');
        $rules = array(
            'product_category' => 'required|min: 3',
        );
        $validator = \Illuminate\Support\Facades\Validator::make($data, $rules);
        if ($validator->fails()) {
            $messages = $validator->messages();
            return redirect('/products/categories')->withErrors($validator)->withInput();
        } else {
            \DB::insert('INSERT INTO store_products_categories'
                    . '('
                    . 'general_employee_id,'
                    . 'product_category,'
                    . 'product_category_added'
                    . ')'
                    . 'VALUES (?, ?, ?)',
                    [
                    $authid,
                    $data['product_category'],
                    $now
                    ]);
        }
    }
// UPDATE FUNCTIONS   
    public function updateCategory($data) {
        $rules = array(
            'product_category' => 'required|min: 3',
        );
        $validator = \Illuminate\Support\Facades\Validator::make($data, $rules);
        if ($validator->fails()) {
            $messages = $validator->messages();
            return redirect('/products/categories')->withErrors($validator)->withInput();
        } else {
        \DB::table('store_products_categories')
                ->where('product_category_id', $data['update_id'])
                ->update([
                    'product_category' => $data['product_category']
                ]);
        }
    } 
    public function updateBMD($data) {
        $rules = array(
            'product_brandmodel' => 'required|min: 3',
        );
        $validator = \Illuminate\Support\Facades\Validator::make($data, $rules);
        if ($validator->fails()) {
            $messages = $validator->messages();
            return redirect('/products/bmd')->withErrors($validator)->withInput();
        } else {
        \DB::table('store_products_bmd')
                ->where('product_bmd_id', $data['update_id'])
                ->update([
                    'product_category_id' => $data['product_category_id'],
                    'product_brandmodel' => $data['product_brandmodel'],
                    'product_number' => $data['product_number'],
                    'product_description' => $data['product_description']
                ]);
        }
    }
}


        