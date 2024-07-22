@extends('backEnd.layout')

@section('content')
<section class="content-header">
   <h1>Proposal </h1>
   <ol class="breadcrumb">
       <li><a href="{{ url('/') }}"><i class="fa fa-fw ti-home"></i> Dashboard</a></li>
       <li class="active">Proposal</li>
    </ol>
</section>
<section class="content">
			<div class="outer">
                <div class="inner bg-light lter">
                    <h3>{{ $Proposal->judul }}</h3>
                </div>
                <!-- /.inner -->
            </div>
            <div class="col-lg-12">
				 <p class="text-justify">
                        <?php
                            $alamat = $Proposal->address;
                            if($Proposal->kel){
                                $alamat .= ' Kelurahan '.$Proposal->kel;
                            }
                            if($Proposal->kec){
                                $alamat .= ' Kecamatan '.$Proposal->kec;
                            }
                            if($Proposal->kota){
                                $alamat .= ' '.$Proposal->kota;
                            }
                            $status = isset($Proposal->status->label)?$Proposal->status->label:'Daftar';
                        ?>
					<span >Tahun Anggaran :</span> {{(($Proposal->perubahan==1)?$Proposal->tahun.' Perubahan':$Proposal->tahun)}}</br>
					Nama (Individu atau Organisasi): {!! ((isset($Proposal->user)) ? $Proposal->user : $Proposal->name) !!}</br>
					Alamat : {!! $alamat !!}</br>
                </p>
				<h4>Latar Belakang :</h4>
                <p class="text-justify">
					&emsp; &emsp;{{ $Proposal->latar_belakang }}
                </p>
				<h4>Maksud dan Tujuan :</h4>
                <p class="text-justify">
					&emsp; &emsp;{{ $Proposal->maksud_tujuan }}
                </p>
				
				<p class="text-justify">
					Tanggal Masuk Proposal : {{ date('M d, Y', strtotime($Proposal->time_entry)) }}</br>
					Tahap : {!! $status !!}</br>
					Keterangan : @if(isset($Checklist->value)) {{ $Checklist->value }} @else - @endif </br>
					Tanggal Masuk LPJ : @if(isset($Proposal->tanggal_lpj)) {{ date('M d, Y', strtotime($Proposal->tanggal_lpj)) }} @else - @endif</br>
                </p>
          
                <div class="clearfix"></div>
            </div>
            <!--rightside bar -->
			
				<div class="row">
				<div class="col-md-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">
								<i class="fa fa-fw ti-move"></i> Transisi
							</h3>
							<span class="pull-right">
									<i class="fa fa-fw ti-angle-up clickable"></i>
							</span>
						</div>
						<div class="panel-body">
							<div class="form-body">
								<div style="padding-bottom:10px;">
									
								@foreach($transitions as $tr)
									@if($tr->label != "Terdaftar")
										@if($tr->label == "Pengecekan Proposal")
											{{Form::open(array('route'=>['cekUp_',$Proposal->id], 'method' => 'POST','files' => true, 'name' => 'sendnya', 'class' => 'grid-form'))}}
												<input type="hidden" name="id" value="{{$Proposal->id}}">
												<input type="hidden" name="from" value="{{$tr->from}}">
												<input type="hidden" name="to" value="{{$tr->to}}">


