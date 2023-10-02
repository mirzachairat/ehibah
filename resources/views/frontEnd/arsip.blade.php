@extends('Layout.main')
@section('content')
<style>
.text-center{
	  text-align: center;
	}
	.card-img-top{
	  width: 100%;
	}
	/*Call to Action*/

	.header-line {
	  height: 5px;
	  width: 100%;
	  content: '';
	  display: block;
	}
	.gradient-color-1{
		 background: -webkit-linear-gradient(left,#fc636b 0,#ff6d92 60%,#fd9a00 100%);
		background: linear-gradient(to right,#fc636b 0,#ff6d92 60%,#fd9a00 100%);
	}
	.gradient-color-2{
		background: #3be8b0;
		background: -webkit-linear-gradient(bottom left,#3be8b0 0,#02ceff 100%);
		background: linear-gradient(to top right,#3be8b0 0,#02ceff 100%);
	}
	/**/
	/*Utility Class*/
	.text-white{
	  color: white;
	}
	.no-margin{
	  margin:0;
	}
	.no-margin-top{
	  margin-top:0;
	}
	.pad-right{
	  margin-right: 0.5em;
	}
</style>
<div class="container">
<ol class="breadcrumb">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('/proposal') }}">Proposal</a></li>
  <li class="active">Arsip</li>
</ol>
<section class="page-title pull-left">
	<h2>{!! $Proposal->judul !!}</h2>
	<h3>{!! $Proposal->address !!}</h3> 
	<div class="rating-passive" >
        <span class="reviews">Oleh : {!! ((isset($Proposal->user)) ? $Proposal->user : $Proposal->name) !!}</span>
		<span class="reviews">{!! date_format(date_create($Proposal->time_entry),"d/m/Y H:i:s") !!}</span>		
	</div>
</section>
</div>
<div class="container">
	<div class="row">
        <div class="col-lg-12">
			<div class="row">
				<div class="panel ">
					<div class="panel-heading">
						<h3 class="panel-title">
							<i class="ti-book"></i> {{ $Proposal->judul }}
						</h3>
					</div>
					<div class="panel-body">
						<p class="text-justify">
							<span >Tahun Anggaran :</span> {{(($Proposal->perubahan==1)?$Proposal->tahun.' Perubahan':$Proposal->tahun)}}</br>
							Nama (Individu atau Organisasi): {!! $Proposal->name !!}</br>
							Alamat : {!! $Proposal->address !!}</br>
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
							Tahap : {!! $Proposal->status->label !!}</br>
							Keterangan : @if(isset($Checklist->value)) {{ $Checklist->value }} @else - @endif </br>
							Tanggal Masuk LPJ : @if(isset($Proposal->tanggal_lpj)) {{ date('M d, Y', strtotime($Proposal->tanggal_lpj)) }} @else - @endif</br>
						</p>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="panel ">
					<div class="panel-heading">
						<h3 class="panel-title">
							<i class="ti-book"></i> Photo {{ $Proposal->judul }}
						</h3>
					</div>
					<div class="panel-body">
						@forelse($photos as $photo)
	                        @if(file_exists( public_path('upload/media/proposal_foto/'.$photo->path) ))
							<div class="col-md-2" style="margin-bottom:10px;">
								<div class="card cta cta--featured">
								  <span class="header-line gradient-color-1"></span>
								  <div class="card-block">
									<a href="{!! URL::to('upload/media/proposal_foto/'.$photo->path) !!}" data-fancybox="images">
										<img class="card-img-top" src="{!! URL::to('upload/media/proposal_foto/'.$photo->path) !!}" alt="{{ $photo->path }}" style="margin-bottom:10px;"/>
									</a>
									<a href="{{ route('delImgs',$photo->path) }}" onclick="return areyousure();" class="btn btn-xs btn-danger"><i class="fa fa-fw fa-remove"></i> Hapus</a>
								  </div>
								</div>
							</div>
							@endif
						@empty
							<p class="text-muted">Please click on the panel below to upload photos (.jpg/.jpeg/.png)
								to {!! $Proposal->judul !!}.
							</p>
						@endforelse
					</div>
				</div>
			</div>
			
			<div class="row">
                <div class="panel ">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="ti-upload"></i> Upload Photo
                        </h3>
                    </div>
                    <div class="panel-body">
					 <div class="row">
						<div class="col-xs-12">
							<div class="box box-primary box-solid">
								<div class="box-header with-border">
									<h3 class="box-title">
										<span><i class="fa fa-cloud"></i></span>
										<span>Upload a Photo</span>
									</h3>
								</div>

								<div class="box-body">

									<div class="callout callout-info callout-help">
										<h4 class="title">Cara Upload photo</h4>
										<p>
											Klik dibawah untuk upload Photo (.jpg/.jpeg/.png)<br/>
											Refresh page ketika proses upload selesai<br/>
										</p>
									</div>

									<form id="formPhotoDropzone" class="dropzone" method="POST" action="/proposal/uploadPhotos" enctype="multipart/form-data">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="proposal_id" value="{{ $Proposal->id }}">
					
										<div class="dz-default dz-message">
											<span>Click here to browse for photos (.jpg/.jpeg/.png)</span>
										</div>
									</form>

									<div id="preview-template" style="display: none">
										<div class="dz-preview dz-file-preview">
											<a class="dropzone-image-click" href="#">
												<div class="dz-image">
													<img data-dz-thumbnail/>
												</div>
												<div class="dz-details">
													<div class="dz-size"><span data-dz-size></span></div>
													<!--<div class="dz-filename"><span data-dz-name></span></div>-->
													<span class="image-row-title-span"></span>
												</div>
												<div class="dz-progress">
													<span class="dz-upload" data-dz-uploadprogress></span></div>
												<div class="dz-error-message"><span data-dz-errormessage></span>
												</div>
												<div class="dz-success-mark">
													<svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
														<title>Check</title>
														<defs></defs>
														<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
															<path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
														</g>
													</svg>
												</div>
												<div class="dz-error-mark">
													<svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
														n <title>Error</title>n
														<defs></defs>
														n
														<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
															n
															<g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
																n
																<path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
															</g>
														</g>
													</svg>
												</div>
											</a>
										</div>
									</div>
								</div>

								<div class="box-footer">
								</div>
							</div>
						</div>
					</div>	
                    </div>
                </div>
			</div>
			<!-- End Image -->
			
			<!-- Start Document-->
			<div class="row">
				<div class="panel ">
					<div class="panel-heading">
						<h3 class="panel-title">
							<i class="ti-book"></i> {!! $Proposal->judul !!} Documents Proposal
						</h3>
					</div>
					<div class="panel-body">
					@if($Proposal->file!='')
						<div class="col-md-2" style="margin-bottom:10px;">
								<div class="card cta cta--featured">
									<span class="header-line gradient-color-1"></span>
									<div class="card-block">
		                                @if(file_exists( public_path('upload/media/proposal/'.$Proposal->file) ))
											<a class="btn btn-default btn-xs" href="{!! URL::to('upload/media/proposal/'.$Proposal->file) !!}" target="_blank" title="View Document" data-toggle="tooltip">
												<object class="col-lg-12" data="{!! URL::to('upload/media/proposal/'.$Proposal->file) !!}" type="application/pdf">
											        <embed src="{!! URL::to('upload/media/proposal/'.$Proposal->file) !!}" type="application/pdf" />
											    </object>
											</a>
											<a class="btn btn-success btn-xs" href="{!! URL::to('upload/media/proposal/'.$Proposal->file) !!}" target="_blank" title="View Document" data-toggle="tooltip"><i class="fa fa-fw fa-file-text"></i> View</a>
											<a href="{{ route('delFiles',$Proposal->id) }}" onclick="return areyousure();" class="btn btn-xs btn-danger"><i class="fa fa-fw fa-remove"></i> Hapus</a>
		                                @endif
									</div>
								</div>
						</div>
					@else
						<p class="text-muted">Please click on the panel below to upload dokumen (.pdf)
							to {!! $Proposal->judul !!}.
						</p>
					@endif
					</div>
				</div>
			</div>
			@if($Proposal->file=='')
			<div class="row">
                <div class="panel ">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="ti-upload"></i> Upload Document Proposal
                        </h3>
                    </div>
                    <div class="panel-body">
					 <div class="row">
						<div class="col-xs-12">
							<div class="box box-primary box-solid">
								<div class="box-header with-border">
									<h3 class="box-title">
										<span><i class="fa fa-cloud"></i></span>
										<span>Upload a Document Proposal</span>
									</h3>
								</div>

								<div class="box-body documents-container">

									<div class="callout callout-info callout-help">
										<h4 class="title">Cara upload dokumen proposal</h4>
										<p>
											Klik dibawah untuk upload dokumen proposal (.pdf)<br/>
											Refresh page ketika proses upload selesai<br/>
										</p>
									</div>

									<form id="formDocumentDropzone" class="dropzone" method="POST" action="/proposal/uploadFile" enctype="multipart/form-data">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" name="proposal_id" value="{{ $Proposal->id }}">

										<div class="dz-default dz-message">
											<span>Click here to browse for documents (.pdf)</span>
										</div>
									</form>

									<div id="preview-template" style="display: none">
										<div class="dz-preview dz-file-preview">
											<a class="dropzone-image-click" href="#">
												<div class="dz-image">
													<img data-dz-thumbnail/>
												</div>
												<div class="dz-details">
													<div class="dz-size"><span data-dz-size></span></div>
													<!--<div class="dz-filename"><span data-dz-name></span></div>-->
													<span class="image-row-title-span"></span>
												</div>
												<div class="dz-progress">
													<span class="dz-upload" data-dz-uploadprogress></span></div>
												<div class="dz-error-message"><span data-dz-errormessage></span>
												</div>
												<div class="dz-success-mark">
													<svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
														<title>Check</title>
														<defs></defs>
														<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
															<path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
														</g>
													</svg>
												</div>
												<div class="dz-error-mark">
													<svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
														n <title>Error</title>n
														<defs></defs>
														n
														<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
															n
															<g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
																n
																<path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
															</g>
														</g>
													</svg>
												</div>
											</a>
										</div>
									</div>
								</div>

								<div class="box-footer">
								</div>
							</div>
						</div>
					</div>	
                    </div>
                </div>
			</div>
			@endif				
			
			<!-- Start Document LPJ-->
			<div class="row">
				<div class="panel ">
					<div class="panel-heading">
						<h3 class="panel-title">
							<i class="ti-book"></i> {!! $Proposal->judul !!} Documents LPJ
						</h3>
					</div>
					<div class="panel-body">
					@forelse($lpj as $lpjfile)
                        @if(file_exists( public_path('upload/media/lpj/'.$lpjfile->path) ))
						<div class="col-md-2" style="margin-bottom:10px;">
							<div class="card cta cta--featured">
							  <span class="header-line gradient-color-1"></span>
							  <div class="card-block">
								<a class="btn btn-default btn-xs" href="{!! URL::to('upload/media/lpj/'.$lpjfile->path) !!}" target="_blank" title="View Document" data-toggle="tooltip">
									<object class="col-lg-12" data="{!! URL::to('upload/media/lpj/'.$lpjfile->path) !!}" type="application/pdf">
								        <embed src="{!! URL::to('upload/media/lpj/'.$lpjfile->path) !!}" type="application/pdf" />
								    </object>
								</a>
								<a class="btn btn-success btn-xs" href="{!! URL::to('upload/media/lpj/'.$lpjfile->path) !!}" target="_blank" title="View Document" data-toggle="tooltip"><i class="fa fa-fw fa-file-text"></i> View</a>
								<a href="{{ route('delFileLPJs',$lpjfile->path) }}" onclick="return areyousure();" class="btn btn-xs btn-danger"><i class="fa fa-fw fa-remove"></i> Hapus</a>
							  </div>
							</div>
						</div>
						@endif
					@empty
						<p class="text-muted">Please click on the panel below to upload dokumen (.pdf)
							to {!! $Proposal->judul !!}.
						</p>
					@endforelse
					</div>
				</div>
			</div>
			@if($Proposal->current_stat=='3')
			<div class="row">
                <div class="panel ">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="ti-upload"></i> Upload Document
                        </h3>
                    </div>
                    <div class="panel-body">
					 <div class="row">
						<div class="col-xs-12">
							<div class="box box-primary box-solid">
								<div class="box-header with-border">
									<h3 class="box-title">
										<span><i class="fa fa-cloud"></i></span>
										<span>Upload a Document LPJ</span>
									</h3>
								</div>

								<div class="box-body documents-container">

									<div class="callout callout-info callout-help">
										<h4 class="title">Cara upload dokumen LPJ</h4>
										<p>
											Klik dibawah untuk upload dokumen LPJ (.pdf)<br/>
											Refresh page ketika proses upload selesai<br/>
										</p>
									</div>

									<form id="formDocumentLPJDropzone" class="dropzone" method="POST" action="/proposal/uploadFileLPJ" enctype="multipart/form-data">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" name="proposal_id" value="{{ $Proposal->id }}">

										<div class="dz-default dz-message">
											<span>Click here to browse for documents (.pdf)</span>
										</div>
									</form>

									<div id="preview-template" style="display: none">
										<div class="dz-preview dz-file-preview">
											<a class="dropzone-image-click" href="#">
												<div class="dz-image">
													<img data-dz-thumbnail/>
												</div>
												<div class="dz-details">
													<div class="dz-size"><span data-dz-size></span></div>
													<!--<div class="dz-filename"><span data-dz-name></span></div>-->
													<span class="image-row-title-span"></span>
												</div>
												<div class="dz-progress">
													<span class="dz-upload" data-dz-uploadprogress></span></div>
												<div class="dz-error-message"><span data-dz-errormessage></span>
												</div>
												<div class="dz-success-mark">
													<svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
														<title>Check</title>
														<defs></defs>
														<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
															<path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
														</g>
													</svg>
												</div>
												<div class="dz-error-mark">
													<svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
														n <title>Error</title>n
														<defs></defs>
														n
														<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
															n
															<g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
																n
																<path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
															</g>
														</g>
													</svg>
												</div>
											</a>
										</div>
									</div>
								</div>

								<div class="box-footer">
								</div>
							</div>
						</div>
					</div>	
                    </div>
                </div>
			</div>
			@endif

			<a href="{{ route('proposal') }}" class="btn btn-effect-ripple btn-default reset_btn">Kembali</a>
            <div class="clearfix"></div>
        </div>
		<div class="background-overlay"></div>
	</div>
</div>
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
function areyousure(){
	if (confirm("Apakah anda yakin akan menghapus data ini?")) {
    	return true;
	} else {
	    return false;
	}
}
</script>


    <script type="text/javascript" charset="utf-8">
        Dropzone.autoDiscover = false;
        $(function () {
            activateImageClick();

            // lightbox.option({
                // 'wrapAround': true,
                // 'resizeDuration': 200,
            // })

            // autodiscover was turned off - update the settings
            var photoDropzone = new Dropzone("#formPhotoDropzone");
            photoDropzone.options.maxFiles = "10";
            photoDropzone.options.maxFilesize = "1024";
            photoDropzone.options.paramName = "file";
            photoDropzone.previewTemplate = $('#preview-template').html();
            photoDropzone.on("success", function (file, response) {
                if (response.success) {
                    file.hiddenInputs = Dropzone.createElement('<input class="image-row-title" type="hidden" value=""/>');
                    file.previewElement.appendChild(file.hiddenInputs);
                    file.hiddenInputs = Dropzone.createElement('<input class="image-row-id" type="hidden" id="image-row-' + response.id + '" value="' + response.id + '"/>');
                    file.previewElement.appendChild(file.hiddenInputs);
                }
                var message = response.content; var notif = response.message;
                $.notify(message,notif);
            });

            function activateImageClick()
            {
                $('.dropzone-image-click').off('click');
                $('.dropzone-image-click').on('click', function (e) {
                    e.preventDefault();

                    var id = $($(this).parent().find('.image-row-id')).val();
                    var title = $($(this).parent().find('.image-row-title')).val();

                    if ($(this).attr('data-id')) {
                        id = $(this).attr('data-id');
                        title = $(this).attr('data-title');
                    }

                    $('#modal-photo-id').val(id);
                    $('#modal-photo-name').val(title);
                    $('#modal-photo').modal();

                    return false;
                });
            }
        })
    </script>
    @if($Proposal->file == '')
	<script type="text/javascript" charset="utf-8">
        Dropzone.autoDiscover = false;
        $(function () {
            activateImageClick();

            // autodiscover was turned off - update the settings
            var documentDropzone = new Dropzone("#formDocumentDropzone");
            documentDropzone.options.maxFiles = "1";
            documentDropzone.options.maxFilesize = "1024";
            documentDropzone.options.paramName = "file";
            documentDropzone.previewTemplate = $('#preview-template').html();
            documentDropzone.on("success", function (file, response) {
                if (response.success) {
                    file.hiddenInputs = Dropzone.createElement('<input class="image-row-title" type="hidden" value=""/>');
                    file.previewElement.appendChild(file.hiddenInputs);
                    file.hiddenInputs = Dropzone.createElement('<input class="image-row-id" type="hidden" id="image-row-' + response.id + '" value="' + response.id + '"/>');
                    file.previewElement.appendChild(file.hiddenInputs);
                }
                var message = response.content; var notif = response.message;
                $.notify(message,notif);
            });

            function activateImageClick()
            {
                $('.dropzone-image-click').off('click');
                $('.dropzone-image-click').on('click', function (e) {
                    e.preventDefault();

                    var id = $($(this).parent().find('.image-row-id')).val();
                    var title = $($(this).parent().find('.image-row-title')).val();

                    if ($(this).attr('data-id')) {
                        id = $(this).attr('data-id');
                        title = $(this).attr('data-title');
                    }

                    $('#modal-document-id').val(id);
                    $('#modal-document-name').val(title);
                    $('#modal-document').modal();

                    return false;
                });
            }
			
        })
    </script>
    @endif
    @if($Proposal->current_stat == 3)
	<script type="text/javascript" charset="utf-8">
        Dropzone.autoDiscover = false;
        $(function () {
            activateImageClick();

            // autodiscover was turned off - update the settings
            var documentDropzone = new Dropzone("#formDocumentLPJDropzone");
            documentDropzone.options.maxFiles = "10";
            documentDropzone.options.maxFilesize = "1024";
            documentDropzone.options.paramName = "file";
            documentDropzone.previewTemplate = $('#preview-template').html();
            documentDropzone.on("success", function (file, response) {
                if (response.success) {
                    file.hiddenInputs = Dropzone.createElement('<input class="image-row-title" type="hidden" value=""/>');
                    file.previewElement.appendChild(file.hiddenInputs);
                    file.hiddenInputs = Dropzone.createElement('<input class="image-row-id" type="hidden" id="image-row-' + response.id + '" value="' + response.id + '"/>');
                    file.previewElement.appendChild(file.hiddenInputs);
                }
                var message = response.content; var notif = response.message;
                $.notify(message,notif);
            });

            function activateImageClick()
            {
                $('.dropzone-image-click').off('click');
                $('.dropzone-image-click').on('click', function (e) {
                    e.preventDefault();

                    var id = $($(this).parent().find('.image-row-id')).val();
                    var title = $($(this).parent().find('.image-row-title')).val();

                    if ($(this).attr('data-id')) {
                        id = $(this).attr('data-id');
                        title = $(this).attr('data-title');
                    }

                    $('#modal-document-id').val(id);
                    $('#modal-document-name').val(title);
                    $('#modal-document').modal();

                    return false;
                });
            }
			
        })
    </script>
    @endif
@endsection