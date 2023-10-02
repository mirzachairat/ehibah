@extends('Layouts.main')
@section('content')
<div class="block" id="berita">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li class="active">Manual Book</li>
        </ol>
        <section class="content-header">
            <h2>Manual Book</h2><hr style="margin-top: 0;">
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
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
                    <div class="panel ">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs nav-custom" style="margin: 0;">
                                            <li class="active">
                                                <a href="#tab-user" data-toggle="tab">
                                                <strong>User</strong>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#tab-opd" data-toggle="tab">
                                                <strong>OPD</strong>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#tab-inspektorat" data-toggle="tab">
                                                <strong>Inspektorat</strong>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#tab-tapd" data-toggle="tab">
                                                <strong>TAPD</strong>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#tab-banggar" data-toggle="tab">
                                                <strong>Banggar</strong>
                                                </a>
                                            </li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content nopadding noborder">
                                            <div id="tab-user" class="tab-pane animated fadeInRight fade in active">
                                                <a class="btn btn-success btn-sm pull-right" href="{!! URL::to('upload/manualbook/manual_book_ehibahbansos_user.pdf') !!}" target="_blank" title="View Document" data-toggle="tooltip"><i class="fa fa-fw fa-file-text"></i> View</a>
                                                <object class="col-lg-12" style="height: 500px;" data="{!! URL::to('upload/manualbook/manual_book_ehibahbansos_user.pdf') !!}" type="application/pdf">
                                                    <embed src="{!! URL::to('upload/manualbook/manual_book_ehibahbansos_user.pdf') !!}" type="application/pdf" />
                                                </object>
                                            </div>
                                            <div id="tab-opd" class="tab-pane animated fadeInRight fade">
                                                <a class="btn btn-success btn-sm pull-right" href="{!! URL::to('upload/manualbook/manualbook_opd.pdf') !!}" target="_blank" title="View Document" data-toggle="tooltip"><i class="fa fa-fw fa-file-text"></i> View</a>
                                                <object class="col-lg-12" style="height: 500px;" data="{!! URL::to('upload/manualbook/manualbook_opd.pdf') !!}" type="application/pdf">
                                                    <embed src="{!! URL::to('upload/manualbook/manualbook_opd.pdf') !!}" type="application/pdf" />
                                                </object>
                                            </div>
                                            <div id="tab-inspektorat" class="tab-pane animated fadeInRight fade">
                                                <a class="btn btn-success btn-sm pull-right" href="{!! URL::to('upload/manualbook/manualbook_inspektorat.pdf') !!}" target="_blank" title="View Document" data-toggle="tooltip"><i class="fa fa-fw fa-file-text"></i> View</a>
                                                <object class="col-lg-12" style="height: 500px;" data="{!! URL::to('upload/manualbook/manualbook_inspektorat.pdf') !!}" type="application/pdf">
                                                    <embed src="{!! URL::to('upload/manualbook/manualbook_inspektorat.pdf') !!}" type="application/pdf" />
                                                </object>
                                            </div>
                                            <div id="tab-tapd" class="tab-pane animated fadeInRight fade">
                                                <a class="btn btn-success btn-sm pull-right" href="{!! URL::to('upload/manualbook/manualbook_tapd.pdf') !!}" target="_blank" title="View Document" data-toggle="tooltip"><i class="fa fa-fw fa-file-text"></i> View</a>
                                                <object class="col-lg-12" style="height: 500px;" data="{!! URL::to('upload/manualbook/manualbook_tapd.pdf') !!}" type="application/pdf">
                                                    <embed src="{!! URL::to('upload/manualbook/manualbook_tapd.pdf') !!}" type="application/pdf" />
                                                </object>
                                            </div>
                                            <div id="tab-banggar" class="tab-pane animated fadeInRight fade">
                                                <a class="btn btn-success btn-sm pull-right" href="{!! URL::to('upload/manualbook/manualbook_banggar.pdf') !!}" target="_blank" title="View Document" data-toggle="tooltip"><i class="fa fa-fw fa-file-text"></i> View</a>
                                                <object class="col-lg-12" style="height: 500px;" data="{!! URL::to('upload/manualbook/manualbook_banggar.pdf') !!}" type="application/pdf">
                                                    <embed src="{!! URL::to('upload/manualbook/manualbook_banggar.pdf') !!}" type="application/pdf" />
                                                </object>
                                            </div>
                                            <!-- tab-pane -->
                                        </div>
                                        <!-- tab-content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    </div>
@endsection