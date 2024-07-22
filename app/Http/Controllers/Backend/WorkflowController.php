<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Workflow;

class WorkflowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
	{
		$Workflows = Workflow::orderby('id', 'asc')->paginate(10);
		return view('backend.workflows.index',compact("Workflows"));
	}
}
