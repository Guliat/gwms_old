<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feedback;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Session;

class FeedbackController extends Controller {
    
    public function index() {
        echo "feedback";
    }
    
    public function store(Request $request) {
        $feedback = new Feedback();
        $data = $request->all();
        $feedback->storeFeedback($data);
        return redirect('/');
    }
    
}
    

    
    