<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Videosurveillance;
use App\Http\Controllers\Controller;

class VideoSurveillanceController extends Controller {
    
    public function getProjects() {
        if(\Auth::user()) {
            function showDate($showDate) {
                    $showDateIn = strtotime($showDate);
                    $dateStyle = date("d F Y", $showDateIn);
                    $showDateArray1 = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                    $showDateArray2 = array("Януари", "Февруари", "Март", "Април", "Май", "Юни", "Юли", "Август", "Септември", "Октомври", "Ноември", "Декември");
                    $showDateOut = str_replace($showDateArray1, $showDateArray2, $dateStyle);
                    echo $showDateOut;
            }
            $getProjects = \DB::table('videosurveillance_projects')
                         ->leftJoin('general_customers', 'videosurveillance_projects.general_customer_id', '=', 'general_customers.general_customer_id')
                         ->leftJoin('general_companies', 'videosurveillance_projects.general_company_id', '=', 'general_companies.general_company_id')
                         ->orderBy('videosurveillance_project_id', 'DESC')
                         ->paginate(10);
            
            return view('videosurveillances',['getProjects' => $getProjects]);
        }
        else {
            return redirect('/login');
        }
    }
    public function getProject($projectid) {
        if(\Auth::user()) {
            
            $g = new Videosurveillance();
            $getProject = $g->getProject($projectid);
            
            
            return view('videosurveillance',['getProject' => $getProject, 'projectid' => $projectid]);
        }
        else {
            return redirect('/login');
        }
    }    
    public function storeProject() {
        $g = new Videosurveillance();
        $g->storeProject();
        $projectid = \DB::getPdo()->lastInsertId();
        return redirect('/videosurveillance/project/'.$projectid);
        
    }
    public function storeProjectUpgrade(Request $request) {
        $g = new Videosurveillance();
        $data = $request->all();
        $g->storeProjectUpgrade($data);
        $projectid = $data['project_id'];
        return redirect('/videosurveillance/project/'.$projectid);
    }
    public function updateProjectUpgrade(Request $request) {
        $g = new Videosurveillance();
        $data = $request->all();
        $g->updateProjectUpgrade($data);
        $projectid = $data['project_id'];
        return redirect('/videosurveillance/project/'.$projectid);
    }  
    public function storeNewOrderToProject(Request $request) {
        $g = new Videosurveillance();
        $g->storeNewOrderToProject();
        $data = $request->all();
        $orderid = \DB::getPdo()->lastInsertId();
        $g->storeOrderToProject($data, $orderid);
        return redirect('/order/'.$orderid);
    }
    public function storeNewOrderToProjectUpgrade(Request $request) {
        $g = new Videosurveillance();
        $g->storeNewOrderToProjectUpgrade();
        $data = $request->all();
        $orderid = \DB::getPdo()->lastInsertId();
        $g->storeOrderToProjectUpgrade($data, $orderid);
        return redirect('/order/'.$orderid);
    }
    public function updateProject(Request $request) {
        $g = new Videosurveillance();
        $data = $request->all();
        $g->updateProject($data);
        $projectid = $data['update_id'];
        return redirect('/videosurveillance/project/'.$projectid);
    }
    public function storeCustomerToProject(Request $request) {
        $g = new Videosurveillance();
        $data = $request->all();
        $g->storeCustomerToProject($data);
        $projectid = $data['update_id'];
        return redirect('/videosurveillance/project/'.$projectid);
    }
    public function storeCompanyToProject(Request $request) {
        $g = new Videosurveillance();
        $data = $request->all();
        $g->storeCompanyToProject($data);
        $projectid = $data['update_id'];
        return redirect('/videosurveillance/project/'.$projectid);
    }
    public function goToVsProject(Request $request) {
        $data = $request->all();
        $explode = $data['vsprojectid'];
        $array = explode(" -", $explode, 2);
        $projectid = $array[0];
       
        $g = \DB::table('videosurveillance_projects')
             ->select('videosurveillance_project_id')
             ->get();
        
        $projectidd = null;
        
        foreach($g as $projects) {
            if($projectid == $projects->videosurveillance_project_id) {
                $projectidd = $projects->videosurveillance_project_id;
            }
        }
        
        
        if(!empty($projectidd)){
            return redirect('/videosurveillance/project/'.$projectidd);
        }
        else {
            return redirect('/videosurveillance')->withErrors('Грешни или невъведени данни за търсене');
        }
        
    }
}
