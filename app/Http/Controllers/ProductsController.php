<?php

namespace App\Http\Controllers;

use App\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller {
    public function index() {
        if(\Auth::user()) {
            
            $productid = null;
            $availability = null;
            $getProducts = \DB::table('store_products')
                         ->where('product_isactive', '=', 1)
                         ->leftJoin('store_products_bmd', 'store_products.product_bmd_id', '=', 'store_products_bmd.product_bmd_id')
                         ->leftJoin('store_products_categories', 'store_products_bmd.product_category_id', '=', 'store_products_categories.product_category_id')
                         ->leftJoin('store_stores', 'store_products.store_id', '=', 'store_stores.store_id')
                           #->leftJoin('orders_products', 'products.product_id', '=', 'orders_products.product_id')
                         ->paginate(10);
            
            $getBMD = \DB::table('store_products_bmd')
                         ->select('product_brandmodel', 'product_bmd_id')
                         ->get();
            
            $getCat = \DB::table('store_products_categories')
                         ->select('product_category', 'product_category_id')
                         ->get();
            
            $ava = null;
            $a = null;
           
                foreach($getProducts as $getProductID) {
                $productid = $getProductID->product_id;

                $getOrdersProducts = \DB::table('orders_products')
                                     ->select('orders_products_soldquantity')
                                     ->where('product_id', '=', $productid)
                                     ->where('orders_products_isactive', '=', 1)
                                     ->get();

                $a = null;
                foreach ($getOrdersProducts as $getOrdersProduct)
                {
                    $a += $getOrdersProduct->orders_products_soldquantity;

                }

                $availability = $getProductID->product_quantity - $a;


                $ava[$productid] = $availability;

                }

            
            
            
            return view('products', ['getProducts' => $getProducts, 'getBMD' => $getBMD, 'getCat' => $getCat, 'ava' => $ava, 'a' => $a]);
        }
        else {
            return redirect('/login');
        }
    }
    public function productsByStores($storeid) {
        if(\Auth::user()) {
            $g = new Products();
            $data = $g->productsByStores($storeid);
            return view('products_by_stores', ['data' => $data, 'storeid' => $storeid]);
        } else {
            return redirect('/login');
        }   
    }
    public function getCategories() {
        if(\Auth::user()) {
            $g = new Products();
            $g->getCategories();
        return view('products_categories');
        } else {
            return redirect('/login');
        }
    }
    public function getBrandsModels() {
        if(\Auth::user()) {
            $g = new Products();
            $g->getBrandsModels();
            return view('products_bmd');
        } else {
            return redirect('/login');
        }
    }
    public function sell(Request $request) {
        if(\Auth::user()) {
            $sell = new Products();
            $data = $request->all();
            $sell->sellProduct($data);
            return redirect('/products');
        }
        else {
            return redirect('/login');
        }
    }  
/// STORE FUNCTIONS 
    public function storeProduct(Request $request) {
        if(\Auth::user()) {
            $store = new Products();
            $data = $request->all();
            $store->storeProduct($data);
            return redirect('/store');
        }
        else {
            return redirect('/login');
        }
    }
    public function storeCategory(Request $request) {
        if(\Auth::user()) {
            $store = new Products();
            $data = $request->all();
            $store->storeCategory($data);
            return redirect('/products/categories');
        }
        else {
            return redirect('/login');
        }
    }
    public function storeBMD(Request $request) {
        if(\Auth::user()) {
            $store = new Products();
            $data = $request->all();
            $store->storeBMD($data);
            return redirect('/products/bmd');
        }
        else {
            return redirect('/login');
        }
    }
// UPDATE FUNCTIONS
    public function updateCategory(Request $request) {
        if(\Auth::user()) {
            $update = new Products();
            $data = $request->all();
            $update->updateCategory($data);
            return redirect('/products/categories');
        }
        else {
            return redirect('/login');
        }
    }
    public function updateBMD(Request $request) {
        if(\Auth::user()) {
            $update = new Products();
            $data = $request->all();
            $update->updateBMD($data);
            return redirect('/products/bmd');
        }
        else {
            return redirect('/login');
        }
    }
    public function updateProduct(Request $request) {
        if(\Auth::user()) {
            $update = new Products();
            $data = $request->all();
            $update->updateProduct($data);
            return redirect('/products');
        }
        else {
            return redirect('/login');
        }
    }
}