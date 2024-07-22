<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cms;

class DataPeraturanController extends Controller
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
        $Peraturan = Cms::where('page_id','peraturan')->orderby('sequence', 'asc')->paginate(env('BACKEND_PAGINATION'));
        return view('backEnd.peraturan.index',compact("Peraturan"));
  }
}
