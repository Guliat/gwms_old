<?php
namespace App\Http\Controllers;
use App\Costs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
class CostsController extends Controller {
    
    public function index() {
        if(\Auth::user()) {
            $authid = \Auth::id();
            $month = date('m');
            $getCashNeedsDB = \DB::select('SELECT cost_cost, cost_payday FROM costs_costs WHERE cost_isactive = 1 AND cost_ispaid = 0 AND cost_iscash = 1 AND user_id ='.$authid);
            $cashNeeds = 0;
            foreach($getCashNeedsDB as $getCashNeeds)
            {
                $getCashNeedsMonth = strtotime($getCashNeeds->cost_payday);
                $getCashNeedsMonthNumber = date('m', $getCashNeedsMonth);
                if ($getCashNeedsMonthNumber == $month)
                {
                    $cashNeeds += $getCashNeeds->cost_cost;
                }
            }
            $getBankNeedsDB = \DB::select('SELECT cost_cost, cost_payday FROM costs_costs WHERE cost_isactive = 1 AND cost_ispaid = 0 AND cost_iscash = 0 AND user_id ='.$authid);
            $bankNeeds = 0;
            foreach($getBankNeedsDB as $getBankNeeds)
            {
                $getBankNeedsMonth = strtotime($getBankNeeds->cost_payday);
                $getBankNeedsMonthNumber = date('m', $getBankNeedsMonth);
                if ($getBankNeedsMonthNumber == $month)
                {
                    $bankNeeds += $getBankNeeds->cost_cost;
                }
            }
            $getCashPayDays = \DB::select('SELECT * FROM (SELECT * FROM costs_costs ORDER BY cost_payday) costs WHERE cost_isactive = 1 AND cost_ispaid = 0 AND cost_iscash = 1 AND user_id = (?)', array($authid));
            $getBankPayDays = \DB::select('SELECT * FROM (SELECT * FROM costs_costs ORDER BY cost_payday) costs WHERE cost_isactive = 1 AND cost_ispaid = 0 AND cost_iscash = 0 AND user_id = (?)', array($authid));
            return view('costs',[
                    'getCashPayDays' => $getCashPayDays,
                    'getBankPayDays' => $getBankPayDays,
                    'cashNeeds' => $cashNeeds,
                    'bankNeeds' => $bankNeeds,
                    ]);

        } else {
            return redirect('/login');
        }
    }
    public function add() {
        if(\Auth::user()) {
            return view('cost_add');
        }
        else {
            return redirect('/login');
        }
    }
    public function store(Request $request) {
        $costs = new Costs();
        $data = $request->all();
        $costs->saveCost($data);
        return redirect('/costs');
    }
    public function edit($id) {   
        if(\Auth::user()) {
            $authid = \Auth::id();
            $editCost = \DB::select('SELECT * FROM costs WHERE cost_id = '.$id.' AND user_id = (?)', array($authid));
            return view('editcost', ['editCost' => $editCost]);
        } else {
            return redirect('/login');
        }
    }
    public function update(Request $request) {
       
        $data = $request->all();
        $costs = new Costs();
        $costs->updateCost($data);
        return Redirect::back();
    }
    public function delete($id) {

        return view('deletecost', ['id' => $id]);

    }
    public function destroy(Request $request) {
        $data = $request->all();
        $costs = new Costs();
        $costs->destroyCost($data);
        return redirect('/costs');
    }
    public function payoutcash(Request $request) {   
        $data = $request->all();
        $costs = new Costs();
        $costs->payOutCash($data);
        return redirect('/costs');
    }
    public function payoutbank(Request $request) {   
        $data = $request->all();
        $costs = new Costs();
        $costs->payOutBank($data);
        return redirect('/costs');
    }
    public function payincash(Request $request)  {   
        $data = $request->all();
        $costs = new Costs();
        $costs->payInCash($data);
        return redirect('/costs');
    }
    public function payinbank(Request $request) {   
        $data = $request->all();
        $costs = new Costs();
        $costs->payInBank($data);
        return redirect('/costs');
    }
}