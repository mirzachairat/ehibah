<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index(Request $request)
    {
            $data  = User::with('roles')->orderBy('id', 'desc')->paginate(10);
    	return view('backend.user.index', compact('data'));
    }
}
