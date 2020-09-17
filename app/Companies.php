<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    
    static public function getCompanyContent($company_id) {
        $g = DB::table('general_companies')
             ->where('general_company_id', '=', $company_id)
             ->get();
        return $g;
    }
    
    public function updateCompany($data) {
        if(isset($data['general_company_isprovider'])) {
            $isprovider = $data['general_company_isprovider'];
        } else {
            $isprovider = "0";
        }
        DB::table('general_companies')
        ->where('general_company_id', $data['update_id'])
        ->update([
            'general_company_name' => $data['general_company_name'],
            'general_company_number' => $data['general_company_number'],
            'general_company_taxnumber' => $data['general_company_taxnumber'],
            'general_company_address' => $data['general_company_address'],
            'general_company_owner' => $data['general_company_owner'],
            'general_company_bank' => $data['general_company_bank'],
            'general_company_iban' => $data['general_company_iban'],
            'general_company_bic' => $data['general_company_bic'],
            'general_company_phone' => $data['general_company_phone'],
            'general_company_isprovider' => $isprovider,
            'general_company_level' => $data['general_company_level'],
                ]);
    }
    
    public function storeCompany($data){
        $authid = \Auth::id();
        $now = date('Y-m-d');
        
        if(isset($data['general_company_isprovider'])) {
            $isprovider = $data['general_company_isprovider'];
        } else {
            $isprovider = "";
        }
        
        DB::insert('INSERT INTO general_companies '
                . '(general_employee_id,'
                . 'general_company_name, '
                . 'general_company_number, '
                . 'general_company_taxnumber, '
                . 'general_company_address, '
                . 'general_company_owner, '
                . 'general_company_phone, '
                . 'general_company_bank, '
                . 'general_company_iban, '
                . 'general_company_bic, '
                . 'general_company_isprovider,'
                . 'general_company_added)'
                . 'VALUES'
                . '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                [$authid,
                 $data['general_company_name'],
                 $data['general_company_number'], 
                 $data['general_company_taxnumber'],
                 $data['general_company_address'],
                 $data['general_company_owner'],
                 $data['general_company_phone'],
                 $data['general_company_bank'],
                 $data['general_company_iban'],
                 $data['general_company_bic'],
                 $isprovider,
                 $now]);
    }
}
