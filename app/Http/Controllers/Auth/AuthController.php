<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MetaTag;
use App\Models\Banner;
use App\Models\ProposalType;
use App\Models\Proposal;
use App\Models\Skpd;
use App\Models\ProposalDana;
use App\Models\WorkflowState;
use App\Models\User;
use App\Models\LogLogin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index(){
        return view ('frontEnd.login');
    }

    public function login(){
        $roleid = isset(Auth::user()->id)?Auth::user()->id:'';
        if($roleid != ''){
            return Redirect::to('/admin');
        }
        MetaTag::set('title', 'E-HibahBansos - Login Operator');
        MetaTag::set('description', 'E-HibahBansos - Aplikasi Hibah Bansos Provinsi Banten');
        return view('frontEnd.login');
    }

    public function loginPost(Request $request){
        $roleid = isset(Auth::user()->id)?Auth::user()->id:'';
        if($roleid != ''){
            return Redirect::to('/admin');
        }
        MetaTag::set('title', 'E-HibahBansos - Login Operator');
        MetaTag::set('description', 'E-HibahBansos - Aplikasi Hibah Bansos Provinsi Banten');

        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) return sendError('Validation Error.', $validator->errors(), 422);
        $credentials = $request->only('email', 'password');
        if (Auth()->attempt($credentials)) {
            if($roleid != 3 || $roleid != 7){
                LogLogin::create([
                    'username'     => 'email',
                    'role'         => 'website_admin',
                    // 'client_ip'    => $request->getClientIp(),
                    'client_agent' => $_SERVER['HTTP_USER_AGENT'],
                ]);
                // Auth::loginUsingId($cekktp->id);
                return Redirect::to('/admin');
            }
        }       
            else{
                    Session::flash('error', 'Uppss.. proses login gagal, Password atau Email, Salah!');
                    return redirect()->route('login');
                }
    }   
    
    public function logout(Request $request)
    {
        Auth::logout();
 
        request()->session()->invalidate();
 
        request()->session()->regenerateToken();
 
        return redirect('/login');
    }  
}
