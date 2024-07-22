@extends('backEnd.layout')

@section('content')
<section class="content-header">
   <h1>Form Hibah Bansos </h1>
   <ol class="breadcrumb">
       <li><a href="#"><i class="fa fa-fw ti-home"></i> Dashboard</a></li>
       <li class="active">Form Hibah Bansos</li>
    </ol>
</section>
<section class="content">
 <div class="row" id="complex-form2">
                <div class="col-lg-10">
				{{Form::open(array('route' => ['proposalsUpdate',$Proposal->id], 'method' => 'PUT','files' => true, 'class' => 'grid-form'))}}
                        <div class="text-center">
                            <h3>Edit Hibah Bansos</h3>
                        </div>
                        <fieldset>
                            <legend>Silahkan Isi Data</legend>
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
                                        <option value="Barang" {!! ($Proposal->typeproposal=='Barang')?'selected':'' !!} >Barang?Jasa</option>
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
							@if(Auth::user()->hasRole('opd') || Auth::user()->hasRole('superadministrator') || Auth::user()->hasRole('administrator')) 
                           
							</br>
							 <fieldset>
								<legend>Kelengkapan Dokumen</legend>
								<div data-row-span="1">
									<div data-field-span="1">
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
							</fieldset>
							</br>
							<fieldset>
								<legend>Persyaratan Administrasi</legend>
								<div data-row-span="1">
									<div data-field-span="1">
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
							</fieldset>
							@endif
                          
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
                                            <?php $danaproposal = $Proposal->dana; $dana = ''; $correction = ''; $description = ''; $deskor = ''; ?>
                                            @if(count($danaproposal) <> 0)
                                                @foreach($danaproposal as $row)
                                                    @if($row->sequence == 1)
                                                    <?php $dana .= str_replace('.00', '', $row->amount); $correction .= str_replace('.00', '', $row->correction); $description .= $row->description; $deskor .= $row->deskor; ?>
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
                                    <input type="number" name="jumlah[]" value="{!! $dana !!}" required>
                                </div>
                                <div data-field-span="1" style="width: auto;">
                                    <label>Koreksi/Disetujui</label>
                                    <input type="number" name="correction[]" value="{!! $correction !!}" required>
                                </div>
                            </div>
                            <div data-row-span="1">
                                <div data-field-span="1">
                                    <label>Deskripsi</label>
                                     <textarea class="resize_vertical" name="deskor[]" required>{!! $deskor !!}</textarea>
                                </div>
                            </div> 
							<div id="dtarget">
                                            @if(count($danaproposal) <> 0)
                                                @foreach($danaproposal as $row)
                                                    @if($row->sequence > 1)
                                                    <?php
                                                        echo '<div data-row-span="1"><div data-field-span="1"> <label>Deskripsi</label> <textarea class="resize_vertical" name="deskripsi[]">'.$row->description.'</textarea></div></div> <div data-row-span="1"><div data-field-span="1" style="width: auto;"><label>Jumlah</label><input type="number" name="jumlah[]" value="'.str_replace('.00', '', $row->amount).'"></div><div data-field-span="1" style="width: auto;"><label>Koreksi/Disetujui</label><input type="number" name="correction[]" value="'.str_replace('.00', '', $row->correction).'"></div></div> <div data-row-span="1"><div data-field-span="1"> <label>Deskripsi Koreksi</label> <textarea class="resize_vertical" name="deskor[]">'.$row->deskor.'</textarea></div></div>';
                                                    ?>
                                                    @endif
                                                @endforeach
                                            @endif
                            </div>
							</br>
						 </fieldset>
                        <br>
						<div class="row">
							<div class="form-group form-actions">
								<div class="col-md-8 col-md-offset-4">
									<button type="submit" class="btn btn-effect-ripple btn-primary">Simpan</button>
									<a href="{{ route('proposals') }}" class="btn btn-effect-ripple btn-default reset_btn">Batal</a>
								</div>
							 </div>
					    </div>
                   {{Form::close()}}
                </div>
            </div>
</section>
<script type="text/javascript">
    var urlbase = location.protocol+"<?php echo str_replace('https:','',str_replace('http:','',url('/'))); ?>";  
 $(".dana").click(function(){
      var content = $('<div data-row-span="1"><div data-field-span="1"> <label>Deskripsi</label> <textarea class="resize_vertical" name="deskripsi[]"></textarea></div></div> <div data-row-span="1"><div data-field-span="1" style="width: auto;"><label>Jumlah</label><input type="number" name="jumlah[]"></div><div data-field-span="1" style="width: auto;"><label>Koreksi/Disetujui</label><input type="number" name="correction[]"></div></div> <div data-row-span="1"><div data-field-span="1"> <label>Deskripsi Koreksi</label> <textarea class="resize_vertical" name="deskor[]"></textarea></div></div>');
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
@endsection
