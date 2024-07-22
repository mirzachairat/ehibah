<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sub;
use App\Models\Skpd;


class subController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

  
  public function index()
  {
         $Sub = Sub::get()->sortBy('kd_skpd');
         return view('backEnd.sub',compact("Sub"));
      
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    $data['skpd']	= Skpd::orderBy('name', 'asc')->get();
    return view("backEnd.sub.create",$data);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
		$Sub = new Sub;
        $Sub->kd_skpd = $request->kd_skpd;
        $Sub->kd_sub_skpd = $request->kd_sub_skpd;
        $Sub->nm_sub_skpd = $request->nm_sub_skpd;
        $Sub->created_at = date('Y-m-d H:i:s', strtotime('now'));
        $Sub->save();
		return redirect()->route('sub')->with('message', 'Add data success');
  }

 
  public function show($id)
  {
		$Sub = Sub::where('id',$id)->first();
        if (count($Sub) > 0) {
             return view('backEnd.sub.show',compact('Sub'));
        } else {
            return redirect()->action('SubController@index');
        }
  }

  
  public function edit($id)
  {
    $Skpd	= Skpd::orderBy('name', 'asc')->get();
    $Sub = Sub::where('id',$id)->first();
        if (count($Sub) > 0) {
             return view('backEnd.sub.edit',compact('Sub','Skpd'));
        } else {
            return redirect()->action('SubController@index');
        }
  }

 
  public function update(Request $request,$id)
  {
      $Sub = Sub::find($id);
      if (count($Sub) > 0) {
        $Sub->kd_skpd = $request->kd_skpd;
        $Sub->kd_sub_skpd = $request->kd_sub_skpd;
        $Sub->nm_sub_skpd = $request->nm_sub_skpd;
            $Sub->updated_at = date('Y-m-d H:i:s', strtotime('now'));
            $Sub->save();
			return redirect()->route('sub')->with('message', 'Update data success');
         } else {
			return redirect()->route('sub')->with('message', 'Gagal updated!');
        }  
  }
  
    public function search(Request $request)
    {
        $Sub  = Sub::where('nm_sub_skpd', 'LIKE', '%' . $request->search . '%')->orderby('kd_skpd', 'asc')->paginate(env('BACKEND_PAGINATION'));
        $search_word = $request->search;
        return view("backEnd.sub", compact("Sub","search_word"));
    }

 
  public function destroy($id)
  {
     Sub::where('id',$id)
			   ->update([ 'deleted_at'=> date('Y-m-d H:i:s', strtotime('now'))]);

        return redirect()->back()->with('message', 'Data deleted!');
  }
}
