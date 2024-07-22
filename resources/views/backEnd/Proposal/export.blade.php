@extends('backEnd.layout')

@section('content')
		<section class="content-header">
            <h1>Proposal Export</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/admin') }}">
                        <i class="fa fa-fw ti-home"></i> Dashboard 
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/proposals') }}">
                        <i class="fa fa-fw ti-home"></i> Proposal 
                    </a>
                </li>
                <li class="active">
                    Export
                </li>
            </ol>
        </section>
		<section class="content">
			   <div class="row">
                <div class="col-lg-12">
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left m-t-6">
                                <i class="ti-control-shuffle"></i> Proposal Export
                            </h3>
                            <div class="pull-right">
                            	@if($roleid==5 || $roleid==1 || $roleid==2 || $roleid==4 || $roleid==6)
									@if(count($Proposal) > 0)
										<a type="button" class="btn btn-primary btn-sm" target="_blank" href="{{$urlexport}}"><i class="fa ti-export"></i> Export Excel</a>
									@endif
								@endif
                            </div>
                        </div>
                        <div class="panel-body">
							<div class="row" style="margin-bottom:10px;">
                    <form action="{{ route('proposalsExport') }}"  method="GET">
                        <div class="col-lg-12">
                            <div class="col-md-2 col-sm-4">
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
                                        <option value="">Tahun</option>
                                                            
                                        @foreach($th as $row)
                                        <option value="{{ $row->tahun }}" {!! ($tahun==$row->tahun)?'selected':'' !!} >{{ $row->tahun }}</option>
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
                            <div class="col-md-3 col-sm-4">
                                <div class="form-group">
                                    <input id="from" placeholder="Dari tanggal" type="text" class="form-control" name="from" value="{!! ($from)?$from:date('Y-m-d') !!}">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-4">
                                <div class="form-group">
                                    <input id="to" placeholder="Sampai tanggal" type="text" class="form-control" name="to" value="{!! ($to)?$to:date('Y-m-d') !!}">
                                </div>
                            </div>
                            <div class="col-md-10 col-sm-4">
                                <div class="form-group">
                                    <select class="form-control skpd_id" name="skpd_id">
                                        <option value="">OPD</option>
                                                            
                                        @foreach($Skpd as $row)
                                        <option value="{{ $row->id }}" {!! ($skpd_id==$row->id)?'selected':'' !!} >{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4" align="center">
                                <div class="form-group">
                                    <button type="submit" id="btn-filter" class="btn btn-primary width-100 cari"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
								</div>
								
								@if(Session::has('message'))
									<div class="alert alert-info">
										{{ Session::get('message') }}
									</div>
								@endif
								<div class="table-responsive">
                                <table class="table table-striped">
                                    <thead> 
                                    <tr>
										<th>No</th>
										<th class="text-left">Judul</th>
										<th class="text-left">Tanggal Proposal</th>
										<th class="text-left">Tahun Anggaran</th>
										<th class="text-left">Tahapan</th>
										<th class="text-left">OPD</th>
										<th class="text-right">Nilai yang Diajukan</th>
										<th class="text-right">Nilai Dari OPD</th>
										<th class="text-right">Nilai Dari TAPD</th>
										<th class="text-right">Nilai yang Disetujui</th>
                                    </tr>
                                    </thead>
                                    <tbody>
										<?php $i = 1 + $Proposal->currentPage() * $Proposal->perPage() - $Proposal->perPage(); ?>
									   @foreach($Proposal as $row)
										<?php 
											if(isset($row->user)){
												$oleh = $row->user;
											}else{
												$oleh = $row->name;
											}											
											$konten = strip_tags($row->latar_belakang); $konten = substr($konten, 0, 150); $length = strlen($konten);
											$amount = 0; $v1 = 0; $v2 = 0; $v3 = 0; $v4 = 0;
                                  			$status = isset($row->status->label)?$row->status->label:'Daftar';
											$skpdd = '';
											if($row->skpd_id){
												$skpdd .= $row->skpd->name;
											}
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
											   <td><a href="{!! route('proposalsShow',["id"=>$row->id]) !!}">{!! $row->judul !!}</a></td>
											   <td>{!! date('M d, Y', strtotime($row->time_entry)) !!}</td>
											   <td>{{(($row->perubahan==1)?$row->tahun.' Perubahan':$row->tahun)}}</td>
											   <!--<td>{!! $oleh !!}</td>-->
											   <td>{!! $status !!} {!! $cek !!}</td>
											   <td>{!! $skpdd.$subskpd !!}</td>
											   <!--<td>{!! $konten !!}</td>-->
				                               <td class="text-right">Rp. {{number_format($amount,0,",",".")}},-</td>
				                               <td class="text-right">Rp. {{number_format($v1,0,",",".")}},-</td>
				                               <td class="text-right">Rp. {{number_format($v3,0,",",".")}},-</td>
				                               <td class="text-right">Rp. {{number_format($v4,0,",",".")}},-</td>
				                               <!--<td class="text-right">Rp. {{number_format($correction,0,",",".")}},-</td>-->
										</tr>
										@endforeach
                                    </tbody>
                                </table>
								
                            </div>
							<div class="row">
									<div class="col-md-4 col-sm-6 right">
									@if($Proposal->total() > 0 )
										<p class="" style="margin:10px">
											Tampil
											<strong>{{ (($Proposal->currentPage() - 1) * env('BACKEND_PAGINATION')) + 1 }}</strong>
											sampai
											<strong>{{ env('BACKEND_PAGINATION') * $Proposal->currentPage() > $Proposal->total()? $Proposal->total() : env('BACKEND_PAGINATION') * $Proposal->currentPage() }}</strong>
											dari
											<strong><span class="text-primary">{{ $Proposal->total() }}</span></strong>
											data
										</p>
										@endif
									</div>
									 <div class="col-md-8 col-sm-8 left">
										{!! $Proposal->render() !!}
									</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
		</section>
<script type="text/javascript">
   $(function(){
     $("#from").datetimepicker({
        format: 'Y-m-d',
        autoclose: true,
        todayHighlight: true,
		locale: 'id',
		timepicker: false,
    });
     $("#to").datetimepicker({
        format: 'Y-m-d',
        autoclose: true,
        todayHighlight: true,
		locale: 'id',
		timepicker: false,
    });
    $("#from").on('change', function(selected) {
        var startDate = new Date(selected.timeStamp);
        $("#to").datetimepicker('setStartDate', startDate);
        if($("#from").val() > $("#to").val()){
		console.log(startDate);
          $("#to").val($("#from").val());
        }
    });
 });
</script>
@endsection
