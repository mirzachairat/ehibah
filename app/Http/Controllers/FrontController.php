<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MetaTag;
use App\Models\Banner;
use App\Models\ProposalType;
use App\Models\Proposal;
use App\Models\Skpd;
use App\Models\ProposalDana;
use App\Models\WorkflowState;
use App\Models\User;
use App\Models\LogLogin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;


class FrontController extends Controller
{
    public function index(){
        MetaTag::set('title', 'E-HibahBansos - Home');
        MetaTag::set('description', 'E-HibahBansos - Aplikasi Hibah Bansos Provinsi Banten');

        $Banner  = Banner::where('status', 1)->get();
        $ProposalType= ProposalType::all();
        $tahun  = Proposal::whereNotNull('tahun')->groupBy('proposal.tahun')->get();
        $lastyears  = Proposal::whereNotNull('tahun')->groupBy('proposal.tahun')->orderBy('tahun','desc')->limit(1)->first();
        $lastyear = date('Y');
        // if(count($lastyears) <> 0){
        //     $lastyear = isset($lastyears->tahun)?$lastyears->tahun:date('Y');
        // }
        $perubahan = 0;
        $Proposalid  = Proposal::select('id','type_id','skpd_id','current_stat')
        ->where('tahun',$lastyear)
        // ->where('perubahan',$perubahan)
        ->orderBy('type_id', 'ASC')->get();
        $nilaihibah = 0;
        $nilaibansos = 0;
        $Proposalhibah = array();
        $Proposalbansos = array();
        if(count($ProposalType) <> 0){
            foreach ($ProposalType as $keys) {
                $keysid = $keys->id?$keys->id:0;
                $typehibah = array();
                $typebansos = array();
                if(count($Proposalid) <> 0){
                    foreach ($Proposalid as $key) {
                        if($keysid != 0 && $keysid == $key->type_id){
                            if($keysid == 1 && $key->type_id == 1){
                                array_push($typehibah, $key->id);
                            }
                            if($keysid == 2 && $key->type_id == 2){
                                array_push($typebansos, $key->id);
                            }
                        }
                    }
                }
                if($keysid == 1){
                    if(count($typehibah) <> 0){
                        $dananya = ProposalDana::select(DB::raw('SUM(amount) as nilai'))
                                               ->where('sequence',1)
                                               ->whereIn('proposal_id',$typehibah)
                                               ->first();
                        // if(count($dananya) <> 0){
                        if(count(array($dananya)) <> 0){
                            $nilaihibah = isset($dananya->nilai)?$dananya->nilai:0;
                        }
                        $Proposalhibah  = Proposal::select('tahun','type_id',DB::raw('COUNT(id) as jumlah'))
                        ->with('galeri')
                        ->with('dana')
                        ->with('skpd')
                        ->with('status')
                        ->with('checklist')
                        ->with('type')
                        ->where('tahun',$lastyear)
                        ->where('perubahan',$perubahan)
                        ->where('type_id',$keysid)
                        ->groupBy('type_id')
                        ->groupBy('tahun')
                        ->orderBy('proposal.type_id', 'ASC')->first();
                    }
                }
                if($keysid == 2){
                    if(count($typebansos) <> 0){
                        $dananya = ProposalDana::select(DB::raw('SUM(amount) as nilai'))
                                               ->where('sequence',1)
                                               ->whereIn('proposal_id',$typebansos)
                                               ->first();
                        if(count(array($dananya)) <> 0){
                            $nilaibansos = isset($dananya->nilai)?$dananya->nilai:0;
                        }
                        $Proposalbansos  = Proposal::select('tahun','type_id',DB::raw('COUNT(id) as jumlah'))
                        ->with('galeri')
                        ->with('dana')
                        ->with('skpd')
                        ->with('status')
                        ->with('checklist')
                        ->with('type')
                        ->where('tahun',$lastyear)
                        ->where('perubahan',$perubahan)
                        ->where('type_id',$keysid)
                        ->groupBy('type_id')
                        ->groupBy('tahun')
                        ->orderBy('proposal.type_id', 'ASC')->first();
                    }
                }
            }
        }

        $Skpd= Skpd::all();
        $nilaiopd = array();
        $jumlahhibah = array();
        $jumlahbansos = array();
        $jumlahopd = array();
        if(count($Skpd) <> 0){
            foreach ($Skpd as $rows) {
                $idskpd = $rows->id?$rows->id:0;
                $Proposalopd  = Proposal::select('tahun','skpd_id',DB::raw('COUNT(id) as jumlah'))
                ->with('galeri')
                ->with('dana')
                ->with('skpd')
                ->with('status')
                ->with('checklist')
                ->with('type')
                ->where('tahun',$lastyear)
                // ->where('perubahan',$perubahan)
                ->where('skpd_id',$idskpd)
                ->groupBy('skpd_id')
                ->groupBy('tahun')
                ->orderBy('proposal.skpd_id', 'ASC')->get();
                if(count($Proposalopd) <> 0){
                    foreach ($Proposalopd as $keys) {
                        $skpdid = $keys->skpd_id?$keys->skpd_id:0;
                        if($skpdid == $idskpd){
                            array_push($jumlahopd, $keys->jumlah);
                            $typenyaopd = array();
                            if(count($Proposalid) <> 0){
                                foreach ($Proposalid as $key) {
                                    if($skpdid != 0 && $skpdid == $key->skpd_id){
                                        array_push($typenyaopd, $key->id);
                                    }
                                }
                            }
                            if(count($typenyaopd) <> 0){
                                $dananyaopd = ProposalDana::select(DB::raw('SUM(amount) as nilai'))
                                                       ->where('sequence',1)
                                                       ->whereIn('proposal_id',$typenyaopd)
                                                       ->first();
                                if(count(array($dananyaopd)) <> 0){
                                    array_push($nilaiopd, $dananyaopd->nilai);
                                }
                            }

                            $Proposaljenisopdhibah  = Proposal::select(DB::raw('COUNT(id) as jumlah'))
                            ->where('tahun',$lastyear)
                            ->where('perubahan',$perubahan)
                            ->where('type_id',1)
                            ->where('skpd_id',$skpdid)
                            ->groupBy('skpd_id')
                            ->orderBy('proposal.skpd_id', 'ASC')->first();
                            if(count(array($Proposaljenisopdhibah)) <> 0){
                                array_push($jumlahhibah, $Proposaljenisopdhibah->jumlah);
                            }else{
                                array_push($jumlahhibah, 0);
                            }
                            
                            $Proposaltypeid = Proposal::where('type_id',2);
                            $Proposaljenisopdbansos  = Proposal::select(DB::raw('COUNT(id) as jumlah'))
                            ->where('tahun',$lastyear)
                            ->where('perubahan',$perubahan)
                            ->where('type_id',2)
                            ->where('skpd_id',$skpdid)
                            ->groupBy('skpd_id')
                            ->orderBy('proposal.skpd_id', 'ASC')->first();
                            if($Proposaljenisopdbansos !== null && count(array($Proposaljenisopdbansos)) <> 0){
                                array_push($jumlahbansos, $Proposaljenisopdbansos->jumlah);
                            }else{
                                array_push($jumlahbansos, 0);
                            }
                        }
                    }
                }
                else{
                    array_push($jumlahopd, 0);
                    array_push($nilaiopd, 0);
                    array_push($jumlahhibah, 0);
                    array_push($jumlahbansos, 0);
                }
            }
        }

        $State= WorkflowState::where('status', 1)->where('workflow_id',1)->get();
        $nilaistate = array();
        $jumlahhibahstate = array();
        $jumlahbansosstate = array();
        $jumlahproposalstate = array();
        if(count($State) <> 0){
            foreach ($State as $row) {
                $stateid = $row->id?$row->id:0;
                $Proposalstate  = Proposal::select('current_stat',DB::raw('COUNT(id) as jumlah'))
                    ->with('status')
                    ->where('tahun',$lastyear)
                    // ->where('perubahan',$perubahan)
                    ->where('current_stat',$stateid)
                    ->groupBy('current_stat')
                    ->groupBy('tahun')
                    ->orderBy('proposal.current_stat', 'ASC')->get();
                if(count($Proposalstate) <> 0){
                    foreach ($Proposalstate as $keys) {
                        $currentstat = $keys->current_stat?$keys->current_stat:0;
                        if($stateid == $currentstat){
                            array_push($jumlahproposalstate, $keys->jumlah);
                            $typenyastate = array();
                            if(count($Proposalid) <> 0){
                                foreach ($Proposalid as $key) {
                                    if($currentstat != 0 && $currentstat == $key->current_stat){
                                        array_push($typenyastate, $key->id);
                                    }
                                }
                            }
                            if(count($typenyastate) <> 0){
                                $dananyastate = ProposalDana::select(DB::raw('SUM(amount) as nilai'))
                                                       ->where('sequence',1)
                                                       ->whereIn('proposal_id',$typenyastate)
                                                       ->first();
                                if(count(array($dananyastate)) <> 0){
                                    array_push($nilaistate, $dananyastate->nilai);
                                }
                            }

                            $Proposalstatehibah  = Proposal::select(DB::raw('COUNT(id) as jumlah'))
                            ->where('tahun',$lastyear)
                            ->where('perubahan',$perubahan)
                            ->where('type_id',1)
                            ->where('current_stat',$currentstat)
                            ->groupBy('current_stat')
                            ->orderBy('proposal.current_stat', 'ASC')->first();
                            if(count(array($Proposalstatehibah)) <> 0){
                                array_push($jumlahhibahstate, $Proposalstatehibah->jumlah);
                            }else{
                                array_push($jumlahhibahstate, 0);
                            }
                            

                            $Proposalstatebansos  = Proposal::select(DB::raw('COUNT(id) as jumlah'))
                            ->where('tahun',$lastyear)
                            ->where('perubahan',$perubahan)
                            ->where('type_id',2)
                            ->where('current_stat',$currentstat)
                            ->groupBy('current_stat')
                            ->orderBy('proposal.current_stat', 'ASC')->first();
                            if($Proposalstatebansos !== null && count(array($Proposalstatebansos)) <> 0){
                                array_push($jumlahbansosstate, $Proposalstatebansos->jumlah);
                            }else{
                                array_push($jumlahbansosstate, 0);
                            }
                        }
                    }
                }else{
                    array_push($nilaistate, 0);
                    array_push($jumlahhibahstate, 0);
                    array_push($jumlahbansosstate, 0);
                    array_push($jumlahproposalstate, 0);
                }
            }
        }
        $th = $lastyear;
      
        return view('frontEnd.home',compact("Banner","ProposalType","Skpd","tahun","th","State","jumlahopd","nilaiopd","jumlahhibah","jumlahbansos","nilaistate","jumlahhibahstate","jumlahbansosstate","jumlahproposalstate","nilaihibah","nilaibansos","Proposalhibah","Proposalbansos","perubahan"));
    }
    public function pengumuman(){
        return view('frontEnd.pengumuman');
    }
}             
