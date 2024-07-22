<!DOCTYPE html>
<html>
<head>
	<title>Export Data Proposal</title>
</head>
<body>
	<style type="text/css">
	body{
		font-family: sans-serif;
	}
	table{
		margin: 20px auto;
		border-collapse: collapse;
	}
	table th,
	table td{
		border: 1px solid #3c3c3c;
		padding: 3px 8px;

	}
	a{
		background: blue;
		color: #fff;
		padding: 8px 10px;
		text-decoration: none;
		border-radius: 2px;
	}
	</style>

	<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data_Proposal.xls");
	?>

	<center>
		<h1>Export Data Proposal <br/> <?php echo $title; ?></h1>
	</center>

	<table border="1">
		<tr>
			<th>No</th>
			<th class="text-left">Judul</th>
			<th class="text-left">Jenis</th>
			<th class="text-left">Tanggal Proposal</th>
			<th class="text-left">Tahun Anggaran</th>
			<th class="text-left">Oleh</th>
			<th class="text-left">Tahapan</th>
			<th class="text-left">OPD</th>
			<th class="text-left">Isi</th>
			<th class="text-right">Nilai yang Diajukan</th>
			<th class="text-right">Nilai Dari OPD</th>
			<th class="text-right">Nilai Dari TAPD</th>
			<th class="text-right">Nilai yang Disetujui</th>
			<th class="text-right">Deskripsi Nilai yang Disetujui</th>
		</tr>
		<?php $i = 1; ?>
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
			<td>{!! $row->judul !!}</td>
			<td>{!! ($row->type_id==1)?"Hibah":(($row->type_id==2)?"Bansos":"") !!} {!! $row->typeproposal !!}</td>
			<td>{!! date('M d, Y', strtotime($row->time_entry)) !!}</td>
			<td>{{(($row->perubahan==1)?$row->tahun.' Perubahan':$row->tahun)}}</td>
			<td>{!! $oleh !!}</td>
			<td>{!! $status !!} {!! $cek !!}</td>
			<td>{!! $skpdd.$subskpd !!}</td>
			<td>{!! $konten !!}</td>
			<td class="text-right">Rp. {{number_format($amount,0,",",".")}},-</td>
			<!--<td class="text-right">Rp. {{number_format($correction,0,",",".")}},-</td>-->
			<td class="text-right">Rp. {{number_format($v1,0,",",".")}},-</td>
			<td class="text-right">Rp. {{number_format($v3,0,",",".")}},-</td>
			<td class="text-right">Rp. {{number_format($v4,0,",",".")}},-</td>
			<td></td>
		</tr>
		@endforeach
	</table>
</body>
</html>