<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kota;
use App\Models\Roles;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Rekjenis;
use App\Models\Proposal;
use App\Models\ProposalChecklist;
use App\Models\ProposalDana;
use App\Models\ProposalPhoto;
use App\Models\ProposalLpj;
use App\Models\Skpd;
use App\Models\Checklist;
use App\Models\WorkflowTransition;
use App\Models\WorkflowState;
use App\Models\Workflow;
use App\Models\WorkflowGuard;
use App\Models\Attachment;
use App\Models\WorkflowTransitionDocument;
use App\Models\ProposalType;
use App\Models\History;
use App\Models\Program;
use App\Models\Kegiatan;
use App\Models\User;
use Auth,Input, Exception,Validator, Image, Session, File, Redirect, Helper;

class ProposalController extends Controller
{
	
    public function index()
    {
        $role_user = Auth::user()->role_id__;
		// if(Auth::user()->hasRole('superadministrator') || Auth::user()->hasRole('administrator')){
		if($role_user === 1 || $role_user === 2){
             $Proposal   = Proposal::orderBy('id', 'desc')->paginate(env('BACKEND_PAGINATION'));
        }elseif($role_user === 11){
            $Proposal   = Proposal::leftJoin('proposal_dana', 'proposal_dana.proposal_id', '=', 'proposal.id')
                                   ->where('current_stat',2)
                                   ->whereNull('correction_inspektorat')
                                   ->groupBy('id')
                                   ->orderBy('id', 'desc')->paginate(env('BACKEND_PAGINATION'));
       }elseif($role_user === 4 || $role_user === 6){
             $Proposal   = Proposal::leftJoin('proposal_dana', 'proposal_dana.proposal_id', '=', 'proposal.id')
             					   ->where('current_stat',2)
             					   ->WhereNull('correction_tapd')
             					   ->whereNotNull('correction_inspektorat')
             					   ->groupBy('id')
             					   ->orderBy('id', 'desc')->paginate(env('BACKEND_PAGINATION'));
        }elseif($role_user === 12 ){
             $Proposal   = Proposal::leftJoin('proposal_dana', 'proposal_dana.proposal_id', '=', 'proposal.id')
             					   ->where('current_stat',2)
             					   ->whereNull('correction_banggar')
             					   ->whereNotNull('correction_tapd')
             					   ->whereNotNull('correction_inspektorat')
             					   ->groupBy('id')
             					   ->orderBy('id', 'desc')->paginate(env('BACKEND_PAGINATION'));
        }else {
			$Proposal   = Proposal::where('skpd_id',Auth::user()->skpd_id)->orderBy('id', 'desc')->paginate(env('BACKEND_PAGINATION'));		
        }
        $roleid = Auth::user()->role_id__;
        return view("backEnd.proposal", compact(['Proposal','roleid']));
    }

	public function create()
	{
		// Menambahkan peran ke pengguna
        //jika sudah bisa create bisa didelete

        $locked = Helper::locked();
		$Userid = Auth::user();
		dd($Userid);

		$username = Auth::user();
        if($locked != 1){
            if(Auth::user()->role('superadministrator') && !Auth::user()->role('administrator')){
                Session::flash('warning', 'Input Proposal Hibah Bansos Telah Ditutup.');
                return redirect()->route('proposals')->with('message', 'Input Proposal Hibah Bansos Telah Ditutup.');
            }
        }
		
        $tahunanggaran = Helper::tahunanggaran();
		if($tahunanggaran == 1){
			$tahun = date('Y')+1;
		}else{
			$tahun = date('Y');
		}

		$data['tahun']  = $tahun;
        $data['perubahan'] = Helper::perubahan();
        // Session::flash('warning', 'Input Proposal Hibah Bansos Telah Ditutup.');
        // return redirect()->route('proposals');
        //delete sampe sini
		$workflow = $this->getWorkflow('Proposal');
		$data['kota']  = Kota::where('id_provinsi','36')->orderBy('id_kota', 'desc')->get();
		$data['skpd']	= Skpd::orderBy('name', 'asc')->get();
		$data['RekJenis']	= Rekjenis::orderBy('nm_rek_jenis', 'asc')->get();
		$data['State']	= WorkflowTransition::where('workflow_id',$workflow->first()->id)->where('status',1)->orderBy('id', 'asc')->get();
		$data['Type']	= ProposalType::orderBy('name', 'asc')->get();
		$data['Kelengkapan']	= Checklist::where('role_id',5)->where('label','Kelengkapan')->orderBy('sequence', 'asc')->get();
			$data['Persyaratan']	= Checklist::where('role_id',5)->where('label','Persyaratan')->orderBy('sequence', 'asc')->get();
		return view("backEnd.proposal.create", $data);
	}
	
