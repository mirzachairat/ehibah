<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkflowGuard;

class WorkflowGuardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        // if($request->get('search'))
        // {
        // $data['data'] = WorkflowGuard::orderBy('id', 'desc')
        //                 ->where('name', 'like', '%'.$request->get('search').'%')
        //                 ->orWhere('label', 'like', '%'.$request->get('search').'%')
        //                 ->paginate(10);

        // }
        // else
        // {
        // $data['data'] = WorkflowGuard::orderBy('id', 'desc')->paginate(10);

        // }

        $data =  WorkflowGuard::orderBy('id', 'desc')->paginate(10);
        return view('backend.workflows.guard.index', compact('data'));
    }
}
