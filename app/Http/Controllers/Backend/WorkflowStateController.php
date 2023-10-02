<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkflowState;

class WorkflowStateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
	{
		$States = WorkflowState::orderby('id', 'asc')->paginate(10);
		return view('backend.workflows.state.index',compact('States'));
	}
}
