<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Costs extends Model {
    static public function getMoneyInCash() {
        $authid = \Auth::id();
        $g = DB::table('costs_payin')
             ->where('user_id', '=', $authid)
             ->where('cost_payin_iscash', '=', 1)
             ->select('cost_payin_total', 'cost_payin_datetime')
             ->orderBy('cost_payin_datetime', 'DESC')
             ->limit(1)
             ->get();
        return $g;
    }
    static public function getMoneyInBank() {
        $authid = \Auth::id();
        $g = DB::table('costs_payin')
             ->where('user_id', '=', $authid)
             ->where('cost_payin_iscash', '=', 0)
             ->leftJoin('general_owncompanies', 'costs_payin.general_owncompany_id', '=', 'general_owncompanies.general_owncompany_id')
             ->select('cost_payin_total', 'general_owncompany_name', 'cost_payin_datetime')
             ->orderBy('cost_payin_datetime', 'DESC')
             ->limit(1)
             ->get();
        return $g;
    }
    static public function getBankCosts() {
        $authid = \Auth::id();
        $g = DB::table('costs_costs')
            ->where('cost_isactive', '=', 1)
            ->where('user_id', '=', $authid)
            ->where('cost_iscash', '=', 0)
            ->get();
        return $g;
    }
    static public function getCashCosts() {
        $authid = \Auth::id();
        $g = DB::table('costs_costs')
            ->where('cost_isactive', '=', 1)
            ->where('user_id', '=', $authid)
            ->where('cost_iscash', '=', 1)
            ->orderBy('cost_payday')
            ->get();
        return $g;
    }
    static public function getPayOutBankLog() {
        $authid = \Auth::id();
        $g = DB::table('costs_payout')
                      ->where('cost_payout_iscash', '=', 0)
                      ->where('user_id', '=', $authid)
                      ->orderBy('cost_payout_datetime', 'DESC')
                      ->limit(3)
                      ->get();
        return $g;
    }
    static public function getPayOutCashLog() {
        $authid = \Auth::id();
        $g = DB::table('costs_payout')
                      ->where('cost_payout_iscash', '=', 1)
                      ->where('user_id', '=', $authid)
                      ->orderBy('cost_payout_datetime', 'DESC')
                      ->limit(3)
                      ->get();
        return $g;
    }
    static public function getPayInBankLog() {
        $authid = \Auth::id();
        $g = DB::table('costs_payin')
                      ->where('cost_payin_iscash', '=', 0)
                      ->where('user_id', '=', $authid)
                      ->orderBy('cost_payin_datetime', 'DESC')
                      ->limit(3)
                      ->get();
        return $g;
    }
    static public function getPayInCashLog() {
        $authid = \Auth::id();
        $g = DB::table('costs_payin')
                      ->where('cost_payin_iscash', '=', 1)
                      ->where('user_id', '=', $authid)
                      ->orderBy('cost_payin_datetime', 'DESC')
                      ->limit(3)
                      ->get();
        return $g;
    }   
    public function saveCost($data) {
		$payday = date("Y-m-d", strtotime($data['cost_payday']));
		\DB::insert('INSERT INTO costs (cost_name, cost_description, cost_cost, cost_payday, cost_is_cash, user_id) VALUES (?, ?, ?, ?, ?, ?)', [$data['cost_name'], $data['cost_desc'], $data['cost_cost'], $payday, $data['cost_is_cash'], \Auth::id()]);
	}
    public function updateCost($data) {
        \DB::table('costs')
        ->where('cost_id', $data['update_id'])
        ->update([
            'cost_is_paid' => $data['cost_is_paid'],
            'cost_name' => $data['cost_name'],
            'cost_description' => $data['cost_description'],
            'cost_cost' => $data['cost_cost']
                ]);
    }
    public function destroyCost($data) {
         \DB::table('costs')
        ->where('cost_id', $data['update_id'])
        ->update(['cost_is_active' => 0]);
    }
    public function payOutCash($data) {   
        $authid = \Auth::id();
        $cashBalance = \DB::select('SELECT user_in_cash FROM users WHERE id = (?)', array($authid));
        foreach ($cashBalance as $CB)
        {
            $cash = $CB->user_in_cash;
        }

        $newCashBalance = $cash - $data['pay_out_cost'];

        DB::table('costs')
        ->where('cost_id', $data['update_id'])
        ->update(['cost_is_paid' => 1]);

        DB::table('users')
        ->where('id', $authid)
        ->update(['user_in_cash' => $newCashBalance]);

        DB::insert('INSERT INTO pay_out (user_id, cost_id, pay_out_iscash, pay_out_cost) VALUES (?, ?, ?, ?)', [$authid, $data['cost_id'], 1, $data['pay_out_cost']]);
    }
    public function payOutBank($data) {   
        $authid = \Auth::id();
        $bankBalance = \DB::select('SELECT user_in_bank FROM users WHERE id = (?)', array($authid));
        foreach ($bankBalance as $BB)
        {
            $bank = $BB->user_in_bank;
        }

        $newBankBalance = $bank - $data['pay_out_cost'];

        \DB::table('costs')
        ->where('cost_id', $data['update_id'])
        ->update(['cost_is_paid' => 1]);

        \DB::table('users')
        ->where('id', $authid)
        ->update(['user_in_bank' => $newBankBalance]);

        \DB::insert('INSERT INTO pay_out (user_id, cost_id, pay_out_iscash, pay_out_cost) VALUES (?, ?, ?, ?)', [$authid, $data['cost_id'], 0, $data['pay_out_cost']]);
    }
    public function payInCash($data) {
        $authid = \Auth::id();
        $cashBalance = \DB::select('SELECT user_in_cash FROM users WHERE id = (?)', array($authid));
        foreach ($cashBalance as $CB)
        {
            $cash = $CB->user_in_cash;
        }
        $newCashBalance = $cash + $data['pay_in_cost'];

        \DB::table('users')
        ->where('id', $authid)
        ->update(['user_in_cash' => $newCashBalance]);

        \DB::insert('INSERT INTO pay_in (user_id, pay_in_iscash, pay_in_cost) VALUES (?, ?, ?)', [$authid, 1, $data['pay_in_cost']]);

    }
    public function payInBank($data) {
        $authid = \Auth::id();
        $bankBalance = \DB::select('SELECT user_in_bank FROM users WHERE id = (?)', array($authid));
        foreach ($bankBalance as $BB)
        {
            $bank = $BB->user_in_bank;
        }
        $newBankBalance = $bank + $data['pay_in_cost'];

        \DB::table('users')
        ->where('id', $authid)
        ->update(['user_in_bank' => $newBankBalance]);


        \DB::insert('INSERT INTO pay_in (user_id, pay_in_iscash, pay_in_cost) VALUES (?, ?, ?)', [$authid, 0, $data['pay_in_cost']]);
    }
}
