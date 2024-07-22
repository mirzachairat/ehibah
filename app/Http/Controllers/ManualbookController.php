<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManualbookController extends Controller
{
    public function index(){
        return view('frontEnd.manualbook');
    }
}
