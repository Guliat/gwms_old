<?php

Route::group(['middleware' => 'web'], function () {
    
    Route::auth();
    
    Route::get('/', 'DashboardController@gwmsredirect');
     
    Route::get('/dashboard', 'DashboardController@getDashboard');
    Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);  

// COSTS
    Route::get('/costs', 'CostsController@index');
    Route::get('/costs/add', 'CostsController@add');
    Route::get('/costs/edit/{cost_id}', 'CostsController@edit');
    Route::post('/costs/store', 'CostsController@store');
    Route::post('/costs/update/{cost_id}', 'CostsController@update'); 
    Route::post('/costs/delete/{cost_id}', 'CostsController@delete');
    Route::post('/costs/destroy/{cost_id}', 'CostsController@destroy');
    Route::post('/costs/payoutcash', 'CostsController@payoutcash');
    Route::post('/costs/payoutbank', 'CostsController@payoutbank');
    Route::post('/costs/payincash', 'CostsController@payincash');
    Route::post('/costs/payinbank', 'CostsController@payinbank');
    
    
// SETTINGS
    Route::get('/settings', 'SettingsController@index');
 
 

// VIDEOSURVEILLANCE
    Route::post('/gotovsproject', 'VideoSurveillanceController@goToVsProject');
    Route::get('/videosurveillance/', 'VideoSurveillanceController@getProjects');
    Route::get('/videosurveillance/project/{projectid}', 'VideoSurveillanceController@getProject');
    Route::post('/storevideosurveillance', 'VideoSurveillanceController@storeProject');
    Route::post('/storenewordertovideosurveillance', 'VideoSurveillanceController@storeNewOrderToProject');
    Route::post('/updatevideosurveillance', 'VideoSurveillanceController@updateProject');
    Route::post('/storecustomertoproject', 'VideoSurveillanceController@storeCustomerToProject');
    Route::post('/storecompanytoproject', 'VideoSurveillanceController@storeCompanyToProject');
    Route::post('/storevideosurveillanceupgrade', 'VideoSurveillanceController@storeProjectUpgrade');
    Route::post('/updatevideosurveillanceupgrade', 'VideoSurveillanceController@updateProjectUpgrade');
    Route::post('/storenewordertovideosurveillanceupgrade', 'VideoSurveillanceController@storeNewOrderToProjectUpgrade');        
    
// FEEDBACKS
    Route::get('/feedback', 'FeedbackController@index');
    Route::post('/storefeedback', 'FeedbackController@store');
    Route::post('/updatefeedback', 'FeedbackController@update');
    
// CUSTOMERS
    Route::get('/customers', 'CustomersController@customers');
    Route::get('/customer/{customerid}', 'CustomersController@customer');
    Route::post('/gotocustomer', 'CustomersController@goToCustomer');
    Route::post('/storecustomer', 'CustomersController@storeCustomer');
    Route::post('/updatecustomer', 'CustomersController@updateCustomer');
    
// COMPANIES
    Route::get('/companies', 'CompaniesController@all');
    Route::get('/company/{companyid}', 'CompaniesController@company');
    Route::get('/addcompany', 'CompaniesController@add');
    Route::post('/gotocompany', 'CompaniesController@gotocompany');
    Route::post('/storecompany', 'CompaniesController@store');
    Route::post('/updatecompany', 'CompaniesController@update');
    
 
    
// OWNCOMPANIES AND EMPLOYEES
    Route::get('/owncompanies', 'OwnCompaniesController@all');
    //OWNCOMPANIES
    Route::post('/storeowncompany', 'OwnCompaniesController@storeOwnCompany');
    Route::post('/updateowncompany', 'OwnCompaniesController@updateOwnCompany');
    Route::post('/removeowncompany', 'OwnCompaniesController@removeOwnCompany');
    // EMPLOYEES
    Route::post('/storeemployee', 'OwnCompaniesController@storeEmployee');
    Route::post('/updateemployee', 'OwnCompaniesController@updateEmployee');
    Route::post('/removeemployee', 'OwnCompaniesController@removeEmployee');
    
// COMPUTERS SERVICES
    Route::post('gotoservice', 'PCServicesController@goToService');
    Route::post('gotodevice', 'PCServicesController@goToDevice');
    Route::get('/pcs/active', 'PCServicesController@getServicesActive');
    Route::get('/pcs/pending', 'PCServicesController@getServicesPending');
    Route::get('/pcs/finished', 'PCServicesController@getServicesFinished');
    Route::get('/pcs/service/{serviceid}', 'PCServicesController@getService');
    Route::get('/pcs/service/print/{serviceid}', 'PCServicesController@printPCService');
    Route::post('/pcs/newpcservicefromcustomer', 'PCServicesController@newPCServiceFromCustomer');
    Route::post('/storenewpcservice', 'PCServicesController@storeNewPCService');
    Route::post('/updatepcsp', 'PCServicesController@updatePCServicePrice');
    Route::post('/updatepcpp', 'PCServicesController@updatePCPartsPrice');
    Route::post('/updatepcdp', 'PCServicesController@updatePCDiscountPrice');
    Route::post('/updatepcdesc', 'PCServicesController@updatePCDescription');
    Route::post('/updatepchiddesc', 'PCServicesController@updatePCHiddenDescription');
    Route::post('/updatepccomplaint', 'PCServicesController@updatePCComplaint');
    Route::post('/storepcserviceupdate', 'PCServicesController@storePCServiceUpdate');
    Route::post('/storenewpcservicetodevice', 'PCServicesController@storeNewPCServiceToDevice');
    Route::post('/updatebagpwrbat', 'PCServicesController@updatePCServiceBagPwrBat');
    Route::post('/completepcservice', 'PCServicesController@completePCService');
    Route::post('/storecustomertodevice', 'PCServicesController@storeCustomerToDevice');
    
    // COMPUTERS DEVICES
    Route::get('/pcs/devices', 'PCServicesController@getDevices');
    Route::get('/pcs/device/{deviceid}', 'PCServicesController@getDevice');
    Route::get('/pcs/newdevice', 'PCServicesController@newPCServiceDevice');
    Route::post('/storepcdevice', 'PCServicesController@storePCDevice'); 
    // COMPUTERS DEVICES CATEGORIES
    Route::get('/pcs/categories', 'PCServicesController@getCategories');
    Route::post('/storepcdcat', 'PCServicesController@storePCDCategory');
    Route::post('/updatepcdcat', 'PCServicesController@updatePCDCategory');
    // COMPUTERS DEVICES BRANDS MODELS
    Route::get('/pcs/brandsmodels', 'PCServicesController@getBrandsModels');
    Route::post('/storepcdbm', 'PCServicesController@storePCDBrandModel');
    Route::post('/updatepcdbm', 'PCServicesController@updatePCDBrandModel');
    
    
    
// STORE
    // PRODUCTS
    Route::get('/store', 'ProductsController@index');
    Route::get('/products/store/{storeid}', 'ProductsController@productsByStores');
    Route::get('/products/categories', 'ProductsController@getCategories');
    Route::get('/products/bmd', 'ProductsController@getBrandsModels');
    // SERVICES
    Route::get('/storeservices', 'StoreServicesController@getStoreServices');
    Route::post('/storestoreservicescategory', 'StoreServicesController@storeStoreServicesCategory');
    Route::post('/storestoreservice', 'StoreServicesController@storeStoreService');
    Route::post('/updatestoreservicescategory', 'StoreServicesController@updateStoreServicesCategory');
    Route::post('/updatestoreservice', 'StoreServicesController@updateStoreService');

        
        
    Route::post('/updateproduct', 'ProductsController@updateProduct');
    Route::post('/updatecategory', 'ProductsController@updateCategory');
    Route::post('/updateproductbmd', 'ProductsController@updateBMD');
    Route::post('/storeproductcategory', 'ProductsController@storeCategory');
    Route::post('/storeproductbmd', 'ProductsController@storeBMD');
    Route::post('/storeproduct', 'ProductsController@storeProduct');
    Route::post('/sellproduct', 'ProductsController@sell');
    
// ORDERS
    Route::get('/orders', 'OrdersController@getOrders');
    Route::get('/order/{orderid}', 'OrdersController@getOrder');
    Route::post('/storeneworder', 'OrdersController@storeNewOrder');
    Route::post('/storecompanytoorder', 'OrdersController@storeCompanyToOrder');
    Route::post('/storecustomertoorder', 'OrdersController@storeCustomerToOrder');
    Route::post('/storeproductstoorder', 'OrdersController@storeProductsToOrder');
    Route::post('/storeservicestoorder', 'OrdersController@storeServicesToOrder');
    Route::post('/updateorder', 'OrdersController@updateOrder');
    Route::post('/updateorderproduct', 'OrdersController@updateOrderProduct');
    Route::post('/updateorderservice', 'OrdersController@updateOrderService');
    Route::post('/returnorderproduct', 'OrdersController@returnOrderProduct');
    
// INVOICES
    // POST
    Route::post('/updateinvoicepayment', 'InvoicesController@updateInvoicePayment');
    Route::post('/updateinvoicepaid', 'InvoicesController@updateInvoicePaid'); 
    Route::post('/newinvoiceprefix', 'InvoicesController@newInvoicePrefix');
    Route::post('/storenewinvoiceprefix', 'InvoicesController@storeNewInvoicePrefix');
    Route::post('/newinvoice', 'InvoicesController@newInvoice');
    Route::post('/getinvoicesnumbers', 'InvoicesController@getInvoicesNumbers');
    Route::post('/getorders', 'InvoicesController@getOrders');
    Route::post('/storenewinvoice', 'InvoicesController@storeNewInvoice');
    Route::post('/storenewrecipienttoinvoice', 'InvoicesController@storeNewRecipient');
    Route::post('/searchinvoices', 'InvoicesController@searchInvoices');
    // GET
    Route::get('/invoices', 'InvoicesController@getInvoices');
    Route::get('/updateinvoice/{invoiceid}', 'InvoicesController@updateInvoice');
    Route::get('/invoice/{invoiceid}', 'InvoicesController@getInvoice');
    Route::get('/invoices/nonpaid', 'InvoicesController@getNonPaid');
    // SNAPSHOTS
    Route::post('/storeinvoicesnapshot', 'InvoicesController@storeInvoiceSnapshot');
    Route::get('/snapshotsave/{invoiceid}', 'InvoicesController@getSnapshotToSave');
    Route::get('/snapshot/{invoiceid}', 'InvoicesController@getInvoiceSnapshot');
    
    // TRANSLATORS
    Route::get('/translatedsnap',
        function(){ 
        $translated = $_GET['sl'];
        $invoiceid = $_GET['invoiceid'];
        Session::put('translated', $translated);
        return Redirect::to('/snapshotsave/'.$invoiceid);
    }); 
    Route::get('/translated',
        function(){ 
        $translated = $_GET['sl'];
        $invoiceid = $_GET['invoiceid'];
        Session::put('translated', $translated);
        return Redirect::to('/invoice/'.$invoiceid);
    }); 
    
//    Route::get('/pdf', 'InvoicesController@invoiceToPDF');  
});