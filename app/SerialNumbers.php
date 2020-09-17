<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SerialNumbers extends Model
{
    public function saveSerialNumber($data)
    {
        $authid = \Auth::id();
        $now = date('Y-m-d');

        $providertoexplode = $data['provider_id'];
        $providerarr = explode(" -", $providertoexplode, 2);
        $providerid = $providerarr[0];
        
        $customertoexplode = $data['customer_id'];
        $customerarr = explode(" -", $customertoexplode, 2);
        $customerid = $customerarr[0];
        
        $companytoexplode = $data['company_id'];
        $companyarr = explode(" -", $companytoexplode, 2);
        $companyid = $companyarr[0];
        
        $getExpirePeriod = $data['serialnumber_expire'];
        $expire = 0;
        if ($getExpirePeriod == 6){
            $expire = date('Y-m-d', strtotime('+6 months'));
        }
        elseif ($getExpirePeriod == 12) {
            $expire = date('Y-m-d', strtotime('+1 year'));
        }
        elseif ($getExpirePeriod == 24) {
            $expire = date('Y-m-d', strtotime('+2 year'));
        }
        elseif ($getExpirePeriod == 36) {
            $expire = date('Y-m-d', strtotime('+3 year'));
        }
        else {
            $expire = 0;
        }
        
    \DB::insert('INSERT INTO products'
     . '(provider_id, '
     . 'company_id, '
     . 'customer_id, '
     . 'product_bmd_id, '
     . 'serialnumber, '
     . 'serialnumber_added, '
     . 'serialnumber_expire, '
     . 'employee_id)'
     . 'VALUES'
     . '(?, ?, ?, ?, ?, ?, ?, ?)',
     [$providerid,
      $companyid,
      $customerid,
      $data['product_bmd_id'],
      $data['product_sellprice'],
      $data['serialnumber'],
      $now,
      $expire,
      $authid]);
    }
}
