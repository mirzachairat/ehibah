<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengumuman;

class DataPengumumanController extends Controller
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
        $Pengumuman = Pengumuman::orderby('pengumuman_id', 'desc')->paginate(env('BACKEND_PAGINATION'));
        return view('backend.pengumuman.index',compact("Pengumuman"));
  }
}
