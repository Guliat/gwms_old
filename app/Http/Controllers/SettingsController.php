<?php

namespace App\Http\Controllers;

use App\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller {
    public function index() {
        if(\Auth::user()) {
            return view('settings');
        } else {
            return redirect('/login');
        }
    }
}