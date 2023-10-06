<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomingController extends Controller
{
    public function index() {
        return view('welcoming');
    }
}
