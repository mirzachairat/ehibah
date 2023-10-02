<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Checklist;

class ChecklistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
  
    private $uploadPath = "media/cms/";
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $Checklist = Checklist::orderby('id', 'asc')->paginate(env('BACKEND_PAGINATION'));
        return view('backend.checklist.index',compact("Checklist"));
    }
}
