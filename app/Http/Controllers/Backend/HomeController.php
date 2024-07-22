<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\LogActivity;
use App\Models\LogLogin;

class HomeController extends Controller
{
    public function index(){
        $roleid = Auth::user()->role_id__;
        if($roleid == 3 || $roleid == 7 || $roleid == '' || $roleid == null || $roleid == false || empty($roleid) || !isset($roleid)){
            return redirect()->route('home');
        }
    	$data['User']			= User::count();
		$data['LogActitity']	= LogActivity::getLatest();
        if(Auth::user()->id=='1'){
            $actions = LogLogin::orderBy('created_at', 'DESC')->paginate(env('BACKEND_PAGINATION'));
        }else{
            $actions = LogLogin::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(env('BACKEND_PAGINATION'));
        }
		$data['Loglogin']	= $actions;
        return view('backEnd.home', $data);
    }
}
