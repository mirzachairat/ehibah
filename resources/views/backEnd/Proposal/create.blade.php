@extends('Layouts.admin')

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
                        <div class="text-center">
                            <h3>Mendaftar Hibah Bansos TA {{$tahun}} {{($perubahan==1)?"Perubahan":""}}</h3>
                        </div>
                        <fieldset>
                            <legend>Silahkan Isi Data</legend>
							 <div data-row-span="4">
                                <div data-field-span="2">
                                    <label>Tahun Anggaran</label>
                                   <select name="tahun" class="select2" required>
									<option value="">Pilih Tahun Anggaran</option>
                                    <option value="{{$tahun}}" selected>{{$tahun}}</option>
									<?php
										$date = date('Y')+10;
                                        $dateselect = date('Y');
										for($i=2000;$i<=$date;$i++){
											$sl = '';
											if($i == $dateselect){
												$sl .= 'selected';
											}
											//echo '<option value="'.$i.'" '.$sl.'>'.$i.'</option>';
										}
									?>
								</select>
                                    <input type="hidden" name="perubahan" value="{{$perubahan}}" class="form-control hidden"/>
                                </div>
                            </div>
                            <div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Jenis proposal</label>
                                     <select class="select2 jenisproposal" name="type_id" required>
                                        <option>Silahkan Pilih</option>
                                        @foreach($Type as $row)
										  <option value="{{$row->id}}">{{$row->name}}</option>
										@endforeach
									</select>
                                </div>
                            </div>
                            
                            @if(Auth::user()->role == 'superadministrator')
                            <div data-row-span="4" class="typeproposal" style="display: none;">
                                <div data-field-span="4">
                                    <label>Type proposal</label>
                                     <select class="select2 typeproposal" id="typeproposal" name="typeproposal" style="display: none;">
                                        <option value="Uang">Uang</option>
                                        <option value="Barang">Barang/Jasa</option>
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Kategori</label>
                                     <select class="select2" name="kategori" id="kategori" required>
                                        <option>Silahkan Pilih</option>
                                        <option value="Individu" {!! (old('kategori')=='Individu')?'selected':null !!} >Individu / Perorang</option>
                                        <option value="Lembaga" {!! (old('kategori')=='Lembaga')?'selected':null !!} >Lembaga / Organisasi</option>
									</select>
                                </div>
                            </div>
                            <div data-row-span="1">
                                <div data-field-span="1">
                                    <label id="label_nik_ahu" for="nik_ahu">NIK</label>
									 <input type="text" name="nik_ahu" id="nik_ahu" required autofocus>
                                </div>
                            </div>
                            <div data-row-span="1">
                                <div data-field-span="1">
                                    <label>Penanggungjawab</label>
									 <input type="text" name="user" required autofocus>
                                </div>
                            </div>
                           
                        </fieldset>
                        <fieldset>
                            <div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Nama (individu atau organisasi)</label>
                                     <input type="text" name="name" required>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
							<div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Alamat</label>
									<textarea name="address" class="resize_vertical" required></textarea>
                                </div>
                            </div>

                        </fieldset>
                         <fieldset>
                         <div data-row-span="4">
                         <div data-field-span="4">
                                            <label for="kota"> Kota / Kab</label>
                                            <select name="kota" class="select2 kota" id="kota" required >
                                                <option value="" data=""> Pilih Kota/Kabupaten </option>
                                                                
                                                @foreach($kota as $row)
                                                <option value="{{ $row->id_kota }}" data="{{ $row->nama_kota }}" {!! (old('kota')==$row->id_kota)?'selected':'' !!} >{{ $row->nama_kota }}</option>
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
                                            <select name="kec" class="select2 kecamatan"  id="kec" required >
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
                                            <select name="kel" class="select2 kelurahan" id="kel" required >
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
                                    <input type="text" name="judul" required>
                                </div>
                            </div>
							<div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Latar Belakang</label>
                                    <textarea name="latar" class="resize_vertical" required></textarea>
                                </div>
                            </div>
							<div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Maksud dan Tujuan</label>
                                    <textarea name="maksud" class="resize_vertical" required></textarea>
                                </div>
                            </div>
							<div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Opd</label>
                                    <select name="skpd" class="select2 skpd" id="skpd"  required>
                                        <option>Silhkan Pilih</option>
                                        @foreach($skpd as $row)
										  <option  value="{{$row->id}}"  {!! (Auth::user()->skpd_id && Auth::user()->skpd_id==$row->id) ? "selected='selected'":"" !!}>{{$row->kd_skpd}} - {{$row->name}}</option>
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
										  <option  value="{{$row->kd_rek_jenis}}">{{$row->kd_rek_jenis}} - {{$row->nm_rek_jenis}}</option>
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
                            {{-- codingan lama --}}
							{{-- @if(Auth::user()->hasRole('opd') || Auth::user()->hasRole('superadministrator') || Auth::user()->hasRole('administrator'))  --}}
							@if(Auth::user()->role_id__ == 5 || Auth::user()->role_id__ == 1|| Auth::user()->role_id__ == 2) 
						
							</br>
							 <fieldset>
								<legend>Kelengkapan Dokumen</legend>
								<div data-row-span="1">
									<div data-field-span="1">
									 @foreach($Kelengkapan as $c)
										<input id="kelengkapan{{$c->id}}" name="kelengkapan[]" type="checkbox" value="{{$c->id}}">&nbsp;<label for="kelengkapan{{$c->id}}">{{$c->name}}</label></br>
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
										<input id="persyaratan{{$c->id}}" name="persyaratan[]" type="checkbox" value="{{$c->id}}">&nbsp;<label for="persyaratan{{$c->id}}">{{$c->name}}</label></br>
									@endforeach
									</div>
								</div>
							</fieldset>
							@endif
							</br>
							<div data-row-span="4">
                                <div data-field-span="4">
                                    <label>Keterangan</label>
                                    <textarea  name="keterangan" class="resize_vertical" ></textarea>
                                </div>
                            </div>
                           <br>
                        </fieldset>
                        <br>
                        <fieldset>
                            <legend>Dana Yang diajukan <small><a class="dana btn btn-xs btn-primary" >Tambah Dana</a></small></legend>
                            <div data-row-span="1">
                                <div data-field-span="1">
                                    <label>Deskripsi</label>
                                     <textarea class="resize_vertical" name="deskripsi[]" required></textarea>
                                </div>
                            </div> 
							<div data-row-span="1">
                                <div data-field-span="1" style="width: auto;">
                                    <label>Jumlah</label>
                                    <input type="number" name="jumlah[]" required>
                                </div>
                                <div data-field-span="1" style="width: auto;">
                                    <label>Koreksi/Disetujui</label>
                                    <input type="number" name="correction[]" required>
                                </div>
                            </div>
                            <div data-row-span="1">
                                <div data-field-span="1">
                                    <label>Deskripsi Koreksi</label>
                                     <textarea class="resize_vertical" name="deskor[]" required></textarea>
                                </div>
                            </div> 
							<div id="dtarget">
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
                </div>
            </div>