	public function store(Request $request)
	{
		// $this->validate($request, [
            // 'name'      => 'required|min:3:max:255',
		    // 'status'	=> 'required',
        // ]);
		
		/*
		$formFileName = "proposal";
		if ($request->$formFileName != "") 
		{
            if ($request->$formFileName != "") {
				$new_file_name = $this->upload($this->getUploadPath(), $_FILES['proposal']['name'], $_FILES['proposal']['tmp_name']);
            }
		}
		*/

        //jika sudah bisa create bisa didelete
        $locked = Helper::locked();
        if($locked != 1){
            if(!Auth::user()->hasRole('superadministrator') && !Auth::user()->hasRole('administrator')){
                Session::flash('warning', 'Input Proposal Hibah Bansos Telah Ditutup.');
                return redirect()->route('proposals')->with('message', 'Input Proposal Hibah Bansos Telah Ditutup.');
            }
        }
        // Session::flash('warning', 'Input Proposal Hibah Bansos Telah Ditutup.');
        // return redirect()->route('proposals');
        //delete sampe sini
		
        $this->validator($request->all())->validate();
		$Proposal = new Proposal;
        $Proposal->user = $request->user;
        $Proposal->name = $request->name;
        $Proposal->address = $request->address;
        $Proposal->judul = $request->judul;
        $Proposal->latar_belakang = $request->latar;
        $Proposal->maksud_tujuan = $request->maksud;
		$Proposal->skpd_id = $request->skpd?$request->skpd:NULL;
		$Proposal->sub_skpd = $request->sub_skpd?$request->sub_skpd:NULL;
		$Proposal->rekening = $request->rekening;
		$Proposal->typeproposal = isset($request->typeproposal)?$request->typeproposal:'Uang';
        $Kota           = Kota::where('id_kota', $request->kota)->first();
        $Kecamatan      = Kecamatan::where('id_kecamatan', $request->kec)->first();
        $Kelurahan      = Kelurahan::where('id_kelurahan', $request->kel)->first();
        $Proposal->kota       = ucwords(strtolower($Kota->nama_kota));
        $Proposal->kec  = ucwords(strtolower($Kecamatan->nama_kecamatan));
        $Proposal->kel  = ucwords(strtolower($Kelurahan->nama_kelurahan));

		// $Proposal->kota = $request->kota;
		// $Proposal->kec = $request->kec;
		// $Proposal->kel = $request->kel;
        $jumlah = $request->jumlah;
        $koreksi = $request->correction;
        $deskor = $request->deskor;
		
        $Proposal->tahun = $request->tahun;
		/*
		if ($new_file_name != "") {
             $Proposal->file = $new_file_name;
        }
		*/
        $Proposal->time_entry = date('Y-m-d H:i:s', strtotime('now'));
        $Proposal->user_id =  Auth::user()->id;
		$Proposal->type_id = $request->type_id;
		$Proposal->kategori = $request->kategori;
		$Proposal->nik_ahu = $request->nik_ahu;
		$Proposal->perubahan = $request->perubahan;
		
		if($request->name && $request->address && $request->judul && $request->latar && $request->maksud)
		{
			$workflow = $this->getWorkflow('Proposal');
			
			if(Auth::user()->hasRole('opd') || Auth::user()->hasRole('superadministrator') || Auth::user()->hasRole('administrator')){
				$Proposal->current_stat = 2;
				$kelengkapan = $request->kelengkapan;
				$persyaratan = $request->persyaratan;
			}else{
				// $Proposal->type_id = NULL;
				 $Proposal->current_stat = 1;
			}
			
			$Proposal->save();
			if(Auth::user()->hasRole('opd') || Auth::user()->hasRole('superadministrator') || Auth::user()->hasRole('administrator')){
				if(count($kelengkapan) <> 0){
					foreach($kelengkapan as $index => $value) {
						ProposalChecklist::create(['proposal_id' => $Proposal->id,'checklist_id' => $value]);
					}
				}
				if(count($persyaratan) <> 0){
					foreach($persyaratan as $index => $value) {
						ProposalChecklist::create(['proposal_id' => $Proposal->id,'checklist_id' => $value]);
					}
				}
			}
			ProposalChecklist::create(['proposal_id' => $Proposal->id,'checklist_id' => 13,'value' => $request->keterangan]);
			if($request->deskripsi){
					$i = 1;
					foreach($request->deskripsi as $index => $value) {
						if(isset($value)){
							$v1 = isset($jumlah[$index])?$jumlah[$index]:0;
							$v2 = isset($koreksi[$index])?$koreksi[$index]:0;
							$v3 = isset($deskor[$index])?$deskor[$index]:NULL;
							$uid = isset(Auth::user()->id)?Auth::user()->id:NULL;
							ProposalDana::create(['proposal_id' => $Proposal->id,'sequence' => $i,'description' => $value,'amount' => $v1,'correction' => $v2,'deskor' => $v3,'korid'=>$uid,'correction_inspektorat' => $v2,'desins' => $v3,'insid'=>$uid]);
							$i++;
						}
					}
			}
			
			/*
			if(isset($_FILES['foto'])){
				  $file_ary = $this->reArrayFiles($_FILES['foto']);
				  $i = 1;
				  foreach ($file_ary as $file) {
				    $path = 'media/proposal_foto/';
					$new_file_names = $this->upload($path, $file['name'], $file['tmp_name']);
					ProposalPhoto::create(['proposal_id' => $Proposal->id,'sequence' => $i,'path' => $new_file_names]);
					$i++;
				 }
			}
		
			$Attachment 				= New Attachment;
			$Attachment->keterangan 	= $request->keterangan;
			$Attachment->file 			= $new_file_name;
			$Attachment->save();
			*/
			
			if(Auth::user()->hasRole('opd') || Auth::user()->hasRole('superadministrator') || Auth::user()->hasRole('administrator')){
				$Wt1 = WorkflowTransition::where('name','terdaftar')->first();
				$Wt2 = WorkflowTransition::where('name','pengecekan-proposal')->first();
				// $Wt3 = WorkflowTransition::where('name','klasifikasi-sesuai-opd')->first();
				
				History::create(['content_id' => $Proposal->id,'workflow_id' => $workflow->first()->id,'from_state'=>1,'to_state'=>1,'user_id' => Auth::user()->id]);
				History::create(['content_id' => $Proposal->id,'workflow_id' => $workflow->first()->id,'from_state'=>1,'to_state'=>2,'user_id' => Auth::user()->id]);

				// History::create(['content_id' => $Proposal->id,'opd_id' => 'user','workflow_id' => $workflow->first()->id,'from_state'=>1,'to_state'=>1,'transition_id'=>$Wt1->id,'user_id' => Auth::user()->id]);
				// History::create(['content_id' => $Proposal->id,'opd_id' => 'user','workflow_id' => $workflow->first()->id,'from_state'=>1,'to_state'=>2,'transition_id'=>$Wt3->id,'user_id' => Auth::user()->id]);
				// History::create(['content_id' => $Proposal->id,'opd_id' => 'user','workflow_id' => $workflow->first()->id,'from_state'=>1,'to_state'=>2,'transition_id'=>$Wt2->id,'user_id' => Auth::user()->id]);
				// WorkflowTransitionDocument::create(['content_id'=>$Proposal->id,'transition_id' => $Wt1->id,'attachment_id' => $Attachment->id]);
				// WorkflowTransitionDocument::create(['content_id'=>$Proposal->id,'transition_id' => $Wt2->id,'attachment_id' => $Attachment->id]);
				// WorkflowTransitionDocument::create(['content_id'=>$Proposal->id,'transition_id' => $Wt3->id,'attachment_id' => $Attachment->id]);
				// WorkflowTransitionDocument::create(['content_id'=>$Proposal->id,'transition_id' => $Wt1->id,'attachment_id' => $Attachment->id]);
				// WorkflowTransitionDocument::create(['content_id'=>$Proposal->id,'transition_id' => $Wt2->id,'attachment_id' => $Attachment->id]);
				// WorkflowTransitionDocument::create(['content_id'=>$Proposal->id,'transition_id' => $Wt3->id,'attachment_id' => $Attachment->id]);
			}else{
				$Wt = WorkflowTransition::where('name','terdaftar')->first();
				History::create(['content_id' => $Proposal->id,'workflow_id' => $workflow->first()->id,'from_state'=>'1','to_state'=>'1','user_id' => Auth::user()->id]);
				// WorkflowTransitionDocument::create(['content_id'=>$Proposal->id,'transition_id' => $Wt->id,'attachment_id' => $Attachment->id]);
			}
		}
		
		return redirect()->route('proposals')->with('message', 'Add data success');
	}
	
	public function search(Request $request){
        $roleid = isset(Auth::user()->roles->first()->id)?Auth::user()->roles->first()->id:'';
		if($request->search !=''){
			   if(Auth::user()->hasRole('superadministrator') || Auth::user()->hasRole('administrator')){
					$Proposal	 = Proposal::where('judul', 'LIKE', '%' . $request->search . '%')
									->orderby('id', 'desc')->paginate(env('BACKEND_PAGINATION'));
				}else {
					$Proposal	 = Proposal::where('skpd_id',Auth::user()->skpd_id)
									->where('judul', 'LIKE', '%' . $request->search . '%')
									->orderby('id', 'desc')->paginate(env('BACKEND_PAGINATION'));
				}
			$Proposal->appends($request->only('search'));
			$search_word = $request->search;
			return view("backEnd.proposal", compact("Proposal","search_word","roleid"));
		}else{
			return redirect()->route('proposals',"roleid");
		}
	}

	public function edit($id){
        $roleid = ''.
        $idusr = '';
        if(isset(Auth::user()->id)){
            $roleid .= isset(Auth::user()->roles->first()->id)?Auth::user()->roles->first()->id:'';
            $idusr .= isset(Auth::user()->id)?Auth::user()->id:'';
        }
        if($idusr == ''){
            Session::flash('warning', 'Silahkan Login untuk mengakses halaman ini.');
            return redirect()->route('proposals');
        }else{
            if($roleid != 5 && $roleid != 1){
                Session::flash('warning', 'Anda tidak diberikan hak akses untuk mengakses halaman ini.');
                return redirect()->route('proposals');
            }
        }
			$workflow = $this->getWorkflow('Proposal');
			$Proposal  = Proposal::where('id', $id)->first();
        if(count($Proposal) == 0){
            Session::flash('warning', 'Anda tidak diberikan hak akses untuk mengakses halaman ini.');
            return redirect()->route('proposals');
        }
        if($roleid == 5){
            $current_stat = $Proposal->current_stat;
            $skpdid = isset(Auth::user()->skpd_id)?Auth::user()->skpd_id:'';
            if($Proposal->current_stat > 2 || $skpdid != $Proposal->skpd_id){
                Session::flash('warning', 'Anda tidak diberikan hak akses untuk mengakses halaman ini.');
                return redirect()->route('proposals');
            }
        }
			$data['Proposal']  = Proposal::where('id', $id)->first();
			$data['skpd']	= Skpd::orderBy('name', 'asc')->get();
			$data['State']	= WorkflowTransition::where('workflow_id',$workflow->first()->id)->where('status',1)->orderBy('id', 'asc')->get();
			$data['Type']	= ProposalType::orderBy('name', 'asc')->get();
			$data['Kelengkapan']	= Checklist::where('role_id',5)->where('label','Kelengkapan')->orderBy('sequence', 'asc')->get();
			$data['Persyaratan']	= Checklist::where('role_id',5)->where('label','Persyaratan')->orderBy('sequence', 'asc')->get();
			$data['ProposalChecklist']  = ProposalChecklist::where('proposal_id', $id)->get();
			$data['kota']  = Kota::where('id_provinsi','36')->orderBy('id_kota', 'desc')->get();
			$data['RekJenis']	= Rekjenis::orderBy('nm_rek_jenis', 'asc')->get();
	        if($Proposal->kota){
	            $id_kota    = Kota::where('id_provinsi','36')->where('nama_kota',$Proposal->kota)->orderBy('id_kota', 'asc')->first();
				$kotaid = (count($id_kota) > 0)?($id_kota->id_kota?$id_kota->id_kota:''):'';
				$kecid = ''; $kelid = '';
				if($kotaid != ''){
					if($Proposal->kec){
						$id_kec    = Kecamatan::where('id_kota',$kotaid)->where('nama_kecamatan',$Proposal->kec)->orderBy('id_kecamatan', 'asc')->first();
						$kecid = (count($id_kec) > 0)?($id_kec->id_kecamatan?$id_kec->id_kecamatan:''):'';
						if($kecid != ''){
							if($Proposal->kel){
								$id_kel    = Kelurahan::where('id_kecamatan',$kecid)->where('nama_kelurahan',$Proposal->kel)->orderBy('id_kelurahan', 'asc')->first();
								$kelid = (count($id_kel) > 0)?($id_kel->id_kelurahan?$id_kel->id_kelurahan:''):'';
							}
						}
					}
				}
	            $data['datakota'] = $kotaid;
	            $data['datakec'] = $kecid;
	            $data['datakel'] = $kelid;
	        }else{
		        $data['datakota'] = '';
		        $data['datakec'] = '';
		        $data['datakel'] = '';
	        }
			return view('backEnd.proposal.edit',$data);
    }
    