<section class="content">
 <div class="row" id="complex-form2">
                <div class="col-lg-10">
                        <fieldset>
                            <legend>Silahkan Cek Proposal</legend>
							 <div data-row-span="4">
                                <div data-field-span="2">
                                    <label>Tahun Anggaran {{(($Proposal->perubahan==1)?'Perubahan':'')}}</label>
                                   <select name="tahun" class="select2" required>
									<option value="">Pilih Tahun Anggaran</option>
									<?php
                                        if($Proposal->perubahan==1){
                                            echo '<option value="'.$Proposal->tahun.'" selected >'.$Proposal->tahun.'</option>';
                                        }else{
    										$date = date('Y')+10;
    										for($i=2000;$i<=$date;$i++){
    											echo '<option value="'.$i.'" '.($Proposal->tahun==$i?'selected':'').' >'.$i.'</option>';
    										}
                                        }
									?>
								</select>
                                </div>
                            </div>
                            <div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Jenis proposal</label>
                                     <select class="select2 jenisproposal" name="type_id" required>
                                        <option>Silahkan Pilih</option>
                                        @foreach($Type as $row)
										  <option value="{{$row->id}}" {!! ($Proposal->type_id==$row->id)?'selected':'' !!} >{{$row->name}}</option>
										@endforeach
									</select>
                                </div>
                            </div>
                            @if(Auth::user()->hasRole('opd') || Auth::user()->hasRole('superadministrator') || Auth::user()->hasRole('administrator')) 
                            <div data-row-span="4" class="typeproposal" style="display: none;">
                                <div data-field-span="4">
                                    <label>Type proposal</label>
                                     <select class="select2 typeproposal" id="typeproposal" name="typeproposal" style="display: none;">
                                        <option value="Uang" {!! ($Proposal->typeproposal=='Uang')?'selected':'' !!} >Uang</option>
                                        <option value="Barang" {!! ($Proposal->typeproposal=='Barang')?'selected':'' !!} >Barang/Jasa</option>
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Kategori</label>
                                     <select class="select2" name="kategori" id="kategori" required>
                                        <option>Silahkan Pilih</option>
                                        <option value="Individu" {!! ($Proposal->kategori=='Individu')?'selected':'' !!} >Individu / Perorang</option>
                                        <option value="Lembaga" {!! ($Proposal->kategori=='Lembaga')?'selected':'' !!} >Lembaga / Organisasi</option>
									</select>
                                </div>
                            </div>
                            <div data-row-span="1">
                                <div data-field-span="1">
                                    <label id="label_nik_ahu" for="nik_ahu">NIK</label>
									 <input type="text" name="nik_ahu" id="nik_ahu" value="{!! old('nik_ahu')?old('nik_ahu'):$Proposal->nik_ahu !!}" required autofocus>
                                </div>
                            </div>
                            <div data-row-span="1">
                                <div data-field-span="1">
                                    <label>Penanggungjawab</label>
									 <input type="text" name="user" value="{!! old('user')?old('user'):$Proposal->user !!}" required autofocus>
                                </div>
                            </div>
                           
                        </fieldset>
                        <fieldset>
                            <div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Nama (individu atau organisasi)</label>
                                     <input type="text" name="name" value="{!! old('name')?old('name'):$Proposal->name !!}" required>
                                </div>
                            </div>
							<div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Alamat</label>
									<textarea name="address" class="resize_vertical" required>{!! old('address')?old('address'):$Proposal->address !!}</textarea>
                                </div>
                            </div>
                                        <div data-row-span="4">
                                            <div data-field-span="4">
                                                <label for="kota"> Kota</label>
                                                <select name="kota" class="select2 kota" id="kota" required autofocus>
                                                    <option value="" data=""> Pilih Kota/Kabupaten </option>
                                                    @if(old('kota'))
                                                    <?php $val_kota = old('kota'); ?>
                                                    @else
                                                    <?php $val_kota = $datakota; ?>
                                                    @endif
                                                    @foreach($kota as $row)
                                                    <option value="{{ $row->id_kota }}" data="{{ $row->nama_kota }}" {!! ($val_kota==$row->id_kota)?'selected':'' !!} >{{ $row->nama_kota }}</option>
                                                    @endforeach
                                                </select>
                                                  @if ($errors->has('kota'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('kota') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div data-row-span="4">
                                            <div data-field-span="4">
                                                <label for="kec"> Kecamatan</label>
                                                <select name="kec" class="select2 kecamatan" id="kec" required autofocus>
                                                    <option value="" data=""> Pilih Kecamatan </option>
                                                </select>
                                                  @if ($errors->has('kec'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('kec') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div data-row-span="4">
                                            <div data-field-span="4">
                                                <label for="kel"> Kelurahan</label>
                                                <select name="kel" class="select2 kelurahan" id="kel" required autofocus>
                                                    <option value="" data=""> Pilih Kelurahan </option>
                                                </select>
                                                  @if ($errors->has('kel'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('kel') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </fieldset>
							<div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Judul Kegiatan</label>
                                    <input type="text" name="judul" value="{!! old('judul')?old('judul'):$Proposal->judul !!}" required>
                                </div>
                            </div>
							<div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Latar Belakang</label>
                                    <textarea name="latar" class="resize_vertical" required>{!! old('latar')?old('latar'):$Proposal->latar_belakang !!}</textarea>
                                </div>
                            </div>
							<div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Maksud dan Tujuan</label>
                                    <textarea name="maksud" class="resize_vertical" required>{!! old('maksud')?old('maksud'):$Proposal->maksud_tujuan !!}</textarea>
                                </div>
                            </div>
							<div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Opd</label>
                                    <select name="skpd" class="select2 skpd" id="skpd" required>
                                        <option>Silhkan Pilih</option>
                                        @foreach($skpd as $row)
										  <option  value="{{$row->id}}"  {!! (Auth::user()->skpd_id && Auth::user()->skpd_id==$row->id || $Proposal->skpd_id==$row->id) ? "selected='selected'":"" !!}>{{$row->name}}</option>
										@endforeach
									</select>
                                </div>
                            </div>
                            <div data-row-span="4">
                                <div data-field-span="4">
                                    <label for="sub_skpd">Sub Opd</label>
                                    <select name="sub_skpd" class="select2 sub_skpd" id="sub_skpd" >
                                        <option value="" data=""> Pilih Sub OPD </option>
                                </select>
                                @if ($errors->has('sub_skpd'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('sub_skpd') }}</strong>
                                                </span>
                                            @endif
                                </div>
                            </div>

                            <div class="hidden" data-row-span="4">
                                <div data-field-span="4">
                                    <label>Rekening Jenis</label>
                                    <select name="rek_jenis" class="select2 rekjenis" id="rek_jenis" required>
                                        <option> Pilih Jenis Rekening</option>
                                        @foreach($RekJenis as $row)
                                          <option  value="{{$row->kd_rek_jenis}}" {!! ($Proposal->type_id==$row->id)?'selected':'' !!} >{{$row->kd_rek_jenis}} - {{$row->nm_rek_jenis}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Rekening Obj</label>
                                    <select name="rek_obj" class="select2 rekobj" id="rek_obj" required>
                                        <option> Pilih Jenis Rekening</option>
                                    </select>
                                </div>
                            </div>

                            <div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Rekening Rincian</label>
                                    <select name="rekening" class="select2 rekrincian" id="rekening" required>
                                        <option> Pilih Rekening</option>
                                    </select>
                                </div>
                            </div>
                          
							</br>
							<div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Keterangan</label>
                                            <?php $keterangan = ''; ?>
                                            @if(count($ProposalChecklist) <> 0)
                                                @foreach($ProposalChecklist as $row)
                                                    @if($row->checklist_id == 13)
                                                    <?php $keterangan .= $row->value; ?>
                                                    @endif
                                                @endforeach
                                            @endif
                                    <textarea  name="keterangan" class="resize_vertical" >{!! old('keterangan')?old('keterangan'):$keterangan !!}</textarea>
                                </div>
                            </div>
                           <br>
                        </fieldset>
                        <br>
                        <fieldset>
                                            <?php $danaproposal = $Proposal->dana; $dananya = ''; $description = ''; $correct = ''; $deskor = ''; ?>
                                            @if(count($danaproposal) <> 0)
                                                @foreach($danaproposal as $row)
                                                    @if($row->sequence == 1)
                                                    <?php $dananya .= str_replace('.00', '', $row->amount); $description .= $row->description; $correct .= str_replace('.00', '', $row->correction); $deskor .= $row->deskor; ?>
                                                    @endif
                                                @endforeach
                                            @endif
                            <legend>Dana Yang diajukan <small><a class="dana btn btn-xs btn-primary" >Tambah Dana</a></small></legend>
                            <div data-row-span="1">
                                <div data-field-span="1">
                                    <label>Deskripsi</label>
                                     <textarea class="resize_vertical" name="deskripsi[]" required>{!! $description !!}</textarea>
                                </div>
                            </div> 
							<div data-row-span="1">
                                <div data-field-span="1" style="width: auto;">
                                    <label>Jumlah</label>
                                    <input type="number" name="jumlah[]" value="{!! $dananya !!}" required>
                                </div>
                                <div data-field-span="1" style="width: auto;">
                                    <label>Koreksi/Disetujui</label>
                                    <input type="number" name="correction[]" value="{!! $correct !!}" required>
                                </div>
                            </div>
                            <div data-row-span="1">
                                <div data-field-span="1" style="width: auto;">
                                    <label>Deskripsi Koreksi</label>
                                    <textarea class="resize_vertical" name="deskor[]" required>{!! $deskor !!}</textarea>
                                </div>
                            </div>
							<div id="dtarget">
                                            @if(count($danaproposal) <> 0)
                                                @foreach($danaproposal as $row)
                                                    @if($row->sequence > 1)
                                                    <?php
                                                        echo '<div data-row-span="1"><div data-field-span="1"> <label>Deskripsi</label> <textarea class="resize_vertical" name="deskripsi[]">'.$row->description.'</textarea></div></div> <div data-row-span="1"><div data-field-span="1" style="width:auto;"><label>Jumlah</label><input type="number" name="jumlah[]" value="'.str_replace('.00', '', $row->amount).'"></div><div data-field-span="1" style="width:auto;"><label>Koreksi/Disetujui</label><input type="number" name="correction[]" value="'.str_replace('.00', '', $row->correction).'"></div></div> <div data-row-span="1"><div data-field-span="1" style="width:auto;"><label>Deskripsi Koreksi</label><textarea class="resize_vertical" name="deskor[]">'.$row->deskor.'</textarea></div></div>';
                                                    ?>
                                                    @endif
                                                @endforeach
                                            @endif
                            </div>
							</br>
						</fieldset>
                        <br>
		</div>
	</div>
</section>



												<div class="form-group">
													<div class="col-sm-12">
													<label class="control-label"><h4>Kelengkapan Dokumen</h4></label>
													<div>
													 @foreach($Kelengkapan as $c)
				                                        <input id="kelengkapan{{$c->id}}" name="kelengkapan[]" type="checkbox" value="{{$c->id}}"
				                                                            @if(count($ProposalChecklist) <> 0)
				                                                                @foreach($ProposalChecklist as $rows)
				                                                                    @if($rows->checklist_id == $c->id)
				                                                                    {{'checked'}}
				                                                                    @endif
				                                                                @endforeach
				                                                            @endif >&nbsp;<label for="kelengkapan{{$c->id}}">{{$c->name}}</label></br>
													@endforeach
													</div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-12">
													<label class="control-label"><h4>Persyaratan Administrasi</h4></label>
													<div>
													@foreach($Persyaratan as $c)
				                                        <input id="persyaratan{{$c->id}}" name="persyaratan[]" type="checkbox" value="{{$c->id}}"
				                                                            @if(count($ProposalChecklist) <> 0)
				                                                                @foreach($ProposalChecklist as $rows)
				                                                                    @if($rows->checklist_id == $c->id)
				                                                                    {{'checked'}}
				                                                                    @endif
				                                                                @endforeach
				                                                            @endif >&nbsp;<label for="persyaratan{{$c->id}}">{{$c->name}}</label></br>
													@endforeach
													</div>
													</div>
												</div>
											
													@foreach($guard as $grd) 
														@if($grd->transition_id == $tr->id)
															@if(Auth::user()->can($grd->Permission->name) == $grd->Permission->name)
																<button class="btn btn-success" type="submit" > {{$tr->label}}</button>
															@else
																<button class="btn btn-success" type="submit"> {{$tr->label}}</button>
															@endif
														@endif
													@endforeach
<script type="text/javascript">
    var urlbase = location.protocol+"<?php echo str_replace('https:','',str_replace('http:','',url('/'))); ?>";  
 $(".dana").click(function(){
      var content = $('<div data-row-span="1"><div data-field-span="1"> <label>Deskripsi</label> <textarea class="resize_vertical" name="deskripsi[]"></textarea></div></div> <div data-row-span="1"><div data-field-span="1" style="width:auto;"><label>Jumlah</label><input type="number" name="jumlah[]"></div><div data-field-span="1" style="width:auto;"><label>Koreksi/Disetujui</label><input type="number" name="correction[]"></div></div> <div data-row-span="1"><div data-field-span="1" style="width:auto;"><label>Deskripsi Koreksi</label><textarea class="resize_vertical" name="deskor[]"></textarea></div></div>');
      $("#dtarget").append(content);
 }); 
 
 $(".addpoto").click(function(){
      var content = $('<div data-row-span="1"><div data-field-span="1"><input type="file" name="foto[]" class="foto"></div> </div>');
      $(".pototarget").append(content);
 });
 
 (function($) {
    $.fn.checkFileType = function(options) {
        var defaults = {
            allowedExtensions: [],
            success: function() {},
            error: function() {}
        };
        options = $.extend(defaults, options);

        return this.each(function() {

            $(this).on('change', function() {
                var value = $(this).val(),
                    file = value.toLowerCase(),
                    extension = file.substring(file.lastIndexOf('.') + 1);

                if ($.inArray(extension, options.allowedExtensions) == -1) {
                    options.error();
                    $(this).focus();
                } else {
                    options.success();

                }

            });

        });
    };

})(jQuery);
 
 $(function() {
    $('.proposal').checkFileType({
        allowedExtensions: ['pdf'],
        success: function() {
            // alert('Success');
        },
        error: function() {
            alert('Format proposal harus PDF, silakan ulangi lagi.');
            $('.proposal').val('');
        }
    });

});

$(function() {
    $('.foto').checkFileType({
        allowedExtensions: ['jpg', 'jpeg'],
        success: function() {
            // alert('Success');
        },
        error: function() {
            alert('Type File tidak sesuai');
            $('.foto').val('');
        }
    });

});
    
$(document).ready(function() {
   var kota = "<?php if(old('kota')){ $kab = old('kota'); }else{ $kab = $datakota; }echo $kab; ?>";
   var kec = "<?php if(old('kec')){ $kec = old('kec'); }else{ $kec = $datakec; }echo $kec; ?>";
   var kel = "<?php if(old('kel')){ $kel = old('kel'); }else{ $kel = $datakel; }echo $kel; ?>";
   var kabupaten = $('.kota');
   var kecamatan = $('.kecamatan');
   var kelurahan = $('.kelurahan');
   var kategori = $('#kategori');
   var skpd_old = "<?php if(old('skpd')){ $skpd = old('skpd'); }else{ $skpd = $Proposal->skpd_id; }echo $skpd; ?>";
   var sub_skpd_old = "<?php if(old('sub_skpd')){ $sub_skpd = old('sub_skpd'); }else{ $sub_skpd = $Proposal->sub_skpd; }echo $sub_skpd; ?>";
   var skpd = $('.skpd');
   var sub_skpd = $('.sub_skpd');

   var rek_jenis = "<?php echo old('rek_jenis'); ?>";
   var rek_obj = "<?php echo old('rek_obj'); ?>";
   var rek_rincian = "<?php echo old('rekening'); ?>";
   var rekjenis = $('.rekjenis');
   var rekobj = $('.rekobj');
   var rekrincian = $('.rekrincian');
   var type_id = "<?php if(old('type_id')){ $type_id = old('type_id'); }else{ $type_id = $Proposal->type_id; }echo $type_id; ?>";
   var jenisproposal = $('.jenisproposal');
   var type_proposal = "<?php if(old('typeproposal')){ $typeproposal = old('typeproposal'); }else{ $typeproposal = $Proposal->typeproposal; }echo $typeproposal; ?>";
   var typeproposal = $('.typeproposal');
   var rekening = "<?php echo $Proposal->rekening; ?>";
   if(rekening){
    var rek1 = rekening.slice(0, 3);
    var rek2 = rekening.slice(0, 5);
   }else{
    var rek1 = '';
    var rek2 = '';
   }
   if(type_id != ''){
      var jenisproposal_val = jenisproposal.val();
      var typeproposal_val = type_proposal;
      if(type_proposal == 'Barang'){
        if(jenisproposal_val == 1){
            var jenisproposal_rek = '52226';
            var valrek = '522';
            typeproposal.show();
        }else if(jenisproposal_val == 2){
            var jenisproposal_rek = '52227';
            var valrek = '522';
            typeproposal.show();
        }else{
            var jenisproposal_rek = jenisproposal_val;
            var valrek = '';
            typeproposal.hide();
        }
      }else{
        if(jenisproposal_val == 1){
            var jenisproposal_rek = '514';
            var valrek = '514';
            typeproposal.show();
        }else if(jenisproposal_val == 2){
            var jenisproposal_rek = '515';
            var valrek = '515';
            typeproposal.show();
        }else{
            var jenisproposal_rek = jenisproposal_val;
            var valrek = '';
            typeproposal.hide();
        }
      }
      $(rekjenis).val(valrek);
      var urlRekjenis = urlbase+"/rekobj/"+jenisproposal_rek;
      $.get(urlRekjenis, 
        function(response){
          $(rekobj).html(response);
          $(rekrincian).html("<option value='' data=''> Pilih Rekening Obj Rincian </option>");
          if(rek2){
            $(rekobj).val(rek2);
            changerek(rek2);            
          }
        });
   }
    
    if(jenisproposal.change(function(event) {
      var jenisproposal_val = jenisproposal.val();
      var typeproposal_val = type_proposal;
      if(type_proposal == 'Barang'){
        if(jenisproposal_val == 1){
            var jenisproposal_rek = '52226';
            var valrek = '522';
            $('#typeproposal').val('Uang');
            $('#typeproposal').change();
            typeproposal.show();
        }else if(jenisproposal_val == 2){
            var jenisproposal_rek = '52227';
            var valrek = '522';
            $('#typeproposal').val('Uang');
            $('#typeproposal').change();
            typeproposal.show();
        }else{
            var jenisproposal_rek = jenisproposal_val;
            var valrek = '';
            $('#typeproposal').val('Uang');
            $('#typeproposal').change();
            typeproposal.hide();
        }
      }else{
        if(jenisproposal_val == 1){
            var jenisproposal_rek = '514';
            var valrek = '514';
            $('#typeproposal').val('Uang');
            $('#typeproposal').change();
            typeproposal.show();
        }else if(jenisproposal_val == 2){
            var jenisproposal_rek = '515';
            var valrek = '515';
            $('#typeproposal').val('Uang');
            $('#typeproposal').change();
            typeproposal.show();
        }else{
            var jenisproposal_rek = jenisproposal_val;
            var valrek = '';
            $('#typeproposal').val('Uang');
            $('#typeproposal').change();
            typeproposal.hide();
        }
      }
      $(rekjenis).val(valrek);
      var urlRekjenis = urlbase+"/rekobj/"+jenisproposal_rek;
      $.get(urlRekjenis, 
        function(response){
          $(rekobj).html(response);
          $(rekrincian).html("<option value='' data=''> Pilih Rekening Obj Rincian </option>");
        });
   }));
    
    if($('#typeproposal').change(function(event) {
      var jenisproposal_val = jenisproposal.val();
      var typeproposal_val = $('#typeproposal').val();
      if(typeproposal_val == 'Barang'){
        if(jenisproposal_val == 1){
            var jenisproposal_rek = '52226';
            var valrek = '522';
        }else if(jenisproposal_val == 2){
            var jenisproposal_rek = '52227';
            var valrek = '522';
        }else{
            var jenisproposal_rek = jenisproposal_val;
            var valrek = '';
        }
      }else{
        if(jenisproposal_val == 1){
            var jenisproposal_rek = '514';
            var valrek = '514';
        }else if(jenisproposal_val == 2){
            var jenisproposal_rek = '515';
            var valrek = '515';
        }else{
            var jenisproposal_rek = jenisproposal_val;
            var valrek = '';
        }
      }
      $(rekjenis).val(valrek);
      var urlRekjenis = urlbase+"/rekobj/"+jenisproposal_rek;
      $.get(urlRekjenis, 
        function(response){
          $(rekobj).html(response);
          $(rekrincian).html("<option value='' data=''> Pilih Rekening Obj Rincian </option>");
        });
   }));

   rekobj.change(function(event) {
        var rekobj_val = rekobj.val();
        var urlRincian = urlbase+"/rekrincian/"+rekobj_val;
        $.get(urlRincian,
        function(response){
            $(rekrincian).html(response);
        });
    });

     function changerek(rek2){
        var rekobj_val = rek_obj?rek_obj:rek2;
        var urlRekrincian = urlbase+"/rekrincian/"+rekobj_val;
        $.get(urlRekrincian,
        function(response){
            $(rekrincian).html(response);
           if(rekening != ''){
                $(rekrincian).val(rekening);
           }
        });
   }

   if(skpd_old){
      var skpd_val = skpd_old;
      var urlSub = urlbase+"/sub/"+skpd_val;
      $.get(urlSub, 
        function(response){
          $(sub_skpd).html(response);
          $(sub_skpd).val(sub_skpd_old);
        });
   }

    if(skpd.change(function(event) {
      var skpd_val = skpd.val();
      var urlSub = urlbase+"/sub/"+skpd_val;
      $.get(urlSub, 
        function(response){
          $(sub_skpd).html(response);
        });
   }));

   if(kota != ''){
      var kabupaten_val = kabupaten.val()?kabupaten.val():kota;
      var urlKec = urlbase+"/kecamatan/"+kabupaten_val;
      $.get(urlKec, 
        function(response){
          $(kecamatan).html(response);
          $(kelurahan).html("<option value=''> Pilih Kelurahan </option>");
          if(kec != ''){
            $(kecamatan).val(kec);
            changekel();
          }
        });
   }
   function changekel(){
        var kecamatan_val = kec;
        var urlKel = urlbase+"/kelurahan/"+kecamatan_val;
        $.get(urlKel,
        function(response){
           $(kelurahan).html(response);
           if(kel != ''){
                $(kelurahan).val(kel);
           }
        });
   }
   if(kabupaten.change(function(event) {
      var kabupaten_val = kabupaten.val();
      var urlKec = urlbase+"/kecamatan/"+kabupaten_val;
      $.get(urlKec, 
        function(response){
          $(kecamatan).html(response);
          $(kelurahan).html("<option value=''> Pilih Kelurahan </option>");
        });
   }));

    kecamatan.change(function(event) {
        var kecamatan_val = kecamatan.val();
        var urlKel = urlbase+"/kelurahan/"+kecamatan_val;
        $.get(urlKel,
        function(response){
            $(kelurahan).html(response);
        });
    });

    var kategorival = kategori.val();
    if(kategorival == 'Individu'){
        $('#label_nik_ahu').html('NIK');
    }else if(kategorival == 'Lembaga'){
        $('#label_nik_ahu').html('Nomor AHU');
    }
    kategori.change(function(event) {
        var kategorival = kategori.val();
        if(kategorival == 'Individu'){
            $('#label_nik_ahu').html('NIK');
        }else if(kategorival == 'Lembaga'){
            $('#label_nik_ahu').html('Nomor AHU');
        }
    });
});
</script>
												 {{Form::close()}}
												 @if($tr->from == 'daftar')
												{{Form::open(array('route'=>['cekUp_',$Proposal->id], 'method' => 'POST','files' => true, 'name' => 'sendnya', 'class' => 'pull-right'))}}
												    <input type="hidden" name="id" value="{{$Proposal->id}}">
													<input type="hidden" name="from" value="{{$tr->from}}">
													<input type="hidden" name="to" value="ditolak">
													<button class="btn btn-success pull-right" type="submit" > Ditolak</button>
												 {{Form::close()}}
												 @endif
											@else
                                            @if($Proposal->current_stat==2)
                                            <?php $danaproposal = $dana; $dananya = ''; $description = ''; $correct = ''; $correct1 = ''; $correct2 = ''; $correct3 = '';
                                                $deskor = ''; $desins = ''; $destapd = ''; $desbang = ''; 
                                                $roleid = isset(Auth::user()->roles->first()->id)?Auth::user()->roles->first()->id:'';
                                                $stjins = isset($Dmohon->setuju_inspektorat)?str_replace('.00', '', $Dmohon->setuju_inspektorat):'0';
                                                $stjtapd = isset($Dmohon->setuju_tapd)?str_replace('.00', '', $Dmohon->setuju_tapd):'0';
                                                $stjbanggar = isset($Dmohon->setuju_banggar)?str_replace('.00', '', $Dmohon->setuju_banggar):'0';
                                                $hasil = '';
                                                $uidopd = ''; $uidins = ''; $uidtapd = ''; $uidbang = '';
                                                if($roleid == 11){
                                                    if($stjins <> 0){
                                                        $hasil = 'lanjut';
                                                    }
                                                }elseif($roleid == 4 || $roleid == 6){
                                                    if($stjtapd <> 0){
                                                        $hasil = 'lanjut';
                                                    }
                                                }elseif($roleid == 12){
                                                    if($stjbanggar <> 0){
                                                        $hasil = 'lanjut';
                                                    }
                                                }
                                            ?>
                                            @if($roleid != 5 && $hasil == '')
												{{Form::open(array('route'=>['cekUp_',$Proposal->id], 'method' => 'POST','files' => true, 'name' => 'sendnya', 'class' => 'grid-form'))}}
												    <input type="hidden" name="id" value="{{$Proposal->id}}">
													<input type="hidden" name="from" value="{{$tr->from}}">
													<input type="hidden" name="to" value="{{$tr->to}}">
<section class="content">
 <div class="row" id="complex-form2">
                            @if($roleid==4 && $Proposal->typeproposal=='Barang' || $roleid==6 && $Proposal->typeproposal=='Barang' || $roleid==1 && $Proposal->typeproposal=='Barang' && $stjins!=0 && $stjtapd==0 && $stjbanggar==0)
                    <div class="col-lg-12">
                        <fieldset>
                            <div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Program</label>
                                    <select name="program" class="select2 program" id="program" required>
                                        <option> Pilih Program</option>
                                        @foreach($prog as $row)
                                          <option  value="{{$row->id_program}}" {!! ($Proposal->program==$row->id_program)?'selected':'' !!} >{{$row->id_program}} - {{$row->nama_program}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Kegiatan</label>
                                    <select name="kegiatan" class="select2 kegiatan" id="kegiatan" required>
                                        <option> Pilih Kegiatan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="hidden" data-row-span="4">
                                <div data-field-span="4">
                                    <label>Rekening Jenis</label>
                                    <select name="rek_jenis" class="select2 rekjenis" id="rek_jenis" required>
                                        <option> Pilih Jenis Rekening</option>
                                        @foreach($RekJenis as $row)
                                          <option  value="{{$row->kd_rek_jenis}}" {!! ($Proposal->type_id==$row->id)?'selected':'' !!} >{{$row->kd_rek_jenis}} - {{$row->nm_rek_jenis}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Rekening Obj</label>
                                    <select name="rek_obj" class="select2 rekobj" id="rek_obj" required>
                                        <option> Pilih Jenis Rekening</option>
                                    </select>
                                </div>
                            </div>

                            <div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Rekening Rincian</label>
                                    <select name="rekening" class="select2 rekrincian" id="rekening" required>
                                        <option> Pilih Rekening</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </div>
<script type="text/javascript">
    var urlbase = location.protocol+"<?php echo str_replace('https:','',str_replace('http:','',url('/'))); ?>"; 
$(document).ready(function() {
   var rek_jenis = "<?php echo old('rek_jenis'); ?>";
   var rek_obj = "<?php echo old('rek_obj'); ?>";
   var rek_rincian = "<?php echo old('rekening'); ?>";
   var rekjenis = $('.rekjenis');
   var rekobj = $('.rekobj');
   var rekrincian = $('.rekrincian');
   var type_id = "<?php if(old('type_id')){ $type_id = old('type_id'); }else{ $type_id = $Proposal->type_id; }echo $type_id; ?>";
   var jenisproposal = $('.jenisproposal');
   var type_proposal = "<?php if(old('typeproposal')){ $typeproposal = old('typeproposal'); }else{ $typeproposal = $Proposal->typeproposal; }echo $typeproposal; ?>";
   var typeproposal = $('.typeproposal');
   var rekening = "<?php echo $Proposal->rekening; ?>";
   if(rekening){
    var rek1 = rekening.slice(0, 3);
    var rek2 = rekening.slice(0, 5);
   }else{
    var rek1 = '';
    var rek2 = '';
   }
   if(type_id != ''){
      var jenisproposal_val = type_id;
      var typeproposal_val = type_proposal;
      if(type_proposal == 'Barang'){
        if(jenisproposal_val == 1){
            var jenisproposal_rek = '52226';
            var valrek = '522';
        }else if(jenisproposal_val == 2){
            var jenisproposal_rek = '52227';
            var valrek = '522';
        }else{
            var jenisproposal_rek = jenisproposal_val;
            var valrek = '';
        }
      }else{
        if(jenisproposal_val == 1){
            var jenisproposal_rek = '514';
            var valrek = '514';
        }else if(jenisproposal_val == 2){
            var jenisproposal_rek = '515';
            var valrek = '515';
        }else{
            var jenisproposal_rek = jenisproposal_val;
            var valrek = '';
        }
      }
      $(rekjenis).val(valrek);
      var urlRekjenis = urlbase+"/rekobj/"+jenisproposal_rek;
      $.get(urlRekjenis, 
        function(response){
          $(rekobj).html(response);
          $(rekrincian).html("<option value='' data=''> Pilih Rekening Obj Rincian </option>");
          if(rek2){
            $(rekobj).val(rek2);
            changerek(rek2);            
          }
        });
   }
    
    if(jenisproposal.change(function(event) {
      var jenisproposal_val = jenisproposal.val();
      var typeproposal_val = type_proposal;
      if(type_proposal == 'Barang'){
        if(jenisproposal_val == 1){
            var jenisproposal_rek = '52226';
            var valrek = '522';
        }else if(jenisproposal_val == 2){
            var jenisproposal_rek = '52227';
            var valrek = '522';
        }else{
            var jenisproposal_rek = jenisproposal_val;
            var valrek = '';
        }
      }else{
        if(jenisproposal_val == 1){
            var jenisproposal_rek = '514';
            var valrek = '514';
        }else if(jenisproposal_val == 2){
            var jenisproposal_rek = '515';
            var valrek = '515';
        }else{
            var jenisproposal_rek = jenisproposal_val;
            var valrek = '';
        }
      }
      $(rekjenis).val(valrek);
      var urlRekjenis = urlbase+"/rekobj/"+jenisproposal_rek;
      $.get(urlRekjenis, 
        function(response){
          $(rekobj).html(response);
          $(rekrincian).html("<option value='' data=''> Pilih Rekening Obj Rincian </option>");
        });
   }));

   rekobj.change(function(event) {
        var rekobj_val = rekobj.val();
        var urlRincian = urlbase+"/rekrincian/"+rekobj_val;
        $.get(urlRincian,
        function(response){
            $(rekrincian).html(response);
        });
    });

     function changerek(rek2){
        var rekobj_val = rek_obj?rek_obj:rek2;
        var urlRekrincian = urlbase+"/rekrincian/"+rekobj_val;
        $.get(urlRekrincian,
        function(response){
            $(rekrincian).html(response);
           if(rekening != ''){
                $(rekrincian).val(rekening);
           }
        });
   }
   var program = "<?php if(old('program')){ $program = old('program'); }else{ $program = isset($Proposal->program)?$Proposal->program:''; }echo $program; ?>";
   var programclass = $('.program');
   var kegiatan = "<?php if(old('kegiatan')){ $kegiatan = old('kegiatan'); }else{ $kegiatan = isset($Proposal->kegiatan)?$Proposal->kegiatan:''; }echo $kegiatan; ?>";
   var kegiatanclass = $('.kegiatan');
   if(program){
      $(programclass).val(program);
      var urlkegiatan = urlbase+"/kegiatan/"+program;
      $.get(urlkegiatan, 
        function(response){
          $(kegiatanclass).html(response);
          if(kegiatan){
            $(kegiatanclass).val(kegiatan);
          }
        });
   }
    
    if(programclass.change(function(event) {
      var program_val = programclass.val();
      $(programclass).val(program_val);
      var urlkegiatan = urlbase+"/kegiatan/"+program_val;
      $.get(urlkegiatan, 
        function(response){
          $(kegiatanclass).html(response);
          if(kegiatan){
            $(kegiatanclass).val(kegiatan);
          }
        });
   }));
});
</script>
                            @endif
                <div class="col-lg-12">
                        <fieldset>
                                            @if(count($danaproposal) <> 0)
                                                @foreach($danaproposal as $row)
                                                    @if($row->sequence == 1)
                                                    <?php $dananya .= str_replace('.00', '', $row->amount); 
                                                          $description .= $row->description; 
                                                          $correct .= str_replace('.00', '', $row->correction); 
                                                          $correct1 .= str_replace('.00', '', $row->correction_inspektorat); 
                                                          $correct2 .= str_replace('.00', '', $row->correction_tapd); 
                                                          $correct3 .= str_replace('.00', '', $row->correction_banggar); 
                                                          $deskor .= $row->deskor; 
                                                          $desins .= $row->desins; 
                                                          $destapd .= $row->destapd; 
                                                          $desbang .= $row->desbang; 

                                                          $uidopd .= $row->korid; 
                                                          $uidins .= $row->insid; 
                                                          $uidtapd .= $row->tapdid; 
                                                          $uidbang .= $row->bangid; 
                                                    ?>
                                                    @endif
                                                @endforeach
                                            @endif
                            <legend>Dana Yang diajukan <small><a class="dana btn btn-xs btn-primary hide" >Tambah Dana</a></small></legend>
                            <div data-row-span="1">
                                <div data-field-span="1">
                                    <label>Deskripsi</label>
                                     <textarea class="resize_vertical" name="deskripsi[]" required>{!! $description !!}</textarea>
                                </div>
                            </div> 
                            <div data-row-span="1">
                                <div data-field-span="1" style="width: 20%;">
                                    <label>Jumlah</label>
                                    <input type="number" name="jumlah[]" value="{!! $dananya !!}" readonly>
                                </div>
                                <div data-field-span="1" style="width: 20%;">
                                    <label>Disetujui (OPD)</label>
                                    <input type="number" name="correction[]" value="{!! $correct !!}" readonly>
                                </div>
                                @if($roleid==11)
                                <div data-field-span="1" style="width: 20%;">
                                    <label>Disetujui (Inspektorat)</label>
                                    <input type="number" name="correction_inspektorat[]" value="{!! $correct1 !!}" required>
                                </div>
                                <div data-field-span="1" class="hide" style="width: 20%;">
                                    <label>Disetujui (TAPD)</label>
                                    <input type="number" name="correction_tapd[]" value="{!! $correct2 !!}">
                                </div>
                                <div data-field-span="1" class="hide" style="width: 20%;">
                                    <label>Disetujui (Banggar)</label>
                                    <input type="number" name="correction_banggar[]" value="{!! $correct3 !!}">
                                </div>
                                @elseif($roleid==4 || $roleid==6)
                                <div data-field-span="1" style="width: 20%;">
                                    <label>Disetujui (Inspektorat)</label>
                                    <input type="number" name="correction_inspektorat[]" value="{!! $correct1 !!}" readonly>
                                </div>
                                <div data-field-span="1" style="width: 20%;">
                                    <label>Disetujui (TAPD)</label>
                                    <input type="number" name="correction_tapd[]" value="{!! $correct2 !!}" required>
                                </div>
                                <div data-field-span="1" class="hide" style="width: 20%;">
                                    <label>Disetujui (Banggar)</label>
                                    <input type="number" name="correction_banggar[]" value="{!! $correct3 !!}">
                                </div>
                                @elseif($roleid==12)
                                <div data-field-span="1" style="width: 20%;">
                                    <label>Disetujui (Inspektorat)</label>
                                    <input type="number" name="correction_inspektorat[]" value="{!! $correct1 !!}" readonly>
                                </div>
                                <div data-field-span="1" style="width: 20%;">
                                    <label>Disetujui (TAPD)</label>
                                    <input type="number" name="correction_tapd[]" value="{!! $correct2 !!}" readonly>
                                </div>
                                <div data-field-span="1" style="width: 20%;">
                                    <label>Disetujui (Banggar)</label>
                                    <input type="number" name="correction_banggar[]" value="{!! $correct3 !!}" required>
                                </div>
                                @else
                                    @if($roleid==1)
                                        @if($stjins==0 && $stjtapd==0 && $stjbanggar==0)
                                        <div data-field-span="1" style="width: 20%;">
                                            <label>Disetujui (Inspektorat)</label>
                                            <input type="number" name="correction_inspektorat[]" value="{!! $correct1 !!}" required>
                                        </div>
                                        <div data-field-span="1" class="hide" style="width: 20%;">
                                            <label>Disetujui (TAPD)</label>
                                            <input type="number" name="correction_tapd[]" value="{!! $correct2 !!}">
                                        </div>
                                        <div data-field-span="1" class="hide" style="width: 20%;">
                                            <label>Disetujui (Banggar)</label>
                                            <input type="number" name="correction_banggar[]" value="{!! $correct3 !!}">
                                        </div>
                                        @elseif($stjins!=0 && $stjtapd==0 && $stjbanggar==0)
                                        <div data-field-span="1" style="width: 20%;">
                                            <label>Disetujui (Inspektorat)</label>
                                            <input type="number" name="correction_inspektorat[]" value="{!! $correct1 !!}" readonly>
                                        </div>
                                        <div data-field-span="1" style="width: 20%;">
                                            <label>Disetujui (TAPD)</label>
                                            <input type="number" name="correction_tapd[]" value="{!! $correct2 !!}" required>
                                        </div>
                                        <div data-field-span="1" class="hide" style="width: 20%;">
                                            <label>Disetujui (Banggar)</label>
                                            <input type="number" name="correction_banggar[]" value="{!! $correct3 !!}">
                                        </div>
                                        @elseif($stjins!=0 && $stjtapd!=0 && $stjbanggar==0)
                                        <div data-field-span="1" style="width: 20%;">
                                            <label>Disetujui (Inspektorat)</label>
                                            <input type="number" name="correction_inspektorat[]" value="{!! $correct1 !!}" readonly>
                                        </div>
                                        <div data-field-span="1" style="width: 20%;">
                                            <label>Disetujui (TAPD)</label>
                                            <input type="number" name="correction_tapd[]" value="{!! $correct2 !!}" readonly>
                                        </div>
                                        <div data-field-span="1" style="width: 20%;">
                                            <label>Disetujui (Banggar)</label>
                                            <input type="number" name="correction_banggar[]" value="{!! $correct3 !!}" required>
                                        </div>
                                        @endif
                                    @endif
                                @endif
                            </div>
                            <div data-row-span="1">
                                <div data-field-span="1" style="width: 20%;">
                                    <label>Deskripsi (OPD)</label>
                                    <textarea class="resize_vertical" name="deskor[]" readonly>{!! $deskor !!}</textarea>
                                    <input type="hidden" name="korid[]" value="{{$uidopd}}">
                                </div>
                                @if($roleid==11)
                                <div data-field-span="1" style="width: 20%;">
                                    <label>Deskripsi (Inspektorat)</label>               
                                    <textarea class="resize_vertical" name="desins[]" required>{!! $desins !!}</textarea>
                                    <input type="hidden" name="insid[]" value="{{$uidins}}">
                                </div>
                                <div data-field-span="1" class="hide" style="width: 20%;">
                                    <label>Deskripsi (TAPD)</label>
                                    <textarea class="resize_vertical" name="destapd[]">{!! $destapd !!}</textarea>
                                    <input type="hidden" name="tapdid[]" value="{{$uidtapd}}">
                                </div>
                                <div data-field-span="1" class="hide" style="width: 20%;">
                                    <label>Deskripsi (Banggar)</label>
                                    <textarea class="resize_vertical" name="desbang[]">{!! $desbang !!}</textarea>
                                    <input type="hidden" name="bangid[]" value="{{$uidbang}}">
                                </div>
                                @elseif($roleid==4 || $roleid==6)
                                <div data-field-span="1" style="width: 20%;">
                                    <label>Deskripsi (Inspektorat)</label>
                                    <textarea class="resize_vertical" name="desins[]" readonly>{!! $desins !!}</textarea>
                                    <input type="hidden" name="insid[]" value="{{$uidins}}">
                                </div>
                                <div data-field-span="1" style="width: 20%;">
                                    <label>Deskripsi (TAPD)</label>
                                    <textarea class="resize_vertical" name="destapd[]" required>{!! $destapd !!}</textarea>
                                    <input type="hidden" name="tapdid[]" value="{{$uidtapd}}">
                                </div>
                                <div data-field-span="1" class="hide" style="width: 20%;">
                                    <label>Deskripsi (Banggar)</label>
                                    <textarea class="resize_vertical" name="desbang[]">{!! $desbang !!}</textarea>
                                    <input type="hidden" name="bangid[]" value="{{$uidbang}}">
                                </div>
                                @elseif($roleid==12)
                                <div data-field-span="1" style="width: 20%;">
                                    <label>Deskripsi (Inspektorat)</label>
                                    <textarea class="resize_vertical" name="desins[]" readonly>{!! $desins !!}</textarea>
                                    <input type="hidden" name="insid[]" value="{{$uidins}}">
                                </div>
                                <div data-field-span="1" style="width: 20%;">
                                    <label>Deskripsi (TAPD)</label>
                                    <textarea class="resize_vertical" name="destapd[]" readonly>{!! $destapd !!}</textarea>
                                    <input type="hidden" name="tapdid[]" value="{{$uidtapd}}">
                                </div>
                                <div data-field-span="1" style="width: 20%;">
                                    <label>Deskripsi (Banggar)</label>
                                    <textarea class="resize_vertical" name="desbang[]" required>{!! $desbang !!}</textarea>
                                    <input type="hidden" name="bangid[]" value="{{$uidbang}}">
                                </div>
                                @else
                                    @if($roleid==1)
                                        @if($stjins==0 && $stjtapd==0 && $stjbanggar==0)
                                        <div data-field-span="1" style="width: 20%;">
                                            <label>Deskripsi (Inspektorat)</label>
                                            <textarea class="resize_vertical" name="desins[]" required>{!! $desins !!}</textarea>
                                            <input type="hidden" name="insid[]" value="{{$uidins}}">
                                        </div>
                                        <div data-field-span="1" class="hide" style="width: 20%;">
                                            <label>Deskripsi (TAPD)</label>
                                            <textarea class="resize_vertical" name="destapd[]">{!! $destapd !!}</textarea>
                                            <input type="hidden" name="tapdid[]" value="{{$uidtapd}}">
                                        </div>
                                        <div data-field-span="1" class="hide" style="width: 20%;">
                                            <label>Deskripsi (Banggar)</label>
                                            <textarea class="resize_vertical" name="desbang[]">{!! $desbang !!}</textarea>
                                            <input type="hidden" name="bangid[]" value="{{$uidbang}}">
                                        </div>
                                        @elseif($stjins!=0 && $stjtapd==0 && $stjbanggar==0)
                                        <div data-field-span="1" style="width: 20%;">
                                            <label>Deskripsi (Inspektorat)</label>
                                            <textarea class="resize_vertical" name="desins[]" readonly>{!! $desins !!}</textarea>
                                            <input type="hidden" name="insid[]" value="{{$uidins}}">
                                        </div>
                                        <div data-field-span="1" style="width: 20%;">
                                            <label>Deskripsi (TAPD)</label>
                                            <textarea class="resize_vertical" name="destapd[]" required>{!! $destapd !!}</textarea>
                                            <input type="hidden" name="tapdid[]" value="{{$uidtapd}}">
                                        </div>
                                        <div data-field-span="1" class="hide" style="width: 20%;">
                                            <label>Deskripsi (Banggar)</label>
                                            <textarea class="resize_vertical" name="desbang[]">{!! $desbang !!}</textarea>
                                            <input type="hidden" name="bangid[]" value="{{$uidbang}}">
                                        </div>
                                        @elseif($stjins!=0 && $stjtapd!=0 && $stjbanggar==0)
                                        <div data-field-span="1" style="width: 20%;">
                                            <label>Deskripsi (Inspektorat)</label>
                                            <textarea class="resize_vertical" name="desins[]" readonly>{!! $desins !!}</textarea>
                                            <input type="hidden" name="insid[]" value="{{$uidins}}">
                                        </div>
                                        <div data-field-span="1" style="width: 20%;">
                                            <label>Deskripsi (TAPD)</label>
                                            <textarea class="resize_vertical" name="destapd[]" readonly>{!! $destapd !!}</textarea>
                                            <input type="hidden" name="tapdid[]" value="{{$uidtapd}}">
                                        </div>
                                        <div data-field-span="1" style="width: 20%;">
                                            <label>Deskripsi (Banggar)</label>
                                            <textarea class="resize_vertical" name="desbang[]" required>{!! $desbang !!}</textarea>
                                            <input type="hidden" name="bangid[]" value="{{$uidbang}}">
                                        </div>
                                        @endif
                                    @endif
                                @endif
                            </div>
                            <div id="dtarget">
                                            @if(count($danaproposal) <> 0)
                                                @foreach($danaproposal as $row)
                                                    @if($row->sequence > 1)
                                                    <?php
                                                        echo '<div data-row-span="1"><div data-field-span="1"> <label>Deskripsi</label> <textarea class="resize_vertical" name="deskripsi[]">'.$row->description.'</textarea></div></div> <div data-row-span="1"><div data-field-span="1" style="width:20%;"><label>Jumlah</label><input type="number" name="jumlah[]" value="'.str_replace('.00', '', $row->amount).'" readonly></div><div data-field-span="1" style="width:20%;"><label>Disetujui (OPD)</label><input type="number" name="correction[]" value="'.str_replace('.00', '', $row->correction).'" readonly></div>';
                                                        if($roleid==11){
                                                        echo '<div data-field-span="1" style="width:20%;"><label>Disetujui (Inspektorat)</label><input type="number" name="correction_inspektorat[]" value="'.str_replace('.00', '', $row->correction_inspektorat).'" required></div><div data-field-span="1" class="hide" style="width:20%;"><label>Disetujui (TAPD)</label><input type="number" name="correction_tapd[]" value="'.str_replace('.00', '', $row->correction_tapd).'"></div><div data-field-span="1" class="hide" style="width:20%;"><label>Disetujui (Banggar)</label><input type="number" name="correction_banggar[]" value="'.str_replace('.00', '', $row->correction_banggar).'"></div>';
                                                        }elseif($roleid==4 || $roleid==6){
                                                        echo '<div data-field-span="1" style="width:20%;"><label>Disetujui (Inspektorat)</label><input type="number" name="correction_inspektorat[]" value="'.str_replace('.00', '', $row->correction_inspektorat).'" readonly></div><div data-field-span="1" style="width:20%;"><label>Disetujui (TAPD)</label><input type="number" name="correction_tapd[]" value="'.str_replace('.00', '', $row->correction_tapd).'" required></div><div data-field-span="1" class="hide" style="width:20%;"><label>Disetujui (Banggar)</label><input type="number" name="correction_banggar[]" value="'.str_replace('.00', '', $row->correction_banggar).'"></div>';
                                                        }elseif($roleid==12){
                                                        echo '<div data-field-span="1" style="width:20%;"><label>Disetujui (Inspektorat)</label><input type="number" name="correction_inspektorat[]" value="'.str_replace('.00', '', $row->correction_inspektorat).'" readonly></div><div data-field-span="1" style="width:20%;"><label>Disetujui (TAPD)</label><input type="number" name="correction_tapd[]" value="'.str_replace('.00', '', $row->correction_tapd).'" readonly></div><div data-field-span="1" style="width:20%;"><label>Disetujui (Banggar)</label><input type="number" name="correction_banggar[]" value="'.str_replace('.00', '', $row->correction_banggar).'" required></div>';
                                                        }else{
                                                            if($roleid==1){
                                                                if($stjins==0 && $stjtapd==0 && $stjbanggar==0){
                                                                    echo '<div data-field-span="1" style="width:20%;"><label>Disetujui (Inspektorat)</label><input type="number" name="correction_inspektorat[]" value="'.str_replace('.00', '', $row->correction_inspektorat).'" required></div><div data-field-span="1" class="hide" style="width:20%;"><label>Disetujui (TAPD)</label><input type="number" name="correction_tapd[]" value="'.str_replace('.00', '', $row->correction_tapd).'"></div><div data-field-span="1" class="hide" style="width:20%;"><label>Disetujui (Banggar)</label><input type="number" name="correction_banggar[]" value="'.str_replace('.00', '', $row->correction_banggar).'"></div>';
                                                                }elseif($stjins!=0 && $stjtapd==0 && $stjbanggar==0){
                                                                    echo '<div data-field-span="1" style="width:20%;"><label>Disetujui (Inspektorat)</label><input type="number" name="correction_inspektorat[]" value="'.str_replace('.00', '', $row->correction_inspektorat).'" readonly></div><div data-field-span="1" style="width:20%;"><label>Disetujui (TAPD)</label><input type="number" name="correction_tapd[]" value="'.str_replace('.00', '', $row->correction_tapd).'" required></div><div data-field-span="1" class="hide" style="width:20%;"><label>Disetujui (Banggar)</label><input type="number" name="correction_banggar[]" value="'.str_replace('.00', '', $row->correction_banggar).'"></div>';
                                                                }elseif($stjins!=0 && $stjtapd!=0 && $stjbanggar==0){
                                                                    echo '<div data-field-span="1" style="width:20%;"><label>Disetujui (Inspektorat)</label><input type="number" name="correction_inspektorat[]" value="'.str_replace('.00', '', $row->correction_inspektorat).'" readonly></div><div data-field-span="1" style="width:20%;"><label>Disetujui (TAPD)</label><input type="number" name="correction_tapd[]" value="'.str_replace('.00', '', $row->correction_tapd).'" readonly></div><div data-field-span="1" style="width:20%;"><label>Disetujui (Banggar)</label><input type="number" name="correction_banggar[]" value="'.str_replace('.00', '', $row->correction_banggar).'" required></div>';
                                                                }
                                                            }
                                                        }
                                                        echo '</div>';

                                                        echo '<div data-row-span="1"><div data-field-span="1" style="width:20%;"><label>Deskripsi (OPD)</label><textarea class="resize_vertical" name="deskor[]" readonly>'.$row->deskor.'</textarea><input type="hidden" name="korid[]" value="'.$row->korid.'"></div>';
                                                        if($roleid==11){
                                                        echo '<div data-field-span="1" style="width:20%;"><label>Deskripsi (Inspektorat)</label><textarea class="resize_vertical" name="desins[]" required>'.$row->desins.'</textarea><input type="hidden" name="insid[]" value="'.$row->insid.'"></div><div data-field-span="1" class="hide" style="width:20%;"><label>Deskripsi (TAPD)</label><textarea class="resize_vertical" name="destapd[]">'.$row->destapd.'</textarea><input type="hidden" name="tapdid[]" value="'.$row->tapdid.'"></div><div data-field-span="1" class="hide" style="width:20%;"><label>Deskripsi (Banggar)</label><textarea class="resize_vertical" name="desbang[]">'.$row->desbang.'</textarea><input type="hidden" name="bangid[]" value="'.$row->bangid.'"></div>';
                                                        }elseif($roleid==4 || $roleid==6){
                                                        echo '<div data-field-span="1" style="width:20%;"><label>Deskripsi (Inspektorat)</label><textarea class="resize_vertical" name="desins[]" readonly>'.$row->desins.'</textarea><input type="hidden" name="insid[]" value="'.$row->insid.'"></div><div data-field-span="1" style="width:20%;"><label>Deskripsi (TAPD)</label><textarea class="resize_vertical" name="destapd[]" required>'.$row->destapd.'</textarea><input type="hidden" name="tapdid[]" value="'.$row->tapdid.'"></div><div data-field-span="1" class="hide" style="width:20%;"><label>Deskripsi (Banggar)</label><textarea class="resize_vertical" name="desbang[]">'.$row->desbang.'</textarea><input type="hidden" name="bangid[]" value="'.$row->bangid.'"></div>';
                                                        }elseif($roleid==12){
                                                        echo '<div data-field-span="1" style="width:20%;"><label>Deskripsi (Inspektorat)</label><textarea class="resize_vertical" name="desins[]" readonly>'.$row->desins.'</textarea><input type="hidden" name="insid[]" value="'.$row->insid.'"></div><div data-field-span="1" style="width:20%;"><label>Deskripsi (TAPD)</label><textarea class="resize_vertical" name="destapd[]" readonly>'.$row->destapd.'</textarea><input type="hidden" name="tapdid[]" value="'.$row->tapdid.'"></div><div data-field-span="1" style="width:20%;"><label>Deskripsi (Banggar)</label><textarea class="resize_vertical" name="desbang[]" required>'.$row->desbang.'</textarea><input type="hidden" name="bangid[]" value="'.$row->bangid.'"></div>';
                                                        }else{
                                                            if($roleid==1){
                                                                if($stjins==0 && $stjtapd==0 && $stjbanggar==0){
                                                                    echo '<div data-field-span="1" style="width:20%;"><label>Deskripsi (Inspektorat)</label><textarea class="resize_vertical" name="desins[]" required>'.$row->desins.'</textarea><input type="hidden" name="insid[]" value="'.$row->insid.'"></div><div data-field-span="1" class="hide" style="width:20%;"><label>Deskripsi (TAPD)</label><textarea class="resize_vertical" name="destapd[]">'.$row->destapd.'</textarea><input type="hidden" name="tapdid[]" value="'.$row->tapdid.'"></div><div data-field-span="1" class="hide" style="width:20%;"><label>Deskripsi (Banggar)</label><textarea class="resize_vertical" name="desbang[]">'.$row->desbang.'</textarea><input type="hidden" name="bangid[]" value="'.$row->bangid.'"></div>';
                                                                }elseif($stjins!=0 && $stjtapd==0 && $stjbanggar==0){
                                                                    echo '<div data-field-span="1" style="width:20%;"><label>Deskripsi (Inspektorat)</label><textarea class="resize_vertical" name="desins[]" readonly>'.$row->desins.'</textarea><input type="hidden" name="insid[]" value="'.$row->insid.'"></div><div data-field-span="1" style="width:20%;"><label>Deskripsi (TAPD)</label><textarea class="resize_vertical" name="destapd[]" required>'.$row->destapd.'</textarea><input type="hidden" name="tapdid[]" value="'.$row->tapdid.'"></div><div data-field-span="1" class="hide" style="width:20%;"><label>Deskripsi (Banggar)</label><textarea class="resize_vertical" name="desbang[]">'.$row->desbang.'</textarea><input type="hidden" name="bangid[]" value="'.$row->bangid.'"></div>';
                                                                }elseif($stjins!=0 && $stjtapd!=0 && $stjbanggar==0){
                                                                    echo '<div data-field-span="1" style="width:20%;"><label>Deskripsi (Inspektorat)</label><textarea class="resize_vertical" name="desins[]" readonly>'.$row->desins.'</textarea><input type="hidden" name="insid[]" value="'.$row->insid.'"></div><div data-field-span="1" style="width:20%;"><label>Deskripsi (TAPD)</label><textarea class="resize_vertical" name="destapd[]" readonly>'.$row->destapd.'</textarea><input type="hidden" name="tapdid[]" value="'.$row->tapdid.'"></div><div data-field-span="1" style="width:20%;"><label>Deskripsi (Banggar)</label><textarea class="resize_vertical" name="desbang[]" required>'.$row->desbang.'</textarea><input type="hidden" name="bangid[]" value="'.$row->bangid.'"></div>';
                                                                }
                                                            }
                                                        }
                                                        echo '</div>';
                                                    ?>
                                                    @endif
                                                @endforeach
                                            @endif
                            </div>
                            </br>
                        </fieldset>
                        <br>
        </div>
    </div>
</section>
                                                @if($roleid==12)
                                                    <input type="hidden" name="verif" value="yes">
													@foreach($guard as $grd) 
														@if($grd->transition_id == $tr->id)
															@if(Auth::user()->can($grd->Permission->name) == $grd->Permission->name)
																<button class="btn btn-success pull-left" type="submit" > {{$tr->label}}</button>
															@else
																<button class="btn btn-success pull-left" type="submit"> {{$tr->label}}</button>
															@endif
														@endif
													@endforeach
                                                @elseif($roleid==11 || $roleid==4 || $roleid==6)
                                                    <input type="hidden" name="verif" value="no">
                                                    <button class="btn btn-success pull-left" type="submit">Setuju</button>
                                                @elseif($roleid==1)
                                                    @if($stjtapd <> 0)
                                                        <input type="hidden" name="verif" value="yes">
                                                        @foreach($guard as $grd) 
                                                            @if($grd->transition_id == $tr->id)
                                                                @if(Auth::user()->can($grd->Permission->name) == $grd->Permission->name)
                                                                    <button class="btn btn-success pull-left" type="submit" > {{$tr->label}}</button>
                                                                @else
                                                                    <button class="btn btn-success pull-left" type="submit"> {{$tr->label}}</button>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <input type="hidden" name="verif" value="no">
                                                        <button class="btn btn-success pull-left" type="submit">Setuju</button>
                                                    @endif
                                                @endif
												 {{Form::close()}}
												 @if($tr->from == 'pengecekan_proposal')
												{{Form::open(array('route'=>['cekUp_',$Proposal->id], 'method' => 'POST','files' => true, 'name' => 'sendnya', 'class' => 'pull-right'))}}
                                                    <input type="hidden" name="verif" value="ditolak">
												    <input type="hidden" name="id" value="{{$Proposal->id}}">
													<input type="hidden" name="from" value="{{$tr->from}}">
													<input type="hidden" name="to" value="ditolak">
													<button class="btn btn-success pull-right" type="submit" > Ditolak</button>
												 {{Form::close()}}
												 @endif
                                            @endif
											@endif
                                            @endif
									@endif
								@endforeach
												 <!-- @if($Proposal->current_stat == 4)
												{{Form::open(array('route'=>['cekUp_',$Proposal->id], 'method' => 'POST','files' => true, 'name' => 'sendnya', 'class' => 'pull-left'))}}
												    <input type="hidden" name="id" value="{{$Proposal->id}}">
													<input type="hidden" name="from" value="ditolak">
													<input type="hidden" name="to" value="daftar">
													<button class="btn btn-success pull-left" type="submit" > Kembalikan Ke Daftar</button>
												 {{Form::close()}}
												 @endif -->
								</div>
									<br>
									
								<h4>Rencana Penggunaan Dana</h4>
								<div class="table-responsive">
									 <table class="table table-bordered table-hover">
										<tr>
											<th>Dana</th>
											<th>Proposal</th>
											<th>Disetujui (OPD)</th>
                                            <th>Disetujui (Inspektorat)</th>
                                            <th>Disetujui (TAPD)</th>
                                            <th>Disetujui (Banggar)</th>
										</tr>
										<tbody>
										 @foreach($dana as $dn)
											<tr>
												<td>{!! $dn->description !!}</td>
												<td>Rp. {!! number_format($dn->amount,0,",",".")!!},-</td>
												<td>Rp. {!!number_format($dn->correction,0,",",".")!!},-</td>
                                                <td>Rp. {!!number_format($dn->correction_inspektorat,0,",",".")!!},-</td>
                                                <td>Rp. {!!number_format($dn->correction_tapd,0,",",".")!!},-</td>
                                                <td>Rp. {!!number_format($dn->correction_banggar,0,",",".")!!},-</td>
											</tr>
										@endforeach
										</tbody>
										<tfoot>
										<tr>
											<th>Total</th>
											<th>Rp. {!! (isset($Dmohon->mohon)?number_format($Dmohon->mohon,0,",","."):'0') !!},-</th>
											<th>Rp. {!! (isset($Dmohon->setuju)?number_format($Dmohon->setuju,0,",","."):'0') !!},-</th>
                                            <th>Rp. {!! (isset($Dmohon->setuju_inspektorat)?number_format($Dmohon->setuju_inspektorat,0,",","."):'0') !!},-</th>
                                            <th>Rp. {!! (isset($Dmohon->setuju_tapd)?number_format($Dmohon->setuju_tapd,0,",","."):'0') !!},-</th>
                                            <th>Rp. {!! (isset($Dmohon->setuju_banggar)?number_format($Dmohon->setuju_banggar,0,",","."):'0') !!},-</th>
										</tr>
										</tfoot>
									</table>			
								</div>
							</div>
							<div class="form-actions">
								  <div class="row">
									 <div class="col-sm-offset-3 col-sm-9">
										  <a href="{{ route('proposals') }}" class="btn btn-effect-ripple btn-default reset_btn">Kembali</a>
									 </div>
								  </div>
							</div>
						</div>
					</div>
				</div>
			</div>
			

			
<div class="background-overlay"></div>
</section>
<script type="text/javascript">
(function($) {
    $.fn.checkFileType = function(options) {
        var defaults = {
            allowedExtensions: [],
            success: function() {},
            error: function() {}
        };
        options = $.extend(defaults, options);

        return this.each(function() {

            $(this).on('change', function() {
                var value = $(this).val(),
                    file = value.toLowerCase(),
                    extension = file.substring(file.lastIndexOf('.') + 1);

                if ($.inArray(extension, options.allowedExtensions) == -1) {
                    options.error();
                    $(this).focus();
                } else {
                    options.success();

                }

            });

        });
    };

})(jQuery);

$(function() {
    $('.file_2').checkFileType({
        allowedExtensions: ['pdf'],
        success: function() {
            // alert('Success');
        },
        error: function() {
            alert('Type File tidak sesuai');
            $('.file_2').val('');
        }
    });
	


});

$(function() {
    $('.file_1').checkFileType({
        allowedExtensions: ['jpg', 'jpeg','png','gif'],
        success: function() {
            // alert('Success');
        },
        error: function() {
            alert('Type File tidak sesuai');
            $('.file_1').val('');
        }
    });

});
</script>

@endsection