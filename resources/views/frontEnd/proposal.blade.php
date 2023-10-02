@extends('Layouts.main')

@section('content')
@if(isset(Auth::user()->id))
<?php $roleid = isset(Auth::user()->roles->first()->id)?Auth::user()->roles->first()->id:''; 
      $skpdid = isset(Auth::user()->skpd_id)?Auth::user()->skpd_id:''; 
      $userid = isset(Auth::user()->id)?Auth::user()->id:''; 
?>
@else
<?php $roleid = ''; $skpdid = ''; $userid = ''; ?>
@endif
 <div class="block" id="berita">
    <div class="container">
        <br>
        <br>
        <br>
        <br>
            <ol class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/proposal') }}">Proposal</a></li>
            <li class="active">{{$title}}</li>
            </ol>
           <!-- <meta http-equiv="refresh" content="100;"> -->
            <section>
                <div class="form search-form">
                    <div class="">
                        <h2>{{$title}}
                            @if($roleid == 3 || $roleid == 5 || $roleid == 7)
                                <a href="{{ $urlproposal }}" class="btn btn-info btn-sm pull-right"><span class="fa fa-book"></span> {{$titleproposal}}</a>
                                <a href="{{ route('createProposal') }}" class="btn btn-primary btn-sm pull-right"><span class="fa fa-plus"></span> Create Proposal</a>
                            @endif
                        </h2><hr style="margin-top: 0;">
                        @if(Session::has('message'))
                            <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        @if(Session::has('warning'))
                            <div class="alert alert-warning alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{ Session::get('warning') }}
                            </div>
                        @endif
                        @if(Session::has('error'))
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        <form action="{{ $urlsearch }}"  method="GET">
                            <div class="row">
                                <div class="col-md-2 col-sm-4">
                                    <div class="form-group">
                                        <input type="text" name="judul" placeholder="Judul Proposal" value="{!! $judul !!}">
                                    </div>
                                </div>
                                <div class="col-md-1 col-sm-4">
                                    <div class="form-group">
                                        <select class="form-control type_id" name="type_id">
                                            <option value="">Jenis</option>
                                                                
                                            @foreach($ProposalType as $row)
                                            <option value="{{ $row->id }}" {!! ($type_id==$row->id)?'selected':'' !!} >{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-4">
                                    <div class="form-group">
                                        <select class="form-control tahun" name="tahun">
                                            <option value="">Tahun Anggaran</option>
                                                                
                                            @foreach($tahun as $row)
                                            <option value="{{ $row->tahun }}" {!! ($th==$row->tahun)?'selected':'' !!} >{{ $row->tahun }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-4">
                                    <div class="form-group">
                                        <select class="form-control perubahan" name="perubahan">
                                            <option value="">Pilih</option>
                                            <option value="0" {!! ($perubahan=="0")?'selected':null !!} >-</option>
                                            <option value="1" {!! ($perubahan=="1")?'selected':null !!} >Perubahan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-4">
                                    <div class="form-group">
                                        <select class="form-control skpd_id" name="skpd_id">
                                            <option value="">OPD</option>
                                                                
                                            @foreach($Skpd as $row)
                                            <option value="{{ $row->id }}" {!! ($skpd_id==$row->id)?'selected':'' !!} >{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-4">
                                    <div class="form-group">
                                        <select class="form-control current_stat" name="current_stat">
                                            <option value="">Tahapan</option>
                                                                
                                            @foreach($State as $row)
                                            <option value="{{ $row->id }}" {!! ($current_stat==$row->id)?'selected':'' !!} >{{ $row->label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1 col-sm-4" align="center">
                                    <div class="form-group">
                                        <button type="submit" id="btn-filter" class="btn btn-primary width-100 cari"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
                
                    <!--<div class="row per-row">
                        <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Tanggal Proposal</th>
                                <th>Tahun Anggaran</th>
                                <th>Tahapan</th>
                                <th>Nilai Pengajuan</th>
                                <th>Nilai dari OPD</th>
                                <th>Nilai dari TAPD</th>
                                <th>Nilai yang Disetujui</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1 + $Proposal->currentPage() * $Proposal->perPage() - $Proposal->perPage(); ?>
                            @foreach($Proposal as $row)
                                <?php $kontens = strip_tags($row->latar_belakang); 
                                      $konten = substr($kontens, 0, 150); 
                                      $amount = 0; $v1 = 0; $v2 = 0; $v3 = 0; $v4 = 0;
                                      $status = isset($row->status->label)?$row->status->label:'Daftar';
                                                $subskpd = '';
                                                if($row->sub_skpd){
                                                    $subskpd .= ' ('.$row->subskpd->nm_sub_skpd.')';
                                                }
                                ?>
                                @foreach($row->dana as $rows)
                                    <?php $amount += $rows->amount; $v1 += $rows->correction; $v2 += $rows->correction_inspektorat; $v3 += $rows->correction_tapd; $v4 += $rows->correction_banggar; ?>
                                @endforeach
                                <?php
                                    if($v4 > 0){ $correction = $v4; $cek = "(Oleh Banggar)"; }
                                    else{
                                        if($v3 > 0){ $correction = $v3; $cek = "(Oleh TAPD)"; }
                                        else{
                                            if($v2 > 0){ $correction = $v2; $cek = "(Oleh Inspektorat)"; }
                                            else{
                                                if($v1 > 0){ $correction = $v1; $cek = "(Oleh OPD)"; }
                                                else{ $correction = 0; $cek = ""; }
                                            }
                                        }
                                    }
                                ?>
                                
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td><a href="{!! route('ShowProposal',['id'=>$row->id]) !!}">{!! $row->judul !!}</a></td>
                                    <td>{!! date_format(date_create($row->time_entry),"d F Y") !!}</td>
                                    <td>{{(($row->perubahan==1)?$row->tahun.' Perubahan':$row->tahun)}}</td>
                                    <td>{!! $status !!} {!! $cek !!}</td>
                                    <td class="text-right">Rp. {{number_format($amount,0,",",".")}},-</td>
                                    <td class="text-right">Rp. {{number_format($v1,0,",",".")}},-</td>
                                    <td class="text-right">Rp. {{number_format($v3,0,",",".")}},-</td>
                                    <td class="text-right">Rp. {{number_format($v4,0,",",".")}},-</td>
                                    <td class="text-center">
                                        <a class="btn btn-info btn-xs" href="{!! route('ShowProposal',['id'=>$row->id]) !!}"><span class="fa fa-eye"></span> Show</a> 
                                    @if($roleid == 5)
                                        @if($row->skpd_id == $skpdid)
                                            <a href="{!! route('ArsipProposal',['id'=>$row->id]) !!}" class="btn btn-info btn-xs"><span class="fa fa-book"></span> Arsip</a>
                                        @endif
                                        @if($row->current_stat <= 2 && $row->skpd_id == $skpdid)
                                            @if($v2 == 0 && $v3 == 0 && $v4 == 0)
                                                <a class="btn btn-warning btn-xs" href="{!! route('editProposal',['id'=>$row->id]) !!}"><span class="fa fa-pencil"></span> Edit</a> 
                                                @if($row->user_id == $userid)
                                                    <a class="btn btn-danger btn-xs" href="{!! route('deleteProposal',['id'=>$row->id]) !!}"><span class="fa fa-trash"></span> Delete</a>
                                                @endif
                                            @endif
                                        @endif
                                    @elseif($roleid == 3 || $roleid == 7)
                                        @if($row->user_id == $userid)
                                            <a href="{!! route('ArsipProposal',['id'=>$row->id]) !!}" class="btn btn-info btn-xs"><span class="fa fa-book"></span> Arsip</a>
                                        @endif
                                        @if($row->current_stat <= 1 && $row->user_id == $userid)
                                        <a class="btn btn-warning btn-xs" href="{!! route('editProposal',['id'=>$row->id]) !!}"><span class="fa fa-pencil"></span> Edit</a> 
                                            @if($row->user_id == $userid)
                                            <a class="btn btn-danger btn-xs" href="{!! route('deleteProposal',['id'=>$row->id]) !!}"><span class="fa fa-trash"></span> Delete</a>
                                            @endif
                                        @endif
                                    @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div> -->
    
            <div class="row per-row">
                <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Badan / Lembaga / Organisasi Kemasyarakatan</th>							
                        <th>Alamat</th>
                        <th>Usulan Peruntukan</th>
                        <th>Tanggal Proposal</th>
                        <th>Nilai Proposal</th>
                        <th>Nilai Rekomendasi</th>
                        <!--<th>Nilai Hasil Pembahasan Bersama</th>
                        <th>Nilai Penetapan</th>-->
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1 + $Proposal->currentPage() * $Proposal->perPage() - $Proposal->perPage(); ?>
                    @foreach($Proposal as $row)
                        <?php $kontens = strip_tags($row->latar_belakang); 
                                $konten = substr($kontens, 0, 150); 
                                $amount = 0; $v1 = 0; $v2 = 0; $v3 = 0; $v4 = 0;
                                $status = isset($row->status->label)?$row->status->label:'Daftar';
                                        $subskpd = '';
                                        if($row->sub_skpd){
                                            $subskpd .= ' ('.$row->subskpd->nm_sub_skpd.')';
                                        }
                        ?>
                        @foreach($row->dana as $rows)
                            <?php $amount += $rows->amount; $v1 += $rows->correction; $v2 += $rows->correction_inspektorat; $v3 += $rows->correction_tapd; $v4 += $rows->correction_banggar; ?>
                        @endforeach
                        <?php
                            if($v4 > 0){ $correction = $v4; $cek = "(Oleh Banggar)"; }
                            else{
                                if($v3 > 0){ $correction = $v3; $cek = "(Oleh TAPD)"; }
                                else{
                                    if($v2 > 0){ $correction = $v2; $cek = "(Oleh Inspektorat)"; }
                                    else{
                                        if($v1 > 0){ $correction = $v1; $cek = "(Oleh OPD)"; }
                                        else{ $correction = 0; $cek = ""; }
                                    }
                                }
                            }
                        ?>
                        
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{!! isset($row->name)?$row->name:((isset($row->user)) ? $row->user : $row->name) !!}</td>
                            <td>{!! $row->address !!}</td>
                            <td><!--<a href="{!! route('ShowProposal',['id'=>$row->id]) !!}">-->{!! $row->judul !!}<!--</a>--></td>
                            <td>{!! date_format(date_create($row->time_entry),"d F Y") !!}</td>
                            <td class="text-right">Rp. {{number_format($amount,0,",",".")}},-</td>
                            <td class="text-right">Rp. {{number_format($v1,0,",",".")}},-</td>
                            <!--<td class="text-right">Rp. {{number_format($v3,0,",",".")}},-</td>
                            <td class="text-right">Rp. {{number_format($v4,0,",",".")}},-</td>-->
                            <td class="text-center">
                                <!--<a class="btn btn-info btn-xs" href="{!! route('ShowProposal',['id'=>$row->id]) !!}"><span class="fa fa-eye"></span> Show</a>--> 
                            @if($roleid == 5)
                                @if($row->skpd_id == $skpdid)
                                    <a href="{!! route('ArsipProposal',['id'=>$row->id]) !!}" class="btn btn-info btn-xs"><span class="fa fa-book"></span> Arsip</a>
                                @endif
                                @if($row->current_stat <= 2 && $row->skpd_id == $skpdid)
                                    @if($v2 == 0 && $v3 == 0 && $v4 == 0)
                                        <a class="btn btn-warning btn-xs" href="{!! route('editProposal',['id'=>$row->id]) !!}"><span class="fa fa-pencil"></span> Edit</a> 
                                        @if($row->user_id == $userid)
                                            <a class="btn btn-danger btn-xs" href="{!! route('deleteProposal',['id'=>$row->id]) !!}"><span class="fa fa-trash"></span> Delete</a>
                                        @endif
                                    @endif
                                @endif
                            @elseif($roleid == 3 || $roleid == 7)
                                @if($row->user_id == $userid)
                                    <a href="{!! route('ArsipProposal',['id'=>$row->id]) !!}" class="btn btn-info btn-xs"><span class="fa fa-book"></span> Arsip</a>
                                @endif
                                @if($row->current_stat <= 1 && $row->user_id == $userid)
                                <a class="btn btn-warning btn-xs" href="{!! route('editProposal',['id'=>$row->id]) !!}"><span class="fa fa-pencil"></span> Edit</a> 
                                    @if($row->user_id == $userid)
                                    <a class="btn btn-danger btn-xs" href="{!! route('deleteProposal',['id'=>$row->id]) !!}"><span class="fa fa-trash"></span> Delete</a>
                                    @endif
                                @endif
                            @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            <div class="row">
                    <div class="col-md-4 col-sm-6 right">
                    <nav aria-label="Page navigation">
                    @if($Proposal->total() > 0 )
                        <p class='info-page'>
                            Tampil
                            <strong>{{ (($Proposal->currentPage() - 1) * env('PAGINATION')) + 1 }}</strong>
                            sampai
                            <strong>{{ env('PAGINATION') * $Proposal->currentPage() > $Proposal->total()? $Proposal->total() : env('PAGINATION') * $Proposal->currentPage() }}</strong>
                            dari
                            <strong><span class="text-primary">{{ $Proposal->total() }}</span></strong>
                            data
                        </p>
                    @endif
                        </nav>
                </div>
                <div class="col-md-8 col-sm-8 left">
                    <nav aria-label="Page navigation" class="pull-right">
                            {!! $Proposal->render() !!}
                        </nav>
                </div>
            </div>
    </div>
 </div>
@endsection