    public function update(Request $request,$id)
    {
        $Proposal = Proposal::find($id);
        $roleid = ''.
        $iduser = '';
        if(isset(Auth::user()->id)){
            $roleid .= isset(Auth::user()->roles->first()->id)?Auth::user()->roles->first()->id:'';
            $iduser .= isset(Auth::user()->id)?Auth::user()->id:'';
        }
        if($iduser == ''){
            Session::flash('warning', 'Silahkan Login untuk mengakses halaman ini.');
            return redirect()->route('proposals')->with('message', 'Silahkan Login untuk mengakses halaman ini.');
        }else{
            if(Auth::user()->hasRole('opd') || Auth::user()->hasRole('superadministrator') || Auth::user()->hasRole('administrator')){
                //return true;
            }else{
            	Session::flash('warning', 'Anda tidak diberikan hak akses untuk mengakses halaman ini.');
            	return redirect()->route('proposals')->with('message', 'Anda tidak diberikan hak akses untuk mengakses halaman ini.');
            }
        }
        if($roleid == 5){
            $skpdid = isset(Auth::user()->skpd_id)?Auth::user()->skpd_id:'';
            if($Proposal->skpd_id != $skpdid){
                Session::flash('warning', 'Anda tidak diberikan hak akses untuk mengakses halaman ini.');
            	return redirect()->route('proposals')->with('message', 'Anda tidak diberikan hak akses untuk mengakses halaman ini.');
            }
        }elseif($roleid == 3 || $roleid == 7){
            if($Proposal->current_stat > 1){
                Session::flash('warning', 'Anda tidak diberikan hak akses untuk mengakses halaman ini.');
            	return redirect()->route('proposals')->with('message', 'Anda tidak diberikan hak akses untuk mengakses halaman ini.');
            }
        }
        $this->validator($request->all())->validate();
        $Proposal->tahun    = $request->tahun;
        $Proposal->type_id    = $request->type_id;
        $Proposal->user   = $request->user;
        $Proposal->name    = $request->name;
        $Proposal->address   = $request->address;
        $Kota           = Kota::where('id_kota', $request->kota)->first();
        $Kecamatan      = Kecamatan::where('id_kecamatan', $request->kec)->first();
        $Kelurahan      = Kelurahan::where('id_kelurahan', $request->kel)->first();
        $Proposal->kota       = ucwords(strtolower($Kota->nama_kota));
        $Proposal->kec  = ucwords(strtolower($Kecamatan->nama_kecamatan));
        $Proposal->kel  = ucwords(strtolower($Kelurahan->nama_kelurahan));
        $Proposal->judul      = $request->judul;
        $Proposal->latar_belakang = $request->latar;
        $Proposal->maksud_tujuan   = $request->maksud;
        $Proposal->skpd_id  = $request->skpd;
        $Proposal->sub_skpd  = $request->sub_skpd?$request->sub_skpd:NULL;
		$Proposal->rekening = $request->rekening;
		$Proposal->typeproposal = isset($request->typeproposal)?$request->typeproposal:'Uang';
        $Proposal->kategori  = $request->kategori;
        $Proposal->nik_ahu  = $request->nik_ahu;
        $Proposal->save();
        if(Auth::user()->hasRole('opd') || Auth::user()->hasRole('superadministrator') || Auth::user()->hasRole('administrator')){
                $kelengkapan  = $request->kelengkapan;
                $persyaratan  = $request->persyaratan;

                $kelengkapanChecklist = Checklist::where('role_id',5)
                                         ->where('label','Kelengkapan')
                                         ->orderBy('sequence', 'asc')->get();
                $datakelengkapan = array();
                foreach ($kelengkapanChecklist as $key) {
                    array_push($datakelengkapan, $key->id);
                }
                $persyaratanChecklist = Checklist::where('role_id',5)
                                         ->where('label','Persyaratan')
                                         ->orderBy('sequence', 'asc')->get();
                $datapersyaratan = array();
                foreach ($persyaratanChecklist as $val) {
                    array_push($datapersyaratan, $val->id);
                }
            
                if(count($kelengkapan) <> 0){
                    ProposalChecklist::where('proposal_id',$id)->whereIn('checklist_id',$datakelengkapan)->delete();
                    foreach($kelengkapan as $index => $value) {
                        $ProposalChecklistkelengkapan = new ProposalChecklist;
                        $ProposalChecklistkelengkapan->proposal_id = $id;
                        $ProposalChecklistkelengkapan->checklist_id = $value;
                        $ProposalChecklistkelengkapan->save();
                    }   
                }
                if(count($persyaratan) <> 0){
                    ProposalChecklist::where('proposal_id',$id)->whereIn('checklist_id',$datapersyaratan)->delete();
                    foreach($persyaratan as $index => $value) {
                        $ProposalChecklistpersyaratan = new ProposalChecklist;
                        $ProposalChecklistpersyaratan->proposal_id = $id;
                        $ProposalChecklistpersyaratan->checklist_id = $value;
                        $ProposalChecklistpersyaratan->save();
                    }
                }
            if($Proposal->current_stat < 3){
                $Proposalcs = Proposal::find($id);
		        $Proposalcs->current_stat  = 2;
		        $Proposalcs->save();
            }
		        $his1 = History::where('content_id',$id)->where('from_state',1)->where('to_state',1)->first();
		        $workflow = $this->getWorkflow('Proposal');
		        if(count($his1) == 0){
		        	History::create(['content_id' => $id,'workflow_id' => $workflow->first()->id,'from_state'=>1,'to_state'=>1,'user_id' => Auth::user()->id]);
		        }
		        $his2 = History::where('content_id',$id)->where('from_state',1)->where('to_state',2)->first();
		        if(count($his2) == 0){
		        	History::create(['content_id' => $Proposal->id,'workflow_id' => $workflow->first()->id,'from_state'=>1,'to_state'=>2,'user_id' => Auth::user()->id]);
		        }
		        
	        ProposalChecklist::where('proposal_id',$id)->where('checklist_id',13)->delete();
	        ProposalChecklist::create(['proposal_id' => $id,'checklist_id' => 13,'value' => $request->keterangan]);
	        $jumlah = $request->jumlah;
	        $correction = $request->correction;
	        $deskor = $request->deskor;
			if($request->deskripsi){
	        		ProposalDana::where('proposal_id',$id)->delete();
					$i = 1;
					foreach($request->deskripsi as $index => $value) {
						if(isset($value)){
							$v1 = isset($jumlah[$index])?$jumlah[$index]:0;
							$v2 = isset($correction[$index])?$correction[$index]:0;
							$v3 = isset($deskor[$index])?$deskor[$index]:NULL;
							$uid = isset(Auth::user()->id)?Auth::user()->id:NULL;
							ProposalDana::create(['proposal_id' => $id,'sequence' => $i,'description' => $value,'amount' => $v1,'correction' => $v2,'deskor' => $v3,'korid'=>$uid,'correction_inspektorat' => $v2,'desins' => $v3,'insid'=>$uid]);
							$i++;
						}
					}
			}
        }

        $message = 'Proposal Data Saved Successfuly';
        Session::flash('message', $message);
        return redirect()->route('proposals')->with('message', 'Proposal Data Saved Successfuly');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'tahun' => 'required|numeric|digits:4',
            'type_id' => 'required|numeric',
            'user' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'kota' => 'required|numeric',
            'kec' => 'required|numeric',
            'kel' => 'required|numeric',
            'judul' => 'required|string|max:255',
            'latar' => 'required|string',
            'maksud' => 'required|string',
            'skpd' => 'required|numeric',
            'rek_jenis' => 'required',
            'rek_obj' => 'required',
            'rekening' => 'required',
            'keterangan' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'nik_ahu' => 'required|string|max:255',
        ]);
    }
  
	public function show($id){
        try {
			$data['Proposal']  = Proposal::where('id', $id)->first();
			$data['Checklist'] = ProposalChecklist::where('checklist_id','13')->where('proposal_id', $id)->first();
			$data['dana'] 	   = ProposalDana::where('proposal_id', $id)->get();
			// $data['Dmohon']    = ProposalDana::select('SUM(amount) AS mohon','SUM(correction) AS setuju')->where('proposal_id', $id)->groupBy('proposal_id')->get();
			$data['Dmohon'] = DB::table('proposal_dana')
							  ->select(DB::raw('SUM(amount) as mohon'),DB::raw('SUM(correction) as setuju'),DB::raw('SUM(correction_inspektorat) as setuju_inspektorat'),DB::raw('SUM(correction_tapd) as setuju_tapd'),DB::raw('SUM(correction_banggar) as setuju_banggar'))
							  ->where('proposal_id', $id)
							  ->groupBy('proposal_id')
							  ->first();
			// dd($data['Dmohon']);
			return view('backEnd.proposal.show',$data);
        } catch (Exception $e) {
            Session::flash('message', 'Error 404 #error not found');
			return redirect()->route('proposals');
        }
    }
	
	public function arsip($id){
        try {
            $roleid = ''.
            $idusr = '';
            if(isset(Auth::user()->id)){
                $roleid .= isset(Auth::user()->roles->first()->id)?Auth::user()->roles->first()->id:'';
                $idusr .= isset(Auth::user()->id)?Auth::user()->id:'';
            }
            if($idusr == ''){
                Session::flash('warning', 'Silahkan Login untuk mengakses halaman ini.');
                return redirect()->route('proposals');
            }else{
                if($roleid != 5 && $roleid != 1){
                    Session::flash('warning', 'Anda tidak diberikan hak akses untuk mengakses halaman ini.');
                    return redirect()->route('proposals');
                }
            }

            $Proposal  = Proposal::where('id', $id)->first();
            if(count($Proposal) == 0){
                Session::flash('warning', 'Anda tidak diberikan hak akses untuk mengakses halaman ini.');
                return redirect()->route('proposals');
            }
            if($roleid == 5){
                $current_stat = $Proposal->current_stat;
                $skpdid = isset(Auth::user()->skpd_id)?Auth::user()->skpd_id:'';
                if($skpdid != $Proposal->skpd_id){
                    Session::flash('warning', 'Anda tidak diberikan hak akses untuk mengakses halaman ini.');
                    return redirect()->route('proposals');
                }
            }
            $data['Proposal']  = $Proposal;
			$data['Checklist'] = ProposalChecklist::where('checklist_id','13')->where('proposal_id', $id)->first();
			$data['dana'] 	   = ProposalDana::where('proposal_id', $id)->get();
			$data['photos']    = ProposalPhoto::where('proposal_id', $id)->get();
			$data['lpj']    = ProposalLpj::where('proposal_id', $id)->get();
			$data['Dmohon'] = DB::table('proposal_dana')
							  ->select(DB::raw('SUM(amount) as mohon','SUM(correction) as setuju'))
							  ->where('proposal_id', $id)
							  ->groupBy('proposal_id')
							  ->first();
			// dd($data['Dmohon']);
			return view('backEnd.proposal.arsip',$data);
        } catch (Exception $e) {
            Session::flash('message', 'Error 404 #error not found');
			return redirect()->route('proposals');
        }
    }
	
	public function koreksi($id){
        // try {
            $roleid = ''.
            $idusr = '';
            if(isset(Auth::user()->id)){
                $roleid .= isset(Auth::user()->roles->first()->id)?Auth::user()->roles->first()->id:'';
                $idusr .= isset(Auth::user()->id)?Auth::user()->id:'';
            }
            if($idusr == ''){
                Session::flash('warning', 'Silahkan Login untuk mengakses halaman ini.');
                return redirect()->route('proposals');
            }else{
                if($roleid == 3 || $roleid == 7){
                    Session::flash('warning', 'Anda tidak diberikan hak akses untuk mengakses halaman ini.');
                    return redirect()->route('proposals');
                }
            }
			$workflow = $this->getWorkflow('Proposal');
			$Proposal  = Proposal::where('id', $id)->first();
            if(count($Proposal) == 0){
                Session::flash('warning', 'Anda tidak diberikan hak akses untuk mengakses halaman ini.');
                return redirect()->route('proposals');
            }
            if($roleid == 5){
                $current_stat = $Proposal->current_stat;
                $skpdid = isset(Auth::user()->skpd_id)?Auth::user()->skpd_id:'';
                if($skpdid != $Proposal->skpd_id){
                    Session::flash('warning', 'Anda tidak diberikan hak akses untuk mengakses halaman ini.');
                    return redirect()->route('proposals');
                }
            }
			$data['State']	= WorkflowTransition::where('workflow_id',$workflow->first()->id)->where('status',1)->orderBy('id', 'asc')->get();
			$data['kota']  = Kota::where('id_provinsi','36')->orderBy('id_kota', 'desc')->get();
			$data['RekJenis']	= Rekjenis::orderBy('nm_rek_jenis', 'asc')->get();
	        if($Proposal->kota){
	            $id_kota    = Kota::where('id_provinsi','36')->where('nama_kota',$Proposal->kota)->orderBy('id_kota', 'asc')->first();
				$kotaid = (count($id_kota) > 0)?($id_kota->id_kota?$id_kota->id_kota:''):'';
				$kecid = ''; $kelid = '';
				if($kotaid != ''){
					if($Proposal->kec){
						$id_kec    = Kecamatan::where('id_kota',$kotaid)->where('nama_kecamatan',$Proposal->kec)->orderBy('id_kecamatan', 'asc')->first();
						$kecid = (count($id_kec) > 0)?($id_kec->id_kecamatan?$id_kec->id_kecamatan:''):'';
						if($kecid != ''){
							if($Proposal->kel){
								$id_kel    = Kelurahan::where('id_kecamatan',$kecid)->where('nama_kelurahan',$Proposal->kel)->orderBy('id_kelurahan', 'asc')->first();
								$kelid = (count($id_kel) > 0)?($id_kel->id_kelurahan?$id_kel->id_kelurahan:''):'';
							}
						}
					}
				}
	            $data['datakota'] = $kotaid;
	            $data['datakec'] = $kecid;
	            $data['datakel'] = $kelid;
	        }else{
		        $data['datakota'] = '';
		        $data['datakec'] = '';
		        $data['datakel'] = '';
	        }
	        $opds = isset($Proposal->skpd)?$Proposal->skpd->kd_skpd:0;
	        if($opds <> 0){
				$kd_bidang = substr($opds,0,4);
				$typeproposal = $Proposal->typeproposal;
				if($typeproposal == 'Barang'){
					$data['prog']  = Program::where('kd_bidang', $kd_bidang)->get();
				}
	        }

			$data['Proposal']  = Proposal::where('id', $id)->first();
			//$data['Checklist'] = ProposalChecklist::where('checklist_id','13')->where('proposal_id', $id)->first();
			//$data['Checklistnya'] = ProposalChecklist::where('checklist_id','5')->where('proposal_id', $id)->first();
			$data['dana'] 	   = ProposalDana::where('proposal_id', $id)->get();
			$data['Checklist'] = ProposalChecklist::where('checklist_id','13')->where('proposal_id', $id)->first();
			
			$data['Kelengkapan']	= Checklist::where('role_id',5)->where('label','Kelengkapan')->orderBy('sequence', 'asc')->get();
			$data['Persyaratan']	= Checklist::where('role_id',5)->where('label','Persyaratan')->orderBy('sequence', 'asc')->get();
			$data['ProposalChecklist']  = ProposalChecklist::where('proposal_id', $id)->get();

			$data['Dmohon'] = DB::table('proposal_dana')
							  ->select(DB::raw('SUM(amount) as mohon'),DB::raw('SUM(correction) as setuju'),DB::raw('SUM(correction_inspektorat) as setuju_inspektorat'),DB::raw('SUM(correction_tapd) as setuju_tapd'),DB::raw('SUM(correction_banggar) as setuju_banggar'))
							  ->where('proposal_id', $id)
							  ->groupBy('proposal_id')
							  ->first();
			$searchHistory = History::where('content_id',$id)->where('workflow_id',$workflow->first()->id)->first();
			// $transition = WorkflowTransition::where('from','daftar')->where('to','daftar')->first();
			
			if(count($searchHistory)==0){
				History::create(['content_id' => $id,'workflow_id' => $workflow->first()->id,'from_state'=>'1','to_state'=>'1','user_id' => Auth::user()->id]);
				if($Proposal->current_stat){
					if($Proposal->current_stat > 1){
						for($i=2;$i<=$Proposal->current_stat;$i++){
							if($i == 2){
								$ii = 1;
							}elseif($i == 3){
								$ii = 2;
							}elseif($i == 4){
								$ii = 3;
							}else{
								$ii = 4;
							}
							$his = History::where('content_id',$id)->where('from_state',$ii)->where('to_state',$i)->first();
							if(count($his) == 0){
								History::create(['content_id' => $id,'workflow_id' => $workflow->first()->id,'from_state' => $ii,'to_state' => $i,'user_id' => Auth::user()->id]);
							}
						}
					}
				}				
				$H = History::where('content_id',$id)->where('workflow_id',$workflow->first()->id)->get();
				foreach($H as $r){
					$from_to = WorkflowState::where('id',$r->to_state)->first();
				}
			}else{	
				// if($Proposal->current_stat){
				// 	if($Proposal->current_stat > 1){
				// 		for($i=2;$i<=$Proposal->current_stat;$i++){
				// 			if($i == 2){
				// 				$ii = 1;
				// 			}elseif($i == 3){
				// 				$ii = 2;
				// 			}elseif($i == 4){
				// 				$ii = 3;
				// 			}else{
				// 				$ii = 4;
				// 			}
				// 			$his = History::where('content_id',$id)->where('from_state',$ii)->where('to_state',$i)->first();
				// 			if(count($his) == 0){
				// 				History::create(['content_id' => $id,'workflow_id' => $workflow->first()->id,'from_state' => $ii,'to_state' => $i,'user_id' => Auth::user()->id]);
				// 			}
				// 		}
				// 	}
				// }			
				$H = History::where('content_id',$id)->where('workflow_id',$workflow->first()->id)->get();
				foreach($H as $r){
					$from_to = WorkflowState::where('id',$r->to_state)->first();
				}				
			}
			
			// dd($from_to);
			$data['transitions'] = WorkflowTransition::where('status',1)->where('from',$from_to->name)->where('workflow_id',$workflow->first()->id)->get();
			$data['guard']       = WorkflowGuard::all();
			$data['skpd']		 = Skpd::orderBy('name', 'asc')->get();
			$data['Type']		 = ProposalType::orderBy('name', 'asc')->get();
			return view('backEnd.proposal.koreksi',$data);
        // } catch (Exception $e) {
            // Session::flash('message', 'Error 404 #error not found');
			// return redirect()->route('proposals');
        // }
    }
	
	public function cekUp($id,$to){
		
		try {
			$workflow = $this->getWorkflow('Proposal');
			$data['Proposal']  = Proposal::where('id', $id)->first();
			$searchHistory = History::where('content_id',$data['Proposal']->id)->where('workflow_id',$workflow->first()->id)->first();
			if(count($data['Proposal'])==0){
				History::create(['content_id' => $data['Proposal']->id,'workflow_id' => $workflow->first()->id,'from_state'=>'1','to_state'=>'1','user_id' => Auth::user()->id]);
				$from_to = WorkflowState::where('id',$searchHistory->to_state)->first();
			}
			 return redirect()->back();
		} catch (Exception $e) {
			return redirect()->back();
		}
    }
	
	public function cekList(Request $request,$id){
		$workflow = $this->getWorkflow('Proposal');
		$Proposal  = Proposal::where('id', $id)->first();  
		if(count($Proposal)>0){				
			$from = WorkflowState::where('name',$request->from)->first();
			$to   = WorkflowState::where('name',$request->to)->first();
			// $from_to = WorkflowState::where('id',$searchHistory->to_state)->first();
	        if(!Auth::user()->hasRole('warga') || !Auth::user()->hasRole('user')){
	            if($Proposal->current_stat < 2){
	            	if($request->to == 'ditolak'){	            		 	
				        $his = History::where('content_id',$id)->where('from_state',$from->id)->where('to_state',$to->id)->first();
				        if(count($his) == 0){
		            		History::create(['content_id' => $id,'workflow_id' => $workflow->first()->id,'from_state'=>$from->id,'to_state'=>$to->id,'user_id' => Auth::user()->id]);

			            	if($Proposal->current_stat < $to->id){
			            		Proposal::where('id',$id)->update(['current_stat' => $to->id]);	 
			            	}

			            	if($Proposal->current_stat == $from->id && $to->id == 1){
			            		Proposal::where('id',$id)->update(['current_stat' => $to->id]);	 
			            	}
				        }
				        return redirect()->back();
	            	}
			        $Proposal->tahun    = $request->tahun;
			        $Proposal->type_id    = $request->type_id;
			        $Proposal->user   = $request->user;
			        $Proposal->name    = $request->name;
			        $Proposal->address   = $request->address;
			        $Kota           = Kota::where('id_kota', $request->kota)->first();
			        $Kecamatan      = Kecamatan::where('id_kecamatan', $request->kec)->first();
			        $Kelurahan      = Kelurahan::where('id_kelurahan', $request->kel)->first();
			        $Proposal->kota       = ucwords(strtolower($Kota->nama_kota));
			        $Proposal->kec  = ucwords(strtolower($Kecamatan->nama_kecamatan));
			        $Proposal->kel  = ucwords(strtolower($Kelurahan->nama_kelurahan));
			        $Proposal->judul      = $request->judul;
			        $Proposal->latar_belakang = $request->latar;
			        $Proposal->maksud_tujuan   = $request->maksud;
			        $Proposal->skpd_id  = $request->skpd;
			        $Proposal->sub_skpd  = $request->sub_skpd?$request->sub_skpd:NULL;
					$Proposal->rekening = $request->rekening;
					$Proposal->typeproposal = isset($request->typeproposal)?$request->typeproposal:'Uang';
			        $Proposal->kategori  = $request->kategori;
			        $Proposal->nik_ahu  = $request->nik_ahu;
			        $Proposal->save();
			        
	                $kelengkapan  = $request->kelengkapan;
	                $persyaratan  = $request->persyaratan;

	                $kelengkapanChecklist = Checklist::where('role_id',5)
	                                         ->where('label','Kelengkapan')
	                                         ->orderBy('sequence', 'asc')->get();
	                $datakelengkapan = array();
	                foreach ($kelengkapanChecklist as $key) {
	                    array_push($datakelengkapan, $key->id);
	                }
	                $persyaratanChecklist = Checklist::where('role_id',5)
	                                         ->where('label','Persyaratan')
	                                         ->orderBy('sequence', 'asc')->get();
	                $datapersyaratan = array();
	                foreach ($persyaratanChecklist as $val) {
	                    array_push($datapersyaratan, $val->id);
	                }
	            
	                if(count($kelengkapan) <> 0){
	                    ProposalChecklist::where('proposal_id',$id)->whereIn('checklist_id',$datakelengkapan)->delete();
	                    foreach($kelengkapan as $index => $value) {
	                        $ProposalChecklistkelengkapan = new ProposalChecklist;
	                        $ProposalChecklistkelengkapan->proposal_id = $id;
	                        $ProposalChecklistkelengkapan->checklist_id = $value;
	                        $ProposalChecklistkelengkapan->save();
	                    }   
	                }
	                if(count($persyaratan) <> 0){
	                    ProposalChecklist::where('proposal_id',$id)->whereIn('checklist_id',$datapersyaratan)->delete();
	                    foreach($persyaratan as $index => $value) {
	                        $ProposalChecklistpersyaratan = new ProposalChecklist;
	                        $ProposalChecklistpersyaratan->proposal_id = $id;
	                        $ProposalChecklistpersyaratan->checklist_id = $value;
	                        $ProposalChecklistpersyaratan->save();
	                    }
	                }
					Proposal::where('id',$id)->update(['current_stat' => $to->id]);

			        $his1 = History::where('content_id',$id)->where('from_state',1)->where('to_state',1)->first();
			        $workflow = $this->getWorkflow('Proposal');
			        if(count($his1) == 0){
			        	History::create(['content_id' => $id,'workflow_id' => $workflow->first()->id,'from_state'=>1,'to_state'=>1,'user_id' => Auth::user()->id]);
			        }
			        $his2 = History::where('content_id',$id)->where('from_state',1)->where('to_state',2)->first();
			        if(count($his2) == 0){
			        	History::create(['content_id' => $id,'workflow_id' => $workflow->first()->id,'from_state'=>1,'to_state'=>2,'user_id' => Auth::user()->id]);
			        }

			        ProposalChecklist::where('proposal_id',$id)->where('checklist_id',13)->delete();
			        ProposalChecklist::create(['proposal_id' => $id,'checklist_id' => 13,'value' => $request->keterangan]);
			        $jumlah = $request->jumlah;
			        $correction = $request->correction;
			        $deskor = $request->deskor;
			        $uid = isset(Auth::user()->id)?Auth::user()->id:NULL;
					if($request->deskripsi){
			        		ProposalDana::where('proposal_id',$id)->delete();
							$i = 1;
							foreach($request->deskripsi as $index => $value) {
								if(isset($value)){
										$v1 = isset($jumlah[$index])?$jumlah[$index]:0;
										$v2 = isset($correction[$index])?$correction[$index]:0;
										$v3 = isset($deskor[$index])?$deskor[$index]:NULL;
									ProposalDana::create(['proposal_id' => $id,'sequence' => $i,'description' => $value,'amount' => $v1,'correction' => $v2,'deskor' => $v3,'korid' => $uid,'correction_inspektorat' => $v2,'desins' => $v3,'insid' => $uid]);
									$i++;
								}
							}
					}
	            }else{   
	            	$verif = isset($request->verif)?$request->verif:'';   
	            	$roleid = isset(Auth::user()->roles->first()->id)?Auth::user()->roles->first()->id:'';	

			        $uid = isset(Auth::user()->id)?Auth::user()->id:NULL;
					$Dmohon = DB::table('proposal_dana')
								->select(DB::raw('SUM(amount) as mohon'),DB::raw('SUM(correction) as setuju'),DB::raw('SUM(correction_inspektorat) as setuju_inspektorat'),DB::raw('SUM(correction_tapd) as setuju_tapd'),DB::raw('SUM(correction_banggar) as setuju_banggar'))
								->where('proposal_id', $id)
								->groupBy('proposal_id')
								->first();
                    $stjins = isset($Dmohon->setuju_inspektorat)?str_replace('.00', '', $Dmohon->setuju_inspektorat):'0';
                    $stjtapd = isset($Dmohon->setuju_tapd)?str_replace('.00', '', $Dmohon->setuju_tapd):'0';
                    $stjbanggar = isset($Dmohon->setuju_banggar)?str_replace('.00', '', $Dmohon->setuju_banggar):'0';
	            	if($verif == 'no'){
	            		if($roleid==4 && $Proposal->typeproposal=='Barang' || $roleid==6 && $Proposal->typeproposal=='Barang' || $roleid==1 && $Proposal->typeproposal=='Barang' && $stjins!=0 && $stjtapd==0 && $stjbanggar==0){
							$Proposal->rekening = $request->rekening;
							$Proposal->program = isset($request->program)?$request->program:NULL;
							$Proposal->kegiatan = isset($request->kegiatan)?$request->kegiatan:NULL;
					        $Proposal->save();	            			
	            		}

				        $jumlah = $request->jumlah;
				        $correction = $request->correction;
				        $correction_inspektorat = $request->correction_inspektorat;
				        $correction_tapd = $request->correction_tapd;
				        $correction_banggar = $request->correction_banggar;
				        $deskor = $request->deskor;
				        $desins = $request->desins;
				        $destapd = $request->destapd;
				        $desbang = $request->desbang;

				        $korid = $request->korid;
				        $insid = $request->insid;
				        $tapdid = $request->tapdid;
				        $bangid = $request->bangid;
						if($request->deskripsi){
				        		ProposalDana::where('proposal_id',$id)->delete();
								$i = 1;
								foreach($request->deskripsi as $index => $value) {
									if(isset($value)){
										$v1 = isset($jumlah[$index])?$jumlah[$index]:0;
										$v2 = isset($correction[$index])?$correction[$index]:0;
										$v3 = isset($correction_inspektorat[$index])?$correction_inspektorat[$index]:NULL;
										$v4 = isset($correction_tapd[$index])?$correction_tapd[$index]:NULL;
										$v5 = isset($correction_banggar[$index])?$correction_banggar[$index]:NULL;
										$dk = isset($deskor[$index])?$deskor[$index]:NULL;
										$di = isset($desins[$index])?$desins[$index]:NULL;
										$dt = isset($destapd[$index])?$destapd[$index]:NULL;
										$db = isset($desbang[$index])?$desbang[$index]:NULL;

										$ki = isset($korid[$index])?$korid[$index]:NULL;
										$ii = isset($insid[$index])?$insid[$index]:NULL;
										$ti = isset($tapdid[$index])?$tapdid[$index]:NULL;
										$bi = isset($bangid[$index])?$bangid[$index]:NULL;
										$uidopd = $ki;
										if($roleid == 5){
											if($ki == NULL){
												$uidopd = $uid;
											}
										}
										$uidins = $ii;
										if($roleid == 11){
											if($ii == NULL){
												$uidins = $uid;
											}
										}
										$uidtapd = $ti;
										if($roleid == 4 || $roleid == 6){
											if($ti == NULL){
												$uidtapd = $uid;
											}
										}
										$uidbang = $bi;
										if($roleid == 12){
											if($bi == NULL){
												$uidbang = $uid;
											}
										}
										ProposalDana::create(['proposal_id' => $id,'sequence' => $i,'description' => $value,'amount' => $v1,'correction' => $v2,'correction_inspektorat' => $v3,'correction_tapd' => $v4,'correction_banggar' => $v5,'deskor' => $dk,'desins' => $di, 'destapd' => $dt, 'desbang' => $db, 'korid' => $uidopd, 'insid' => $uidins, 'tapdid' => $uidtapd, 'bangid' => $uidbang]);
										$i++;
									}
								}
						}
	            	}else{
				        $jumlah = $request->jumlah;
				        $correction = $request->correction;
				        $correction_inspektorat = $request->correction_inspektorat;
				        $correction_tapd = $request->correction_tapd;
				        $correction_banggar = $request->correction_banggar;
				        $deskor = $request->deskor;
				        $desins = $request->desins;
				        $destapd = $request->destapd;
				        $desbang = $request->desbang;

				        $korid = $request->korid;
				        $insid = $request->insid;
				        $tapdid = $request->tapdid;
				        $bangid = $request->bangid;
						if($request->deskripsi){
				        		ProposalDana::where('proposal_id',$id)->delete();
								$i = 1;
								foreach($request->deskripsi as $index => $value) {
									if(isset($value)){
										$v1 = isset($jumlah[$index])?$jumlah[$index]:0;
										$v2 = isset($correction[$index])?$correction[$index]:0;
										$v3 = isset($correction_inspektorat[$index])?$correction_inspektorat[$index]:NULL;
										$v4 = isset($correction_tapd[$index])?$correction_tapd[$index]:NULL;
										$v5 = isset($correction_banggar[$index])?$correction_banggar[$index]:NULL;
										$dk = isset($deskor[$index])?$deskor[$index]:NULL;
										$di = isset($desins[$index])?$desins[$index]:NULL;
										$dt = isset($destapd[$index])?$destapd[$index]:NULL;
										$db = isset($desbang[$index])?$desbang[$index]:NULL;

										$ki = isset($korid[$index])?$korid[$index]:NULL;
										$ii = isset($insid[$index])?$insid[$index]:NULL;
										$ti = isset($tapdid[$index])?$tapdid[$index]:NULL;
										$bi = isset($bangid[$index])?$bangid[$index]:NULL;
										$uidopd = $ki;
										if($roleid == 5){
											if($ki == NULL){
												$uidopd = $uid;
											}
										}
										$uidins = $ii;
										if($roleid == 11){
											if($ii == NULL){
												$uidins = $uid;
											}
										}
										$uidtapd = $ti;
										if($roleid == 4 || $roleid == 6){
											if($ti == NULL){
												$uidtapd = $uid;
											}
										}
										$uidbang = $bi;
										if($roleid == 12){
											if($bi == NULL){
												$uidbang = $uid;
											}
										}
										ProposalDana::create(['proposal_id' => $id,'sequence' => $i,'description' => $value,'amount' => $v1,'correction' => $v2,'correction_inspektorat' => $v3,'correction_tapd' => $v4,'correction_banggar' => $v5,'deskor' => $dk,'desins' => $di, 'destapd' => $dt, 'desbang' => $db, 'korid' => $uidopd, 'insid' => $uidins, 'tapdid' => $uidtapd, 'bangid' => $uidbang]);
										$i++;
									}
								}
						}    	
				        $his = History::where('content_id',$id)->where('from_state',$from->id)->where('to_state',$to->id)->first();
				        if(count($his) == 0){
		            		History::create(['content_id' => $id,'workflow_id' => $workflow->first()->id,'from_state'=>$from->id,'to_state'=>$to->id,'user_id' => Auth::user()->id]);

			            	if($Proposal->current_stat < $to->id){
			            		Proposal::where('id',$id)->update(['current_stat' => $to->id]);	 
			            	}

			            	if($Proposal->current_stat == $from->id && $to->id == 1){
			            		Proposal::where('id',$id)->update(['current_stat' => $to->id]);	 
			            	}
				        }	            		
	            	} 
	            }
	        }
		}
		return redirect()->back();
    }
	
	public function getUploadPath()
    {
        return $this->uploadPath;
    }
	
	public function getUploadPathPhoto()
    {
        return $this->uploadPathPhoto;
    }
	
	public function getUploadPathFile()
    {
        return $this->uploadPathFile;
    }
	
	public function getUploadPathFileLPJ()
    {
        return $this->uploadPathFilelpj;
    }
	
	public function uploadPhotos(Request $request)
    {
       $formFileName = "file";
       $new_file_name = false;
		if ($request->$formFileName != "") 
		{
            if ($request->$formFileName != "") {
				$new_file_name = $this->upload($this->getUploadPathPhoto(), $_FILES['file']['name'], $_FILES['file']['tmp_name'],false,'photo');
            }
		}
		if($new_file_name){
			$seq = ProposalPhoto::where('proposal_id',$request->proposal_id)->orderBy('sequence','DESC')->first();
			$sequence = isset($seq->sequence)?($seq->sequence+1):1;
	        $photo = ProposalPhoto::create([
	            'proposal_id'	=> $request->proposal_id,
	            'sequence'   	=> $sequence,
	            'path'			=> $new_file_name,
	        ]);

	        if (!$photo) {
				return response()->json(['id' => $photo->proposal_id,'title'=>'upload photo','content'=>'Error : Whoops Something went wrong, please try again.','error'=>true,'success'=>false,'message'=>'error']);
	        }
			return response()->json(['id' => $photo->proposal_id,'title'=>'upload photo','content'=>'Success : Photo has been uploaded.','error'=>false,'success'=>true,'message'=>'success']);
    	}else{
    		return response()->json(['id' => '','title'=>'upload photo','content'=>'Error : Whoops Something went wrong, please try again.','error'=>true,'success'=>false,'message'=>'error']);
    	}
    }
	
	public function uploadFile(Request $request)
    {
       $formFileName = "file";
       $new_file_name = false;
		if ($request->$formFileName != "") 
		{
            if ($request->$formFileName != "") {
				$new_file_name = $this->upload($this->getUploadPathFile(), $_FILES['file']['name'], $_FILES['file']['tmp_name'],false,'file');
            }
		}
		if($new_file_name){
			$photo =  Proposal::where('id', $request->proposal_id)->update(['file' => $new_file_name]);

	        if (!$photo) {
				return response()->json(['id' => $request->proposal_id,'title'=>'upload dokumen proposal','content'=>'Error : Whoops Something went wrong, please try again.','error'=>true,'success'=>false,'message'=>'error']);
	        }
			return response()->json(['id' => $request->proposal_id,'title'=>'upload dokumen proposal','content'=>'Success : Dokumen proposal has been uploaded.','error'=>false,'success'=>true,'message'=>'success']);
    	}else{
    		return response()->json(['id' => '','title'=>'upload dokumen proposal','content'=>'Error : Whoops Something went wrong, please try again.','error'=>true,'success'=>false,'message'=>'error']);
    	}
    }
	
	public function uploadFileLPJ(Request $request)
    {
       $formFileName = "file";
       $new_file_name = false;
		if ($request->$formFileName != "") 
		{
            if ($request->$formFileName != "") {
				$new_file_name = $this->upload($this->getUploadPathFileLPJ(), $_FILES['file']['name'], $_FILES['file']['tmp_name'],false,'file');
            }
		}
		if($new_file_name){
			$seq = ProposalLpj::where('proposal_id',$request->proposal_id)->orderBy('sequence','DESC')->first();
			$sequence = isset($seq->sequence)?($seq->sequence+1):1;
			if($sequence == 1){
				$propos =  Proposal::where('id', $request->proposal_id)->update(['tanggal_lpj' => date('Y-m-d')]);
			}
	        $photo = ProposalLpj::create([
	            'proposal_id'	=> $request->proposal_id,
	            'sequence'   	=> $sequence,
	            'path'			=> $new_file_name,
	        ]);

	        if (!$photo) {
				return response()->json(['id' => $photo->proposal_id,'title'=>'upload LPJ','content'=>'Error : Whoops Something went wrong, please try again.','error'=>true,'success'=>false,'message'=>'error']);
	        }
			return response()->json(['id' => $photo->proposal_id,'title'=>'upload LPJ','content'=>'Success : LPJ has been uploaded.','error'=>false,'success'=>true,'message'=>'success']);
    	}else{
    		return response()->json(['id' => '','title'=>'upload LPJ','content'=>'Error : Whoops Something went wrong, please try again.','error'=>true,'success'=>false,'message'=>'error']);
    	}
    }
	
	static function upload($dir, $files_name, $files_tmp, $fn='', $jenis=false)
	{
		$fileext = explode('.', $files_name);
		$file_ext = strtolower(end($fileext));
		
		$new_name = $fn ? $fn : md5(date("YmdHms").'_'.rand(100, 999));
		$new_file_name = $new_name.'.'.$file_ext;
		
		$file_path = $dir.$new_file_name;
		$up = false;
		if($jenis == 'photo'){
			if(in_array($file_ext, array('jpg','jpeg','png','gif'), true)){
				$up = true;
			}
		}elseif($jenis == 'file'){
			if(in_array($file_ext, array('pdf'), true)){
				$up = true;
			}
		}
		if($up){
			if(!in_array($file_ext, array('php','html'), true)){
				move_uploaded_file($files_tmp, $file_path);
				if(file_exists($file_path)){
					return $new_file_name;
				}
				else return false;
			}
			else return false;
		}
		else return false;
	}
	
	public function delImg($id)
	{
		$image_path = $this->getUploadPathPhoto().$id;
		if (File::exists($image_path)) {
			unlink($image_path);
		}
		
		ProposalPhoto::where('path',$id)->delete();

		return redirect()->back()->with('message', 'Data deleted!');
	}
	
	public function delFile($id)
	{
		$img = Proposal::findOrFail($id);
		$file_path = $this->getUploadPathFile().$img->file;
		if (File::exists($file_path)) {
			unlink($file_path);
		}
		$photo =  Proposal::where('id', $id)->update(['file' => '']);

		return redirect()->back()->with('message', 'Data deleted!');
	}
	
	public function delFileLPJ($id)
	{
		$file_path = $this->getUploadPathFileLPJ().$id;
		if (File::exists($file_path)) {
			unlink($file_path);
		}
		$photo =  ProposalLpj::where('path', $id)->delete();

		return redirect()->back()->with('message', 'Data deleted!');
	}
	
	static function reArrayFiles(&$file_post) {

	    $file_ary = array();
	    $file_count = count($file_post['name']);
	    $file_keys = array_keys($file_post);

	    for ($i=0; $i<$file_count; $i++) {
	        foreach ($file_keys as $key) {
	            $file_ary[$i][$key] = $file_post[$key][$i];
	        }
	    }

	    return $file_ary;
	}
	
	private function getWorkflow($model)
	{
		$data = Workflow::where('content_type', 'like', '%' . $model . '%')->where('state',1);
		return $data;
    }
	
	 private function getState($state){
      $name = \Transliteration::clean_filename(strtolower($state));
			$data = WorkflowState::where('status', 1)->where('name',$name);
      return $data;
    }
	
	private function getHistory($content_id,$wk_id){
		$data = History::with('getProposal')
                         ->with('getWorkflow')
                         ->with('getStateFrom')
                         ->with('getStateTo')
                         ->with('getUserName')
                         ->where('content_id', $content_id)
                         ->where('workflow_id', $wk_id);
		return $data;
    }
	
    public function export(Request $request)
    {
		$skpd_id	= $request->skpd_id?$request->skpd_id:'';
		$type_id	= $request->type_id?$request->type_id:'';
		$tahun		= $request->tahun?$request->tahun:'';
		$perubahan	= $request->perubahan?$request->perubahan:'';
		$from		= $request->from?$request->from:date('Y-m-d');
		$to			= $request->to?$request->to:date('Y-m-d');
		$q 		 	= Proposal::with('galeri')
							->with('dana')
							->with('skpd')
							->with('status')
							->with('checklist')
							->with('type');
			
        if($skpd_id){
            $q		= $q->where('skpd_id',$skpd_id);
        }
        if($type_id){
            $q		= $q->where('type_id',$type_id);
        }
        if($tahun){
            $q		= $q->where('tahun',$tahun);
        }
        if($perubahan){
            if($tahun){
                $q	= $q->where('perubahan',$perubahan);
            }else{
                Session::flash('warning', 'Silahkan Pilih Tahun Anggaran.');
                return redirect()->route('proposalsExport');                
            }
        }
        if($from){
            if($to){
				if(strtotime($from) < strtotime($to)){
					$q	= $q->whereBetween(DB::raw('DATE(time_entry)'),[$from, $to]);
				}elseif(strtotime($from) > strtotime($to)){
					$q	= $q->whereBetween(DB::raw('DATE(time_entry)'),[$to, $from]);
				}elseif(strtotime($from) == strtotime($to)){
					$q	= $q->whereBetween(DB::raw('DATE(time_entry)'),[$from, $to]);
				}
            }else{
                $q	= $q->whereBetween(DB::raw('DATE(time_entry)'),[$from, $from]);
            }
        }
        if($to){
            if($from){
				if(strtotime($from) < strtotime($to)){
					$q	= $q->whereBetween(DB::raw('DATE(time_entry)'),[$from, $to]);
				}elseif(strtotime($from) > strtotime($to)){
					$q	= $q->whereBetween(DB::raw('DATE(time_entry)'),[$to, $from]);
				}elseif(strtotime($from) == strtotime($to)){
					$q	= $q->whereBetween(DB::raw('DATE(time_entry)'),[$from, $to]);
				}
            }else{
                $q	= $q->whereBetween(DB::raw('DATE(time_entry)'),[$to, $to]);
            }
        }
		$Proposal  = $q->orderBy('proposal.id', 'desc')->paginate(env('BACKEND_PAGINATION'));
		$Proposal->appends(['skpd_id' => $skpd_id, 'type_id' => $type_id, 'tahun' => $tahun, 'perubahan' => $perubahan, 'from' => $from, 'to' => $to]);
        $th  = Proposal::whereNotNull('tahun')->groupBy('proposal.tahun')->get();
        $Skpd= Skpd::all();
        $ProposalType= ProposalType::all();
        $roleid = isset(Auth::user()->roles->first()->id)?Auth::user()->roles->first()->id:'';
        $urlexport = route('proposalsExportXls').'?skpd_id='.$skpd_id.'&type_id='.$type_id.'&tahun='.$tahun.'&perubahan='.$perubahan.'&from='.$from.'&to='.$to;
        return view("backEnd.proposal.export", compact("Proposal","roleid","ProposalType","Skpd","type_id","from","tahun","th","skpd_id","to","urlexport","perubahan"));
    }
	
    public function exportxls(Request $request)
    {
		$skpd_id	= $request->skpd_id?$request->skpd_id:'';
		$type_id	= $request->type_id?$request->type_id:'';
		$tahun		= $request->tahun?$request->tahun:'';
		$perubahan	= $request->perubahan?$request->perubahan:'';
		$from		= $request->from?$request->from:date('Y-m-d');
		$to			= $request->to?$request->to:date('Y-m-d');
		$q 		 	= Proposal::with('galeri')
							->with('dana')
							->with('skpd')
							->with('status')
							->with('checklist')
							->with('type');
		$title = '';	
        if($skpd_id){
            $opd      = Skpd::where('id',$skpd_id)->get();
            if(count($opd) <> 0){
                $title  .= 'OPD '.$opd[0]->name.' ';
            }
            $q		= $q->where('skpd_id',$skpd_id);
        }
        if($type_id){
            $jenis    = ProposalType::where('id',$type_id)->get();
            if(count($jenis) <> 0){
                $title  .= 'Jenis '.$jenis[0]->name.' ';
            }
            $q		= $q->where('type_id',$type_id);
        }
        if($tahun){
            $title  .= 'Tahun Anggaran '.$tahun.' ';
            $q		= $q->where('tahun',$tahun);
        }
        if($perubahan){
            if($tahun){
                $title  .= 'Perubahan ';
                $q	= $q->where('perubahan',$perubahan);
            }else{
                Session::flash('warning', 'Silahkan Pilih Tahun Anggaran.');
                return redirect()->route('proposalsExport');                
            }
        }
        if($from){
            if($to){
				if(strtotime($from) < strtotime($to)){
					$title  .= 'Dari Tanggal '.date('d F Y',strtotime($from)).' Sampai Tanggal '.date('d F Y',strtotime($to));
					$q	= $q->whereBetween(DB::raw('DATE(time_entry)'),[$from, $to]);
				}elseif(strtotime($from) > strtotime($to)){
					$title  .= 'Dari Tanggal '.date('d F Y',strtotime($to)).' Sampai Tanggal '.date('d F Y',strtotime($from));
					$q	= $q->whereBetween(DB::raw('DATE(time_entry)'),[$to, $from]);
				}elseif(strtotime($from) == strtotime($to)){
					$title  .= 'Dari Tanggal '.date('d F Y',strtotime($from)).' Sampai Tanggal '.date('d F Y',strtotime($to));
					$q	= $q->whereBetween(DB::raw('DATE(time_entry)'),[$from, $to]);
				}
            }else{
                $title  .= 'Dari Tanggal '.date('d F Y',strtotime($from)).' Sampai Tanggal '.date('d F Y',strtotime($from));
                $q	= $q->whereBetween(DB::raw('DATE(time_entry)'),[$from, $from]);
            }
        }else{
			if($to){
				if($from){
					if(strtotime($from) < strtotime($to)){
						$title  .= 'Dari Tanggal '.date('d F Y',strtotime($from)).' Sampai Tanggal '.date('d F Y',strtotime($to));
						$q	= $q->whereBetween(DB::raw('DATE(time_entry)'),[$from, $to]);
					}elseif(strtotime($from) > strtotime($to)){
						$title  .= 'Dari Tanggal '.date('d F Y',strtotime($to)).' Sampai Tanggal '.date('d F Y',strtotime($from));
						$q	= $q->whereBetween(DB::raw('DATE(time_entry)'),[$to, $from]);
					}elseif(strtotime($from) == strtotime($to)){
						$title  .= 'Dari Tanggal '.date('d F Y',strtotime($from)).' Sampai Tanggal '.date('d F Y',strtotime($to));
						$q	= $q->whereBetween(DB::raw('DATE(time_entry)'),[$from, $to]);
					}
				}else{
					$title  .= 'Dari Tanggal '.date('d F Y',strtotime($to)).' Sampai Tanggal '.date('d F Y',strtotime($to));
					$q	= $q->whereBetween(DB::raw('DATE(time_entry)'),[$to, $to]);
				}
			}
		}
		$Proposal  = $q->orderBy('proposal.id', 'desc')->get();
		//$Proposal->appends(['skpd_id' => $skpd_id, 'type_id' => $type_id, 'tahun' => $tahun, 'perubahan' => $perubahan, 'from' => $from, 'to' => $to]);
        $th  = Proposal::whereNotNull('tahun')->groupBy('proposal.tahun')->get();
        $Skpd= Skpd::all();
        $ProposalType= ProposalType::all();
        $roleid = isset(Auth::user()->roles->first()->id)?Auth::user()->roles->first()->id:'';
        $urlexport = route('proposalsExportXls').'?skpd_id='.$skpd_id.'&type_id='.$type_id.'&tahun='.$tahun.'&perubahan='.$perubahan.'&from='.$from.'&to='.$to;
        return view("backEnd.proposal.xls", compact("Proposal","roleid","ProposalType","Skpd","type_id","from","tahun","th","skpd_id","to","urlexport","perubahan","title"));
    }
}
