<?php

namespace App\Http\Controllers;


use App\Orders;
use App\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller {
// GET ALL ORDERS
    public function getOrders() {
        if(\Auth::user()) {
            $all = new Orders();
            $all->getOrders();
            return view('orders');
        } else {
            return redirect('/login');
        }
    }
// GET ORDER BY ID
    public function getOrder($orderid) {
        if(\Auth::user()) {
            $all = new Orders();
            $all->getOrder($orderid);
            return view('order', ['orderid' => $orderid]);
        } else {
            return redirect('/login');
        }
    }
    
    public function storeNewOrder(Request $request){
        if(\Auth::user()) {
            $store = new Orders();
            $data = $request->all();
            $store->storeNewOrder($data);
            $orderid = \DB::getPdo()->lastInsertId();
            return redirect('/order/'.$orderid);
        } else {
            return redirect('/login');
        }
    }
    public function storeCompanyToOrder(Request $request) {
        $store = new Orders();
        $data = $request->all();
        $store->storeCompanyToOrder($data);
        $orderid = $data['update_id'];
        return redirect('/order/'.$orderid);
    }
    public function storeCustomerToOrder(Request $request) {
        $store = new Orders();
        $data = $request->all();
        $store->storeCustomerToOrder($data);
        $orderid = $data['update_id'];
        return redirect('/order/'.$orderid);
    }
    public function storeProductsToOrder(Request $request) {
        $o = new Orders();
        $data = $request->all();
        $p = new Products();
        $quantity = $p->avaliableProducts($data['productid']);
        if($data['orders_products_soldquantity'] > $quantity) {
            return redirect()->back()->withErrors('НЕ Е ПОЗВОЛЕНО ДА ПРОДАВАТЕ ПОВЕЧЕ БРОЙКИ ОТ НАЛИЧНИТЕ !');
        } else {
        $o->storeProductsToOrder($data);
        $p->productIsActive($data['productid']);
        return redirect()->back();
        }
    }
    public function storeServicesToOrder(Request $request) {
        $store = new Orders();
        $data = $request->all();
        $store->storeServicesToOrder($data);
        $orderid = $data['orderid'];
        return redirect('/order/'.$orderid);
    }
    public function updateOrder(Request $request) {
        $uo = new Orders();
        $uodata = $request->all();
        $uo->updateOrder($uodata);
        return redirect()->back();
    }
    public function updateOrderProduct(Request $request) {
        $update = new Orders();
        $p = new Products();
        $data = $request->all();
        $update->updateOrderProduct($data);
        $p->productIsActive($data['update_id']);
        $orderid = $data['orderid'];
        return redirect('/order/'.$orderid);
    }
    public function updateOrderService(Request $request) {
        $update = new Orders();
        $data = $request->all();
        $update->updateOrderService($data);
        $orderid = $data['orderid'];
        return redirect('/order/'.$orderid);
    }
    public function returnOrderProduct(Request $request) {
        $update = new Orders();
        $p = new Products();
        $data = $request->all();
        $update->returnOrderProduct($data);
        $p->productIsActive($data['update_id']);
        $orderid = $data['orderid'];
        return redirect('/order/'.$orderid);
    }
    
    public function closeOrder($orderid) {
        $update = new Orders();
        $update->closeOrder($orderid);        
    }
}