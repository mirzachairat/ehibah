<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkflowNotification;

class WorkflowNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index(Request $request)
  {
      $data= WorkflowNotification::orderBy('id', 'desc')->paginate(10);
    return view('backend.workflows.notification.index', $data);
  }
}
