<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skpd;

class SkpdController extends Controller
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
  public function index()
  {
        $Skpd = Skpd::orderby('name', 'asc')->paginate(env('BACKEND_PAGINATION'));
        return view('backEnd.skpd',compact("Skpd"));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return view("backEnd.skpd.create");
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
		$Skpd = new Skpd;
        $Skpd->name = $request->name;
        $Skpd->kd_skpd = $request->kd_skpd;
        $Skpd->created_at = date('Y-m-d H:i:s', strtotime('now'));
        $Skpd->save();
		return redirect()->route('skpd')->with('message', 'Add data success');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
		$Skpd = Skpd::where('id',$id)->first();
        if (count($Skpd) > 0) {
             return view('backEnd.skpd.show',compact('Skpd'));
        } else {
            return redirect()->action('SkpdController@index');
        }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $Skpd = Skpd::where('id',$id)->first();
        if (count($Skpd) > 0) {
             return view('backEnd.skpd.edit',compact('Skpd'));
        } else {
            return redirect()->action('SkpdController@index');
        }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request,$id)
  {
      $Skpd = Skpd::find($id);
      if (count($Skpd) > 0) {
            $Skpd->name = $request->name;
            $Skpd->kd_skpd = $request->kd_skpd;
            $Skpd->updated_at = date('Y-m-d H:i:s', strtotime('now'));
            $Skpd->save();
			return redirect()->route('skpd')->with('message', 'Update data success');
         } else {
			return redirect()->route('skpd')->with('message', 'Gagal updated!');
        }  
  }
  
    public function search(Request $request)
    {
        $Skpd  = Skpd::where('name', 'LIKE', '%' . $request->search . '%')->orderby('name', 'asc')->paginate(env('BACKEND_PAGINATION'));
        $search_word = $request->search;
        return view("backEnd.skpd", compact("Skpd","search_word"));
    }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
     Skpd::where('id',$id)
			   ->update([ 'deleted_at'=> date('Y-m-d H:i:s', strtotime('now'))]);

        return redirect()->back()->with('message', 'Data deleted!');
  }
}
