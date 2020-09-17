<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class OwnCompanies extends Model {
    static public function getOwnCompanies() {
        $g = DB::table('general_owncompanies')
            ->where('general_owncompany_isactive', '=', 1)
            ->get();
        return $g;
    }
    static public function getEmployees() {
        $g = DB::table('users')
            ->leftJoin('general_owncompanies', 'users.general_owncompany_id', '=', 'general_owncompanies.general_owncompany_id')
            ->paginate(10);
        return $g;
    }
    public function storeOwnCompany($data) {
        $authid = \Auth::id();
        $now = date('Y-m-d');
        DB::insert('INSERT INTO general_owncompanies'
                . '('
                . 'general_employee_id,'
                . 'general_owncompany_name,'
                . 'general_owncompany_number,'
                . 'general_owncompany_taxnumber,'
                . 'general_owncompany_address,'
                . 'general_owncompany_owner,'
                . 'general_owncompany_bank,'
                . 'general_owncompany_iban,'
                . 'general_owncompany_bic,'
                . 'general_owncompany_added'
                . ')'
                . 'VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                [
                    $authid,
                    $data['general_owncompany_name'],
                    $data['general_owncompany_number'],
                    $data['general_owncompany_taxnumber'],
                    $data['general_owncompany_address'],
                    $data['general_owncompany_owner'],
                    $data['general_owncompany_bank'],
                    $data['general_owncompany_iban'],
                    $data['general_owncompany_bic'],
                    $now
                ]);
    }
    public function updateOwnCompany($data) {
        DB::table('general_owncompanies')
        ->where('general_owncompany_id', $data['update_id'])
        ->update([
                'general_owncompany_number' => $data['general_owncompany_number'],
                'general_owncompany_taxnumber' => $data['general_owncompany_taxnumber'],
                'general_owncompany_name' => $data['general_owncompany_name'],
                'general_owncompany_address' => $data['general_owncompany_address'],
                'general_owncompany_owner' => $data['general_owncompany_owner'],
                'general_owncompany_bank' => $data['general_owncompany_bank'],
                'general_owncompany_iban' => $data['general_owncompany_iban'],
                'general_owncompany_bic' => $data['general_owncompany_bic'],
                ]);
    }
    public function removeOwnCompany($data) {
        DB::table('general_owncompanies')
        ->where('general_owncompany_id', $data['remove_id'])
        ->update(['general_owncompany_isactive' => 0]);
    }
    public function storeEmployee($data) {
        $authid = \Auth::id();
        $now = date('Y-m-d');
        $password = bcrypt($data['password']);
        DB::insert('INSERT INTO users (general_owncompany_id, login, name, email, phone, password, created_at, general_employee_addedby)'
                . 'VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
                [$data['general_owncompany_id'], $data['login'], $data['name'], $data['email'], $data['phone'], $password, $now, $authid]);
    }
    public function updateEmployee($data) {
        DB::table('users')
        ->where('id', $data['update_id'])
        ->update([
            'login' => $data['login'],
            'name' => $data['name'],
            'phone' => $data['phone'],
            'personal_phone' => $data['personal_phone'],
            'email' => $data['email'],
            'personal_email' => $data['personal_email'],
           # 'general_employee_level' => $data['general_employee_level']
        ]);
    }
    public function removeEmployee($data) {
        $now = date('Y-m-d');
        $authid = \Auth::id();
        DB::table('users')
        ->where('id', $data['update_id'])
        ->update([
            'general_employee_isactive' => '0',
            'general_employee_firedat' => $now,
            'general_employee_firedby' => $authid
        ]);
    }
}
