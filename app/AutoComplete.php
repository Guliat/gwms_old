<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AutoComplete extends Model
{    
    public function providertoproduct() {
        $getProviders = \DB::table('general_companies')
                         ->where('general_company_isprovider', '=', 1)
                         ->get();
        if(!empty($getProviders)) {
            foreach($getProviders as $providersRow)
            {
             $providers_list[] = $providersRow->general_company_id.' - '.$providersRow->general_company_number.' - '.$providersRow->general_company_name.' - '.$providersRow->general_company_address.' - '.$providersRow->general_company_owner;
            }
            echo json_encode($providers_list);
        }
    }
    
    public function customers() {
        $getCustomers = \DB::select("select * from general_customers");
        if(!empty($getCustomers)) {
            foreach($getCustomers as $customersRow) {
             $customers_list[] = $customersRow->general_customer_id.' - '.
                                 $customersRow->general_customer_names.' - '.
                                 $customersRow->general_customer_nick.' - '.
                                 $customersRow->general_customer_phone.' '.
                                 $customersRow->general_customer_phone2;
            }
            echo json_encode($customers_list);
        }
    }
    public function vsprojects() {
        $getProjects = \DB::select("select * from videosurveillance_projects");
        if(!empty($getProjects)) {
            foreach($getProjects as $getProjectsRows) {
             $projects_list[] = $getProjectsRows->videosurveillance_project_id.' - '.
                                 $getProjectsRows->videosurveillance_project_dvr_name.' - '.
                                 $getProjectsRows->videosurveillance_project_description;
            }
            echo json_encode($projects_list);
        }
    }
    public function companies() {
        $getCompanies = \DB::table('general_companies')
                         ->select('general_company_id', 'general_company_name', 'general_company_number', 'general_company_owner', 'general_company_address')
                         ->get();
        if(!empty($getCompanies)) {
            foreach($getCompanies as $companiesRow) {
            $companies_list[] = $companiesRow->general_company_id.' - '.
                                $companiesRow->general_company_name.' - '.
                                $companiesRow->general_company_number.' - '.
                                $companiesRow->general_company_owner.' - '.
                                $companiesRow->general_company_address;
            }
            echo json_encode($companies_list);
        }
    }
    public function PCDBrandsModels() {
        $PCDBrandsModels = \DB::table('computers_devices_bm')
                         ->leftJoin('computers_devices_categories', 'computers_devices_bm.computers_device_category_id', '=', 'computers_devices_categories.computers_device_category_id')
                         ->get();
        foreach($PCDBrandsModels as $PCDBrandsModelsRows) {
        $brandsmodelslist[] = $PCDBrandsModelsRows->computers_device_bm_id.' - '.
                              $PCDBrandsModelsRows->computers_device_category.' - '.
                              $PCDBrandsModelsRows->computers_device_brandmodel;
        }
        echo json_encode($brandsmodelslist);
    }
    
    public function products() {
        $getProducts = \DB::table('store_products')
                         ->where('product_isactive', '=', 1)
                         ->leftJoin('store_products_bmd', 'store_products.product_bmd_id', '=', 'store_products_bmd.product_bmd_id')
                         ->leftJoin('store_products_categories', 'store_products_bmd.product_category_id', '=', 'store_products_categories.product_category_id')
                         ->get();
        if(!empty($getProducts)) {                        
            foreach($getProducts as $productsRow)
            {

            $av = new Products();
            $ava = $av->avaliableProducts($productsRow->product_id);
            $products_list[] = $productsRow->product_id.' - '.$productsRow->product_number.' / '.$productsRow->product_category.' / '.$productsRow->product_brandmodel.' / '.$productsRow->product_serialnumber.' / '.$productsRow->product_sellprice.'лв / '.$ava.' налични';
            }
            echo json_encode($products_list);
        }
    }
    
    public function newproduct() {
        $getBrandModelsCategories = \DB::table('store_products_bmd')
                                    ->leftJoin('store_products_categories', 'store_products_bmd.product_category_id', '=', 'store_products_categories.product_category_id')
                                    ->get();
                                 
        foreach($getBrandModelsCategories as $bmdcrows)
        {
         $products_list[] = $bmdcrows->product_bmd_id.' - '.$bmdcrows->product_number.' - '.$bmdcrows->product_category.' - '.$bmdcrows->product_brandmodel;
        }
        echo json_encode($products_list);
    }
    
    public function services() {
        $getServices = \DB::table('store_services')
                         ->get();
                                 
        foreach($getServices as $servicesRow)
        {
         $services_lsit[] = $servicesRow->service_id.' - '.$servicesRow->service;
        }
        echo json_encode($services_lsit);
    }
    
    public function computersdevicesbrandmodel() {
        $getComputersDevicesBM = \DB::select("SELECT computers_device_brandmodel FROM computers_devices_bm");
        foreach($getComputersDevicesBM as $getComputersDevicesBMRows)
        {
            $computersdevicesbrandmodel_list[] = $getComputersDevicesBMRows->computers_device_brandmodel;
        }
        echo json_encode($computersdevicesbrandmodel_list);
    }
}