<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Invoices extends Model {
    
    public function updateInvoicePaid($data) { 
        \DB::table('orders_invoices')
            ->where('orders_invoice_id', '=', $data['invoiceid'])
            ->update(['orders_invoice_ispaid' => 1]);
    }
    public function getInvoicesByNumber($invocieid) {
        $g = \DB::table('orders_invoices')
            ->leftJoin('general_customers', 'orders_invoices.general_customer_id', '=', 'general_customers.general_customer_id')
            ->leftJoin('general_companies', 'orders_invoices.general_company_id', '=', 'general_companies.general_company_id')
            ->leftJoin('general_owncompanies', 'orders_invoices.general_owncompany_id', '=', 'general_owncompanies.general_owncompany_id')
            ->leftJoin('orders_invoices_prefixes', 'orders_invoices.orders_invoice_prefix_id', '=', 'orders_invoices_prefixes.orders_invoices_prefix_id')
            ->where('orders_invoice_number', 'like', '%' . $invocieid . '%')
            ->orderBy('orders_invoice_date', 'DESC')
            ->get();
        return $g;
    }
    public function getInvoicesByDate($date) {
        $g = \DB::table('orders_invoices')
            ->where('orders_invoice_date', '=', $date)
            ->leftJoin('general_customers', 'orders_invoices.general_customer_id', '=', 'general_customers.general_customer_id')
            ->leftJoin('general_companies', 'orders_invoices.general_company_id', '=', 'general_companies.general_company_id')
            ->leftJoin('general_owncompanies', 'orders_invoices.general_owncompany_id', '=', 'general_owncompanies.general_owncompany_id')
            ->leftJoin('orders_invoices_prefixes', 'orders_invoices.orders_invoice_prefix_id', '=', 'orders_invoices_prefixes.orders_invoices_prefix_id')
            ->orderBy('orders_invoice_date', 'DESC')
            ->get();
        return $g;
    }
    public function getInvoicesByCompany($companyid) {
        $g = \DB::table('orders_invoices')
            ->where('general_company_id', '=', $companyid)
            ->leftJoin('general_owncompanies', 'orders_invoices.general_owncompany_id', '=', 'general_owncompanies.general_owncompany_id')
            ->leftJoin('orders_invoices_prefixes', 'orders_invoices.orders_invoice_prefix_id', '=', 'orders_invoices_prefixes.orders_invoices_prefix_id')
            ->orderBy('orders_invoice_date', 'DESC')
            ->get();
        return $g;
    }
    public function getInvoicesByCustomer($customerid) {
        $g = \DB::table('orders_invoices')
            ->where('general_customer_id', '=', $customerid)
            ->leftJoin('general_owncompanies', 'orders_invoices.general_owncompany_id', '=', 'general_owncompanies.general_owncompany_id')
            ->leftJoin('orders_invoices_prefixes', 'orders_invoices.orders_invoice_prefix_id', '=', 'orders_invoices_prefixes.orders_invoices_prefix_id')
            ->orderBy('orders_invoice_date', 'DESC')
            ->get();
        return $g;
    }
    public function getInvoicesContent() {
        $g = \DB::table('orders_invoices')
            ->leftJoin('general_customers', 'orders_invoices.general_customer_id', '=', 'general_customers.general_customer_id')
            ->leftJoin('general_companies', 'orders_invoices.general_company_id', '=', 'general_companies.general_company_id')
            ->leftJoin('orders_invoices_prefixes', 'orders_invoices.orders_invoice_prefix_id', '=', 'orders_invoices_prefixes.orders_invoices_prefix_id')
            ->orderBy('orders_invoice_number', 'dsc')
            ->get();
        return $g;
    }
    public function getInvoiceContent($invoiceid) {
        $g = \DB::table('orders_invoices')
            ->where('orders_invoice_id', '=', $invoiceid)
            ->leftJoin('general_customers', 'orders_invoices.general_customer_id', '=', 'general_customers.general_customer_id')
            ->leftJoin('general_companies', 'orders_invoices.general_company_id', '=', 'general_companies.general_company_id')
            ->leftJoin('orders_invoices_prefixes', 'orders_invoices.orders_invoice_prefix_id', '=', 'orders_invoices_prefixes.orders_invoices_prefix_id')
            ->get();
        return $g;
    }
    public function storeNewRecipient($data) {
        \DB::table('orders_invoices')
            ->where('orders_invoice_id', '=', $data['invoiceid'])
            ->update(['orders_invoice_recipient' => $data['recipient']]);
    }
    public function updateInvoicePayment($data) {
        \DB::table('orders_invoices')
            ->where('orders_invoice_id', '=', $data['invoiceid'])
            ->update(['orders_invoice_isbank' => $data['payment']]);
    }
    public function storeNewInvoice($data) {
        $authid = \Auth::id();
        $now = date('Y-m-d');
        $customerid = $data['general_customer_id'];
        if(!empty($data['orders_invoice_date'])) {
            $invoicedate = date("Y-m-d", strtotime($data['orders_invoice_date']));
        } else {
            $invoicedate = $now;
        }
        $companyid = $data['general_company_id'];
        $owncompanyid = $data['general_owncompany_id'];
        $orderid = $data['orderid'];
        
        $prefixid = $data['fullnumber'][0];
        
        $invoicenumber = substr($data['fullnumber'], 1) + 1;
        
        $invoicetotal = $data['invoicetotal']*$data['orders_invoice_tax'];
        // TODO
        $invoiceisbank = $data['payment'];
        if($data['owner'] != $data['recipient']) {
            $recipient = $data['recipient'];
        } else {
            $recipient = null;
        }
        \DB::insert('INSERT INTO orders_invoices'
                    . '('
                    . 'general_employee_id,'
                    . 'general_customer_id,'
                    . 'general_company_id,'
                    . 'general_owncompany_id,'
                    . 'orders_order_id,'
                    . 'orders_invoice_prefix_id,'
                    . 'orders_invoice_number,'
                    . 'orders_invoice_tax,'
                    . 'orders_invoice_recipient,'
                    . 'orders_invoice_customrow,'
                    . 'orders_invoice_total,'
                    . 'orders_invoice_isbank,'
                    . 'orders_invoice_date,'
                    . 'orders_invoice_added'
                    . ') '
                    . 'VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', 
                    [$authid,
                    $customerid,
                    $companyid,
                    $owncompanyid,
                    $orderid,
                    $prefixid,
                    $invoicenumber,
                    $data['orders_invoice_tax'],
                    $recipient,
                    $data['customrow'],
                    $invoicetotal,
                    $invoiceisbank,
                    $invoicedate,   
                    $now]
                    );
    }
    public function storeInvoiceSnapshot($data) {
        $now = date('Y-m-d');
        \DB::insert('INSERT INTO orders_invoices_snapshots'
                    . '(orders_invoice_snapshot, orders_invoice_id, orders_invoice_snapshot_added)'
                    . 'VALUES (?, ?, ?)', 
                    [$data['invoice_snapshot'], $data['invoiceid'], $now]
                    );
    }
    public function getInvoiceSnapshot($invoiceid) {
        $g = \DB::table('orders_invoices_snapshots')
            ->where('orders_invoice_id', '=', $invoiceid)
            ->get();
        return $g;        
    }
    public function getPrefixes($owncompanyid) {
        $g = \DB::table('orders_invoices_prefixes')
                ->where('general_owncompany_id', '=', $owncompanyid)
                ->get();
        return $g;
    }
    
    public function getInvoiceContentByPrefix($prefixid) { // TODO Invoice >>> Invoices
        $g = \DB::table('orders_invoices')
            ->where('orders_invoice_prefix_id', '=', $prefixid)
            ->leftJoin('general_companies', 'orders_invoices.general_company_id', '=', 'general_companies.general_company_id')
            ->leftJoin('general_customers', 'orders_invoices.general_customer_id', '=', 'general_customers.general_customer_id')
            ->leftJoin('orders_invoices_prefixes', 'orders_invoices.orders_invoice_prefix_id', '=', 'orders_invoices_prefixes.orders_invoices_prefix_id')
            ->orderBy('orders_invoice_number', 'dsc')->limit('10')->get();
        return $g; 
    }
    
        public function getInvoiceContentByPrefixNonPaid($prefixid) { // TODO Invoice >>> Invoices
        $g = \DB::table('orders_invoices')
            ->where('orders_invoice_prefix_id', '=', $prefixid)
            ->where('orders_invoice_ispaid', 0)
            ->leftJoin('general_companies', 'orders_invoices.general_company_id', '=', 'general_companies.general_company_id')
            ->leftJoin('general_customers', 'orders_invoices.general_customer_id', '=', 'general_customers.general_customer_id')
            ->leftJoin('orders_invoices_prefixes', 'orders_invoices.orders_invoice_prefix_id', '=', 'orders_invoices_prefixes.orders_invoices_prefix_id')
            ->orderBy('orders_invoice_number', 'dsc')->limit('10')->get();
        return $g; 
    }
    
    public function getInvoiceOrder($orderid) {
        $g = \DB::table('orders_orders')
             ->where('order_id', '=', $orderid)
             ->get();
        return $g;
    }
    public function getOrderProducts($invoiceid) {
        $g = \DB::table('orders_products')
             ->where('order_id', '=', $invoiceid)
             ->where('orders_products_isactive', '=', 1)
             ->leftJoin('store_products', 'orders_products.product_id', '=', 'store_products.product_id')
             ->leftJoin('store_products_bmd', 'store_products.product_bmd_id', '=', 'store_products_bmd.product_bmd_id')
             ->leftJoin('store_products_categories', 'store_products_bmd.product_category_id', '=', 'store_products_categories.product_category_id')
             ->get();
        return $g;
    }
    public function getOrderServices($orderid) {
        $g = \DB::table('orders_services')
             ->where('order_id', '=', $orderid)
             ->leftJoin('store_services', 'orders_services.service_id', '=', 'store_services.service_id')
             ->get();
        return $g;
    }
    public function getCompany($companyid) { // TODO da si gi zwima ot kontrolera za companies
        $g = \DB::table('general_companies')
             ->where('general_company_id', '=', $companyid)
             ->get();
        return $g;   
    }
    public function getCustomer($customerid) { // TODO da si gi zwima ot kontrolera za customers
        $g = \DB::table('general_customers')
             ->where('general_customer_id', '=', $customerid)
             ->get();
        return $g;
    }
    public function getOwnCompany($companyid) { // TODO da si gi wzima ot kontrolera za owncompanies
        $g = \DB::table('general_owncompanies')
             ->where('general_owncompany_id', '=', $companyid)
             ->get();
        return $g;   
    }
    public function getOwnComapnies(){ 
        $g = \DB::table('general_owncompanies')
                ->get();
        return $g;
    }
    public function getTotal($invoiceid) {
            $g = \DB::table('orders_invoices')
                 ->where('orders_invoice_id', '=', $invoiceid)
                 ->select('orders_invoice_total')
                 ->get();
            return $g;     
        }
    public function getNumbersByPrefix($prefix) {
        $g = \DB::table('orders_invoices')
            ->where('orders_invoice_prefix_id', '=', $prefix)
            ->orderBy('orders_invoice_number', 'desc')
            ->limit(1)    
            ->get();
        return $g;
    }
    public function storeNewInvoicePrefix($data) {
        $authid = \Auth::id();
        $now = date('Y-m-d');
        \DB::insert('INSERT INTO orders_invoices_prefixes'
                    . '('
                    . 'general_employee_id,'
                    . 'general_owncompany_id,'
                    . 'orders_invoices_prefix,'
                    . 'orders_invoices_prefix_comment,'
                    . 'orders_invoices_prefix_added'
                    . ') '
                    . 'VALUES (?, ?, ?, ?, ?)', 
                    [$authid,
                    $data['general_owncompany_id'],
                    $data['orders_invoices_prefix'],
                    $data['orders_invoices_prefix_comment'],
                    $now]
                    );
    }
    public function storeFirstInvoiceToPrefix($data, $prefixid) {
        $authid = \Auth::id();
        $companyid = $data['general_company_id'];
        $invoicedate = date("Y-m-d", strtotime($data['orders_invoice_date']));
        $owncompanyid = $data['general_owncompany_id'];
        $orderid = $data['orderid'];
        $invoicetotal = $data['invoicetotal']*$data['orders_invoice_tax'];
        $invoiceisbank = $data['payment'];
        $recipient = $data['recipient'];
        $now = date('Y-m-d');
        \DB::insert('INSERT INTO orders_invoices'
                    . '('
                    . 'general_employee_id,'
                    . 'general_customer_id,'
                    . 'general_company_id,'
                    . 'general_owncompany_id,'
                    . 'orders_order_id,'
                    . 'orders_invoice_prefix_id,'
                    . 'orders_invoice_number,'
                    . 'orders_invoice_tax,'
                    . 'orders_invoice_total,'
                    . 'orders_invoice_isbank,'
                    . 'orders_invoice_recipient,'
                    . 'orders_invoice_customrow,'
                    . 'orders_invoice_date,'
                    . 'orders_invoice_added'
                    . ') '
                    . 'VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', 
                    [$authid,
                    0,
                    $companyid,
                    $owncompanyid,
                    $orderid,
                    $prefixid,
                    $data['firsttoprefix'],
                    $data['orders_invoice_tax'],
                    $invoicetotal,
                    $invoiceisbank,
                    $recipient,
                    $data['customrow'],
                    $invoicedate,  
                    $now]
                    );
    }
    public function getOrders($companyid) {
        $g = \DB::table('orders_orders')
                ->where('order_isactive', '=', 1)
                ->where('general_company_id', '=', $companyid)
                ->get();
        return $g;
    }
}