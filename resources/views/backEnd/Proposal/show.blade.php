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
                    Pengaju : {!! ((isset($Proposal->users)) ? (isset($Proposal->users->roles)?$Proposal->users->roles[0]->name:'-') : '-') !!}</br>
					Nama (Individu atau Organisasi): {!! ((isset($Proposal->user)) ? $Proposal->user : $Proposal->name) !!}</br>
					Alamat : {!! ucwords(strtolower($alamat)) !!}</br>
                    Telephone : {!! ((isset($Proposal->users)) ? $Proposal->users->phone : '-') !!}</br>
                    Email : {!! ((isset($Proposal->users)) ? $Proposal->users->email : '-') !!}</br>
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
					Tanggal Masuk LPJ : @if(isset($Proposal->tanggal_lpj)) {{ date('M d, Y', strtotime($Proposal->tanggal_lpj)) }} @else - @endif </br>
                </p>
          
                <div class="clearfix"></div>
            </div>
            <!--rightside bar -->
				<div class="row">
				<div class="col-md-8">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">
								<i class="fa fa-fw ti-move"></i> Rencana Penggunaan Dana
							</h3>
							<span class="pull-right">
									<i class="fa fa-fw ti-angle-up clickable"></i>
									<i class="fa fa-fw ti-close removepanel clickable"></i>
							</span>
						</div>
						<div class="panel-body">
							<div class="form-body">
								<div class="table-responsive">
									 <table class="table table-bordered table-hover">
										<tr>
											<th>Dana</th>
											<th>Proposal</th>
											<th>Disetujui</th>
										</tr>
										<tbody>
                                        <?php $amount = 0; $correction = 0; ?>
										 @foreach($dana as $dn)
                                            <?php
                                                $v1 = $dn->correction; $v2 = $dn->correction_inspektorat; 
                                                $v3 = $dn->correction_tapd; $v4 = $dn->correction_banggar;
                                                if($v4 > 0){ $setuju = $v4; }
                                                else{
                                                    if($v3 > 0){ $setuju = $v3; }
                                                    else{
                                                        if($v2 > 0){ $setuju = $v2; }
                                                        else{
                                                            if($v1 > 0){ $setuju = $v1; }
                                                            else{ $setuju = 0; }
                                                        }
                                                    }
                                                }
                                            ?>
											<tr>
												<td>{!! $dn->description !!}</td>
												<td>Rp. {!! number_format($dn->amount,0,",",".")!!},-</td>
												<td>Rp. {!!number_format($setuju,0,",",".")!!},-</td>
											</tr>
                                        <?php $amount += $dn->amount; $correction += $setuju; ?>
										@endforeach
										</tbody>
										<tfoot>
										<tr>
											<th>Total</th>
                                            <th>Rp. {{number_format($amount,0,",",".")}},-</th>
                                            <th>Rp. {{number_format($correction,0,",",".")}},-</th>
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