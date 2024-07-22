<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkflowTransition;

class WorkflowTransitionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $transitions = WorkflowTransition::orderBy('id', 'desc')->paginate(10);
        $state = array();
  
        return view('backend.workflows.transition.index',compact('transitions'));
    }
}