</section>
<script type="text/javascript">
 $(".dana").click(function(){
      var content = $('<div data-row-span="1"><div data-field-span="1"> <label>Deskripsi</label> <textarea class="resize_vertical" name="deskripsi[]"></textarea></div></div> <div data-row-span="1"><div data-field-span="1"  style="width: auto;"><label>Jumlah</label><input type="number" name="jumlah[]"></div><div data-field-span="1" style="width:auto;"><label>Koreksi/Disetujui</label><input type="number" name="correction[]"></div></div> <div data-row-span="1"><div data-field-span="1"> <label>Deskripsi Koreksi</label> <textarea class="resize_vertical" name="deskor[]"></textarea></div></div>');
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
</script>

<script type="text/javascript">  
    var urlbase = location.protocol+"<?php echo str_replace('https:','',str_replace('http:','',url('/'))); ?>";  
    //var urlbase ="<?php echo url('/'); ?>";
  
$(document).ready(function() {
    var kota = "<?php echo old('kota'); ?>";
   var kec = "<?php echo old('kec'); ?>";
   var kel = "<?php echo old('kel'); ?>";
   var skpd_old = "<?php echo old('skpd'); ?>";
   var sub_skpd_old = "<?php echo old('sub_skpd'); ?>";
   var kabupaten = $('.kota');
   var kecamatan = $('.kecamatan');
   var kelurahan = $('.kelurahan');
   var skpd = $('.skpd');
   var sub_skpd = $('.sub_skpd');

   var rek_jenis = "<?php echo old('rek_jenis'); ?>";
   var rek_obj = "<?php echo old('rek_obj'); ?>";
   var rek_rincian = "<?php echo old('rekening'); ?>";
   var jenisproposal = $('.jenisproposal');
   var typeproposal = $('.typeproposal');
   var rekjenis = $('.rekjenis');
   var rekobj = $('.rekobj');
   var rekrincian = $('.rekrincian');
   var kategori = $('#kategori');
   if(kota != ''){
      var kabupaten_val = kota;
      var urlKec = urlbase+"/kecamatan/"+kabupaten_val;
      $.get(urlKec, 
        function(response){
          $(kecamatan).html(response);
          $(kelurahan).html("<option value='' data=''> Pilih Kelurahan </option>");
          if(kec != ''){
            $(kecamatan).val(kec);
            changekel();
          }
        });
   }
   if(skpd_old != ''){
      var skpd_val = skpd_old;
      var urlSub = urlbase+"/sub/"+skpd_val;
      $.get(urlSub, 
        function(response){
          $(sub_skpd).html(response);
          if(sub_skpd_old != ''){
            $(sub_skpd).val(sub_skpd_old);
           
          }
        });
   }

    if(rek_jenis != ''){
      var rekjenis_val = rek_jenis;
      var urlRekObj = urlbase+"/rekobj/"+rekjenis_val;
      $.get(urlRekObj, 
        function(response){
          $(rekobj).html(response);
          $(rekrincian).html("<option value='' data=''> Pilih Rekening Obj Rincian </option>");
          if(rek_obj != ''){
            $(rekobj).val(rek_obj);
            changerek();
            
          }
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
    
    if(jenisproposal.change(function(event) {
      var jenisproposal_val = jenisproposal.val();
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

    
    if(rekjenis.change(function(event) {
      var rekjenis_val = rekjenis.val();
      var urlRekjenis = urlbase+"/rekobj/"+rekjenis_val;
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

     function changerek(){
        var rekobj_val = rek_obj;
        var urlRekrincian = urlbase+"/rekrincian/"+rekobj_val;
        $.get(urlRekrincian,
        function(response){
            $(rekrincian).html(response);
           if(rekening != ''){
                $(rekrincian).val(rekening);
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
          $(kelurahan).html("<option value='' data=''> Pilih Kelurahan </option>");
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
