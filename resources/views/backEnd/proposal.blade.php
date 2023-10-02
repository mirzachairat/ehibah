@extends('Layouts.admin')
@section('admin_content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Proposal</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/admin') }}">
                    <i class="fa fa-fw ti-home"></i> Dashboard 
                </a>
            </li>
            <li class="active">
                Proposal
            </li>
        </ol>
    </section>
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">DataTable Proposal</h3>
                  <div class="pull-right">
                    @if($roleid==5 || $roleid === 1 || $roleid==2 || $roleid==4 || $roleid==6)
                    <a type="button" class="btn btn-primary btn-sm" href="{{route('proposalsExport')}}"><i class="fa ti-export"></i> Export Proposal</a>
                    @endif
                    @if($roleid==5 || $roleid==1 || $roleid==2)
                    <a type="button" class="btn btn-primary btn-sm" href="{{route('proposalsCreate')}}"><i class="fa ti-plus"></i> Add Proposal</a>
                    @endif
                </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Badan / Lembaga / Organisasi Kemasyarakatan</th>							
                        <th>Alamat</th>
                        <th>Usulan Peruntukan</th>
                        <th>Tanggal Proposal</th>
                        <th>Nilai Proposal</th>
                        <th>Nilai Rekomendasi</th>
                        <th>Nilai Hasil Pembahasan Bersama</th>
                        <th>Nilai Penetapan</th>
                        <th class="text-center" style="width:10%;">Action</th>
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
                        <td>{!! isset($row->name)?$row->name:((isset($row->user)) ? $row->user : $row->name) !!}</td>
                        <td>{!! $row->address !!}</td>
                        <td><a href="{!! route('proposalsShow',['id'=>$row->id]) !!}">{!! $row->judul !!}</a></td>
                        <td>{!! date_format(date_create($row->time_entry),"d F Y") !!}</td>
                        <td class="text-right">Rp. {{number_format($amount,0,",",".")}},-</td>
                        <td class="text-right">Rp. {{number_format($v1,0,",",".")}},-</td>
                        <td class="text-right">Rp. {{number_format($v3,0,",",".")}},-</td>
                        <td class="text-right">Rp. {{number_format($v4,0,",",".")}},-</td>
                        <td class="text-center">
                                @if($roleid==5 || $roleid==1 || $roleid==2)
                                @if($row->current_stat <= 2)
                                @if($v2 == 0 && $v3 == 0 && $v4 == 0)
                                <a class="btn btn-info btn-xs" href="{!! route('proposalsEdit',['id'=>$row->id]) !!}"><span class="fa fa-fw ti-pencil"></span> Edit</a> 
                                @endif
                                @endif
                                @endif
                                <a class="btn btn-primary btn-xs" href="{!! route('proposalsKoreksi',['id'=>$row->id]) !!}"><span class="fa fa-fw ti-pencil"></span> Koreksi</a> 
                                @if($roleid==5 || $roleid==1 || $roleid==2)
                                <a class="btn btn-info btn-xs" href="{!! route('proposalsArsip',['id'=>$row->id]) !!}"><span class="fa fa-fw ti-folder"></span> Arsip</a> 
                                @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Badan / Lembaga / Organisasi Kemasyarakatan</th>							
                        <th>Alamat</th>
                        <th>Usulan Peruntukan</th>
                        <th>Tanggal Proposal</th>
                        <th>Nilai Proposal</th>
                        <th>Nilai Rekomendasi</th>
                        <th>Nilai Hasil Pembahasan Bersama</th>
                        <th>Nilai Penetapan</th>
                        <th class="text-center" style="width:10%;">Action</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>                    
</div>
@push('datatable')
<script src="{{asset('/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script>
     $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
@endpush  
@endsection