@extends('layouts.admin')
@section('admin_content')
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
       <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
					 <div class="panel nvd3-panel">
							<div class="panel-heading">
								<h3 class="panel-title">Log Aktifitas {{(Auth::user()->id=='1'?'':Auth::user()->name)}} (<a href="{{ route('log') }}">Detail</a>)</h3>
							</div>
							<div class="panel-body">
								 <div class="table-responsive">
									 <table class="table table-striped">
									   <thead>
											<tr>
												<th>ID</th>
												<th>User</th>
												<th>Action</th>
												<th>After</th>
												<th>Before</th>
												<th>Created</th>
											</tr>
											</thead>
											<tbody>
									@foreach ($LogActitity as $activity)
										<tr>
											<td>{{ $activity->id }}</td>
											<td>{{ isset($activity->user)? $activity->user->name:'System' }}</td>
											<td>{!! $activity->name !!}</td>
											<td>{!! $activity->after !!}</td>
											<td>{!! $activity->before !!}</td>
											{{--<td>{{ isset($activity->subject)? isset($activity->subject->title)? $activity->subject->title:'':'' }}</td>--}}
											<td>{{ $activity->created_at->diffForHumans() }}</td>
										</tr>
									@endforeach
											</tbody>
									</table>
									
								</div>
						</div>
			</div>
		</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
					 <div class="panel nvd3-panel">
							<div class="panel-heading">
								<h3 class="panel-title">Log Login {{(Auth::user()->id=='1'?'':Auth::user()->name)}} (<a href="{{ route('log-login') }}">Detail</a>)</h3>
							</div>
							<div class="panel-body">
								 <div class="table-responsive">
									<table class="table table-striped">
									   <thead>
											<tr>
												<th>Nama</th>
												<th>Role</th>
												<th>IP</th>
												<th>User Agent</th>
												<th>Created</th>
											</tr>
											</thead>
											<tbody>
									@foreach ($Loglogin as $action)
										<tr>
											<td>{!! isset($action->user)? $action->user->name:'System' !!}</td>
											<td>{!! $action->role !!}</td>
											<td>{!! $action->client_ip !!}</td>
											<td>{!! $action->client_agent !!}</td>
											<td>{{ $action->created_at->diffForHumans() }}</td>
										</tr>
									@endforeach
											</tbody>
									</table>
									
								</div>
						</div>
			</div>
		</div>
		</div>
		
		<div class="row hide">
			<div class="col-md-12">
				<div class="panel nvd3-panel">
							<div class="panel-heading">
								<h3 class="panel-title">History Laporan (<a href="{{ route('log') }}">Detail</a>)</h3>
							</div>
							<div class="panel-body">
								 <div class="table-responsive">
									 <table class="table table-striped">
									   <thead>
											<tr>
												<th>Device</th>
												<th>Judul</th>
												<th>Jalan</th>
												<th>Lokasi</th>
												<th>Pelapor</th>
												<th>Status</th>
											</tr>
											</thead>
											<tbody>
											</tbody>
									</table>
									
								</div>
						</div>
			</div>
			</div>
		</div>
	</section>
@endsection