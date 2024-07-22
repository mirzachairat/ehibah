@extends('layouts.admin')
@section('admin_content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Tabel Peraturan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Peraturan</li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
            <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h3 class="card-title">DataTable</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="pull-right">
                        @if(Auth::user()->can('create-sub-skpd'))
                            <a type="button" class="btn btn-primary btn-sm" href="{{route('SubCreate')}}"><i class="fa ti-plus"></i> Add Sub Skpd</a>
                        @endif
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="text-center" style="width:5%;">No</th>
                        <th>Judul</th>
                        <th>Type</th>
                        <th>Urutan</th>
                        <th class="text-center" style="width:20%;">Opsi</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $i=0;?>
                            @foreach($Peraturan as $row)            
                            <?php $i++;?>
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$row->title}}</td>
                                <td>{{$row->type}}</td>
                                <td>{{$row->sequence}}</td>
                                <td class="text-center" >
                                    {{-- <a class="btn btn-info btn-xs" href="{{ route('peraturans_show',$row->id) }}"><span class="fa fa-fw ti-eye"></span> View</a> --}}
                                    {{-- <a class="btn btn-info btn-xs" href="{{ route('peraturansEdit',$row->id) }}"><span class="fa fa-fw ti-pencil"></span> Edit</a> --}}
                                    {{-- <a class="btn btn-danger btn-xs" href="{{ route('peraturansdestroy',$row->id) }}" onclick="return areyousure();"><span class="fa fa-fw ti-trash"></span> Delete</a>  --}}
                                </td> 
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th class="text-center" style="width:5%;">No</th>
                        <th>Judul</th>
                        <th>Type</th>
                        <th>Urutan</th>
                        <th class="text-center" style="width:20%;">Opsi</th>
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
        <!-- /.content -->
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