@extends('Layouts.main')
@section('content')

        <div class="container-xxl py-5 bg-primary hero-header mb-5" style="background-color: #2D57C4 !important">
            <div class="container my-5 py-5 px-lg-5">
                <div class="row g-5">
                    <div class="col-lg-6 pt-5 text-center text-lg-start">
                        <h1 class="display-4 text-white mb-4 animated slideInLeft">E - Hibah Bansos Provinsi Banten</h1>
                        <p class="text-white animated slideInLeft">e-Hibah Bansos Provinsi Banten merupakan upaya Pemerintah Provinsi Banten dalam rangka menciptakan transparansi, akuntabilitas dan integrasi pelayanan dalam pengelolaan hibah dan bantuan sosial yang bersumber dari Anggaran Pendapatan dan Belanja Daerah Provinsi Banten.
                        <a href="" class="btn btn-secondary py-sm-3 px-sm-5 me-3 animated slideInLeft">Detail</a>
                    </div>
                    <div class="col-lg-6 text-center text-lg-start">
                        <img class="img-fluid animated zoomIn" src="img/hero.png" alt="">
                    </div>
                </div>
            </div>
        </div>

         <!-- Full Screen Search Start -->
         <div class="modal fade" id="searchModal" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content" style="background: rgba(29, 40, 51, 0.8);">
                    <div class="modal-header border-0">
                        <button type="button" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center justify-content-center">
                        <div class="input-group" style="max-width: 600px;">
                            <input type="text" class="form-control bg-transparent border-light p-3" placeholder="Type search keyword">
                            <button class="btn btn-light px-4"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Full Screen Search End -->

        <!-- Domain Search Start -->
        <div class="container-xxl domain mb-5" style="margin-top: 90px;">
            <div class="container px-lg-5">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="section-title position-relative text-center mx-auto mb-4 pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                            <h1 class="mb-3">Tahapan</h1>
                            {{-- <p class="mb-1">Vero justo sed sed vero clita amet. Et justo vero sea diam elitr amet ipsum eos ipsum clita duo sed. Sed vero sea diam erat vero elitr sit clita.</p> --}}
                        </div>
                        <div class="position-relative w-100 my-3 wow fadeInUp" data-wow-delay="0.3s">
                            <img src="{{asset('img/tahapan_bansos.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Domain Search End -->
        
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-7 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="section-title position-relative mb-4 pb-4">
                            <h1 class="mb-2">Statistik Proposal Tahun 2024</h1>
                        </div>
                        <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum et tempor sit. Aliqu diam amet diam et eos labore. Clita erat ipsum et lorem et sit, sed stet no labore lorem sit clita duo justo magna dolore erat amet</p>
                        <div>
                            <select name="tahun" id="" >
                                <option value="">Tahun Anngaran</option>
                                <option value="">2019</option>
                                <option value="">2021</option>
                                <option value="">2022</option>
                                <option value="">2023</option>
                                <option value="">2024</option>
                            </select>
                        </div>
                        <div>
                            <select name="tahun" id="" >
                                <option value="">Pilihan</option>
                                <option value="">Tahun Anngaran</option>
                                <option value="">Murni</option>
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <img class="img-fluid wow zoomIn" data-wow-delay="0.5s" src="img/about.png">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pricing Start -->
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mx-auto mb-5 pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">Berdasarkan Jenis</h1>
                    {{-- <p class="mb-1">Vero justo sed sed vero clita amet. Et justo vero sea diam elitr amet ipsum eos ipsum clita duo sed. Sed vero sea diam erat vero elitr sit clita.</p> --}}
                </div>
                <div class="row gy-5 gx-4">
                    <div class="row per-row"><hr style="margin-top: 0;">
                        <div class="col-md-4 col-sm-4 kolom">
                            <div class="item" data-id="4">
                                <div class="additional-info col-lg-12" style="padding: 10px;">
                                    <div class="description row">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-lg-4 col-md-4 col-sm-4 pull-left" align="left">
                                                    <i class="fa fa-book fa-3x" style="padding: 10% 0;"></i>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-8 pull-right" align="right">
                                                    <figure>Nilai Pengajuan {!! (count($Proposalhibah) > 0 && isset($Proposalhibah->type->name))?$Proposalhibah->type->name:'Hibah' !!}</figure>
                                                    <figure>Rp. {{number_format($nilaihibah,0,",",".")}},-</figure>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <hr style="margin: 5px 0;">
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-lg-4 col-md-4 col-sm-4 pull-left" align="left">
                                                    <div class="label label-default">Tahun Anggaran {!! (count($Proposalhibah) > 0 && isset($Proposalhibah->tahun))?$Proposalhibah->tahun:$th !!}  {!! ($perubahan=='1')?'Perubahan':'' !!}</div>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-8 pull-right" align="right">
                                                    <div class="label label-default">Jumlah : {!! (count($Proposalhibah) > 0 && isset($Proposalhibah->jumlah))?$Proposalhibah->jumlah:0 !!}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 kolom">
                            <div class="item" data-id="4">
                                <div class="additional-info col-lg-12" style="padding: 10px;">
                                    <div class="description row">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-lg-4 col-md-4 col-sm-4 pull-left" align="left">
                                                    <i class="fa fa-book fa-3x" style="padding: 10% 0;"></i>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-8 pull-right" align="right">
                                                    <figure>Nilai Pengajuan {!! (count($Proposalbansos) > 0 && isset($Proposalbansos->type->name))?$Proposalbansos->type->name:'Bansos' !!}</figure>
                                                    <figure>Rp. {{number_format($nilaibansos,0,",",".")}},-</figure>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <hr style="margin: 5px 0;">
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-lg-4 col-md-4 col-sm-4 pull-left" align="left">
                                                    <div class="label label-default">Tahun Anggaran {!! (count($Proposalbansos) > 0 && isset($Proposalbansos->tahun))?$Proposalbansos->tahun:$th !!}  {!! ($perubahan=='1')?'Perubahan':'' !!}</div>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-8 pull-right" align="right">
                                                    <div class="label label-default">Jumlah : {!! (count($Proposalbansos) > 0 && isset($Proposalbansos->jumlah))?$Proposalbansos->jumlah:0 !!}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>   
                        <?php
                            $total = $nilaibansos + $nilaihibah; 
                            $jumlah = ((count($Proposalhibah) > 0 && isset($Proposalhibah->jumlah))?$Proposalhibah->jumlah:0)+((count($Proposalbansos) > 0 && isset($Proposalbansos->jumlah))?$Proposalbansos->jumlah:0);
                        ?>
                        <div class="col-md-4 col-sm-4 kolom">
                            <div class="item" data-id="4">
                                <div class="additional-info col-lg-12" style="padding: 10px;">
                                    <div class="description row">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="col-lg-4 col-md-4 col-sm-4 pull-left" align="left">
                                                    <i class="fa fa-book fa-3x" style="padding: 10% 0;"></i>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-8 pull-right" align="right">
                                                    <figure>Total Nilai Pengajuan</figure>
                                                    <figure>Rp. {{number_format($total,0,",",".")}},-</figure>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <hr style="margin: 5px 0;">
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="col-lg-4 col-md-4 col-sm-4 pull-left" align="left">
                                                    <div class="label label-default">Tahun Anggaran {!! $th !!}  {!! ($perubahan=='1')?'Perubahan':'' !!}</div>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-8 pull-right" align="right">
                                                    <div class="label label-default">Jumlah : {!! $jumlah !!}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </div>
            </div>
        </div>
        <!-- Pricing End -->


        <!-- Comparison Start -->
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mx-auto mb-5 pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">Berdasarkan Tahapan</h1>
                
                </div>
                <div class="row g-5 comparison position-relative">
                    <div class="row per-row">
                    <div class="table-responsive col-lg-12">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Tahapan</th>
                            <th>Hibah</th>
                            <th>Bansos</th>
                            <th>Proposal</th>
                            <th>Nilai Pengajuan</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; $no = 1; $total = 0; $jumlah = 0; $hibah = 0; $bansos = 0; ?>
                        @if(count($State) <> 0)
                        @foreach($State as $row)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{!! $row->label !!}</td>
                                <td>{!! $jumlahhibahstate[$i] !!}</td>
                                <td>{!! $jumlahbansosstate[$i] !!}</td>
                                <td>{!! $jumlahproposalstate[$i] !!}</td>
                                <td>Rp. {{number_format($nilaistate[$i],0,",",".")}},-</td>
                            </tr>
                        <?php $total += $nilaistate[$i]; $jumlah += $jumlahproposalstate[$i]; $hibah += $jumlahhibahstate[$i]; $bansos += $jumlahbansosstate[$i]; $i++; ?>
                        @endforeach
                        @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">Total</td>
                                <td>{!! $hibah !!}</td>
                                <td>{!! $bansos !!}</td>
                                <td>{!! $jumlah !!}</td>
                                <td>Rp. {{number_format($total,0,",",".")}},-</td>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- Comparison Start -->

        <!-- Team Start -->
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mx-auto mb-5 pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">Berdasarkan OPD</h1>
                </div>
                <div class="row g-4">
                    <div class="row per-row">
                        <div class="table-responsive col-lg-12">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>OPD</th>
                                <th>Hibah</th>
                                <th>Bansos</th>
                                <th>Proposal</th>
                                <th>Nilai Pengajuan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0; $no = 1; $total = 0; $jumlah = 0; $hibah = 0; $bansos = 0; ?>
                            @if(count($Skpd) <> 0)
                            @foreach($Skpd as $row)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{!! $row->name !!}</td>
                                    <td>{!! $jumlahhibah[$i] !!}</td>
                                    <td>{!! $jumlahbansos[$i] !!}</td>
                                    <td>{!! $jumlahopd[$i] !!}</td>
                                    <td>Rp. {{number_format($nilaiopd[$i],0,",",".")}},-</td>
                                </tr>
                            <?php $total += $nilaiopd[$i]; $jumlah += $jumlahopd[$i]; $hibah += $jumlahhibah[$i]; $bansos += $jumlahbansos[$i]; $i++; ?>
                            @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">Total</td>
                                    <td>{!! $hibah !!}</td>
                                    <td>{!! $bansos !!}</td>
                                    <td>{!! $jumlah !!}</td>
                                    <td>Rp. {{number_format($total,0,",",".")}},-</td>
                                </tr>
                            </tfoot>
                        </table>
                        </div>
                    </div>
                </div>
                <div class="row per-row">
                    <h2>Grafik Proposal Tahun {{$th}}  {!! ($perubahan=='1')?'Perubahan':'' !!}</h2><hr style="margin-top: 0;">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <h2>Berdasarkan Jenis</h2><hr style="margin-top: 0;">
                                <canvas id="myChart"></canvas>
                            </div>
                            <div class="col-lg-6">
                                <h2>Berdasarkan Tahapan</h2><hr style="margin-top: 0;">
                                <canvas id="myCharttahapan"></canvas>
                            </div>
                            <div class="col-lg-12">
                                <br>
                                <h2>Berdasarkan OPD</h2><hr style="margin-top: 0;">
                                <canvas id="myChartopd"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Team End -->

@endsection