<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProposalType;
use App\Models\Proposal;
use App\Models\Skpd;
use App\Models\Kota;
use DataTables;
use App\Models\WorkflowState;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\ProposalChecklist;
use App\Models\ProposalDana;
use App\Models\ProposalPhoto;
use App\Models\ProposalLpj;
use App\Models\Cms;
use App\Models\Lock;
use App\Models\Checklist;
use App\Models\History;
use App\Models\WorkflowTransition;
use App\Models\Workflow;
use MetaTag,Helper;
use App\Models\User;
use App\Models\Permission;
use Auth,Validator,Input, Exception,Image,Redirect;
use File;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class ProposalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        MetaTag::set('title', 'E-HibahBansos - Proposal');
        MetaTag::set('description', 'E-HibahBansos - Aplikasi Hibah Bansos Provinsi Banten');

        $ProposalType= ProposalType::all();
        $Proposal  = Proposal::with('galeri')
        ->with('dana')
        ->with('skpd')
        ->with('status')
        ->with('checklist')
        ->with('type')->orderBy('proposal.id', 'desc')->paginate(env('PAGINATION'));
        $tahun  = Proposal::whereNotNull('tahun')->groupBy('proposal.tahun')->get();
        $Skpd= Skpd::all();
        $State= WorkflowState::where('status', 1)->where('workflow_id',1)->get();
        $type_id = '';
        $judul = '';
        $th = '';
        $skpd_id = '';
        $current_stat = '';
        $perubahan = '';
        $urlsearch = route('searchProposal');
        $title = "All Proposal";
        $titleproposal = "Proposal Saya";
        $urlproposal = route('myproposal');
        return view('frontEnd.proposal',compact("Proposal","ProposalType","Skpd","type_id","judul","tahun","th","skpd_id","current_stat","State","urlsearch","title","titleproposal","urlproposal","perubahan"));
    }

    public function create()
    {
        //jika sudah bisa create bisa didelete
        // $locked = Helper::locked();
        if($locked != 1){
            if(!Auth::user()->hasRole('superadministrator') && !Auth::user()->hasRole('administrator')){
                Session::flash('warning', 'Input Proposal Hibah Bansos Telah Ditutup.');
                return redirect()->route('proposal');
            }
        }		
        
        $tahunanggaran = Helper::tahunanggaran();
        if($tahunanggaran == 1){
            $tahun = date('Y')+1;
        }else{
            $tahun = date('Y');
        }	
        
        $perubahan = Helper::perubahan();
        // Session::flash('warning', 'Input Proposal Hibah Bansos Telah Ditutup.');
        // return redirect()->route('proposal');
        //delete sampe sini
        $roleid = ''.
        $id = '';
        if(isset(Auth::user()->id)){
            $roleid .= isset(Auth::user()->roles->first()->id)?Auth::user()->roles->first()->id:'';
            $id .= isset(Auth::user()->id)?Auth::user()->id:'';
        }
        if($id == ''){
            Session::flash('warning', 'Silahkan Login untuk mengakses halaman ini.');
            return redirect()->route('proposal');
        }else{
            if($roleid != 3 && $roleid != 5 && $roleid != 7){
                Session::flash('warning', 'Anda tidak diberikan hak akses untuk mengakses halaman ini.');
                return redirect()->route('proposal');
            }
        }

        MetaTag::set('title', 'E-HibahBansos - Create Proposal');
        MetaTag::set('description', 'E-HibahBansos - Aplikasi Hibah Bansos Provinsi Banten');

        $ProposalType= ProposalType::all();
        $Skpd= Skpd::all();
        $skpdid = '';
        $current_stat = 1;
        $kelengkapan = '';
        $persyaratan = '';
        if($roleid == 5){
            $skpdid .= isset(Auth::user()->skpd_id)?Auth::user()->skpd_id:'';
            //$Skpd= Skpd::where('id',$skpdid)->get();
            $current_stat = 2;
            $kelengkapan = Checklist::where('role_id',$roleid)
                                    ->where('label','Kelengkapan')
                                    ->orderBy('sequence', 'asc')->get();
            $persyaratan = Checklist::where('role_id',$roleid)
                                    ->where('label','Persyaratan')
                                    ->orderBy('sequence', 'asc')->get();
        }
        $State= WorkflowState::where('status', 1)->where('workflow_id',1)->get();
        $kota = Kota::where('id_provinsi','36')->orderBy('id_kota', 'desc')->get();
        dd($kota);
        $skpd_id = $skpdid;
        $title = "Create Proposal";
        $titleproposal = "Back";
        $urlproposal = route('myproposal');
        return view('Pages.proposal.create', compact(["ProposalType","Skpd","skpd_id","current_stat","State","title","titleproposal","urlproposal","roleid","kelengkapan","persyaratan","kota","tahun","perubahan"]));
    }
    public function arsip(){
        try {
            $roleid = ''.
            $idusr = '';
            if(isset(Auth::user()->id)){
                $roleid .= isset(Auth::user()->roles->first()->id)?Auth::user()->roles->first()->id:'';
                $idusr .= isset(Auth::user()->id)?Auth::user()->id:'';
            }
            if($idusr == ''){
                Session::flash('warning', 'Silahkan Login untuk mengakses halaman ini.');
                return redirect()->route('proposal');
            }else{
                if($roleid != 3 && $roleid != 5 && $roleid != 7){
                    Session::flash('warning', 'Anda tidak diberikan hak akses untuk mengakses halaman ini.');
                    return redirect()->route('proposal');
                }
            }

            MetaTag::set('title', 'E-HibahBansos - Arsip Proposal');
            MetaTag::set('description', 'E-HibahBansos - Aplikasi Hibah Bansos Provinsi Banten');

            $Proposal  = Proposal::where('id', $id)->first();
            if(count($Proposal) == 0){
                Session::flash('warning', 'Anda tidak diberikan hak akses untuk mengakses halaman ini.');
                return redirect()->route('proposal');
            }
            if($roleid == 5){
                $current_stat = $Proposal->current_stat;
                $skpdid = isset(Auth::user()->skpd_id)?Auth::user()->skpd_id:'';
                if($skpdid != $Proposal->skpd_id){
                    Session::flash('warning', 'Anda tidak diberikan hak akses untuk mengakses halaman ini.');
                    return redirect()->route('proposal');
                }
            }elseif($roleid == 3 || $roleid == 7){
                $current_stat = $Proposal->current_stat;
                if($Proposal->user_id != $idusr){
                    Session::flash('warning', 'Anda tidak diberikan hak akses untuk mengakses halaman ini.');
                    return redirect()->route('proposal');
                }
            }
            $data['Proposal']  = $Proposal;
            $data['Checklist'] = ProposalChecklist::where('checklist_id','13')->where('proposal_id', $id)->first();
            $data['dana']      = ProposalDana::where('proposal_id', $id)->get();
            $data['photos']    = ProposalPhoto::where('proposal_id', $id)->get();
            $data['lpj']    = ProposalLpj::where('proposal_id', $id)->get();
            $data['Dmohon'] = DB::table('proposal_dana')
                              ->select(DB::raw('SUM(amount) as mohon','SUM(correction) as setuju'))
                              ->where('proposal_id', $id)
                              ->groupBy('proposal_id')
                              ->first();
            // dd($data['Dmohon']);
            return view('frontEnd.arsip',$data);
        } catch (Exception $e) {
            Session::flash('message', 'Error 404 #error not found');
            return redirect()->route('proposal');
        }
    }
    public function myproposal()
    {
        $roleid = ''.
        $id = '';
        if(isset(Auth::user()->id)){
            $roleid .= isset(Auth::user()->roles->first()->id)?Auth::user()->roles->first()->id:'';
            $id .= isset(Auth::user()->id)?Auth::user()->id:'';
        }
        if($id == ''){
            Session::flash('warning', 'Silahkan Login untuk mengakses halaman ini.');
            return redirect()->route('proposal');
        }else{
            if($roleid != 3 && $roleid != 5 && $roleid != 7){
                Session::flash('warning', 'Anda tidak diberikan hak akses untuk mengakses halaman ini.');
                return redirect()->route('proposal');
            }
        }

        MetaTag::set('title', 'E-HibahBansos - Proposal Saya');
        MetaTag::set('description', 'E-HibahBansos - Aplikasi Hibah Bansos Provinsi Banten');

        $ProposalType= ProposalType::all();
        $q  = Proposal::with('galeri')
        ->with('dana')
        ->with('skpd')
        ->with('status')
        ->with('checklist')
        ->with('type')->where('user_id',$id);
        $Skpd= Skpd::all();
        $skpdid = '';
        if($roleid == 5){
            $skpdid .= isset(Auth::user()->skpd_id)?Auth::user()->skpd_id:'';
            $q        = $q->orWhere('skpd_id',$skpdid);
            //$Skpd= Skpd::where('id',$skpdid)->get();
        }
        $Proposal  = $q->orderBy('proposal.id', 'desc')->paginate(env('PAGINATION'));
        $tahun  = Proposal::whereNotNull('tahun')->groupBy('proposal.tahun')->get();
        $State= WorkflowState::where('status', 1)->where('workflow_id',1)->get();
        $type_id = '';
        $judul = '';
        $th = '';
        $skpd_id = '';
        $current_stat = '';
        $perubahan = '';
        $urlsearch = route('searchMyProposal');
        $title = "Proposal Saya";
        $titleproposal = "ALL Proposal";
        $urlproposal = route('proposal');
        return view('frontEnd.proposal',compact("Proposal","ProposalType","Skpd","type_id","judul","tahun","th","skpd_id","current_stat","State","urlsearch","title","titleproposal","urlproposal","perubahan"));
    }
}
