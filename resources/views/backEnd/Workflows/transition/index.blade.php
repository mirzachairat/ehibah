@extends('layouts.admin')
@section('admin_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Tabel Transition</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Transition</li>
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
                    <th>Name</th>
                    <th>Label</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Description</th>
                    <th>WorkFlow</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $i=0;?>
                        @foreach($transitions as $transition)            
                        <?php $i++;?>
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $transition->name }}</td>
                            <td>{{ $transition->label }}</td>
                            <td>{{ $transition->from }}</td>
                            <td>{{ $transition->to }}</td>
                            <td>{{ $transition->message }}</td>
                            <td>{{ $transition->label }}</td>
                            <td>
                                @if($transition->status == 0)
                                    <span class="label label-danger">Non Aktif</span>
                                @elseif($transition->status == 1)
                                    <span class="label label-success">Aktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                            @if($transition->status == 0)
                                {{-- <a class="btn btn-primary btn-xs" href="{{ route('transitionActive',$transition->id) }}"><span class="fa fa-fw ti-unlock"></span> Aktif</a>  --}}
                            @elseif($transition->status == 1)
                                {{-- <a class="btn btn-xs btn-danger" href="{{ route('transitionDeactive',$transition->id) }}"><span class="fa fa-fw ti-lock"></span> Non Aktif</a> --}}
                            @endif
                                {{-- <!--<a class="btn btn-xs btn-info" href="{{ route('transitionFormEdit',$transition->id) }}"><span class="fa fa-fw ti-pencil"></span> Edit</a>--> --}}
                            
                                    {{-- <a class="btn btn-xs btn-primary" href="{{ route('transitionFormEdit',$transition->id) }}"><span class="fa fa-fw fa-edit"></span>Edit</a> --}}
                            </td>
                        </tr>    
                    @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Name</th>
                    <th>Label</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Description</th>
                    <th>WorkFlow</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
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