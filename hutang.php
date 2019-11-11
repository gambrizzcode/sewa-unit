<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

if (!$_SESSION['id_akun'] || $_SESSION['id_akun'] == "") {
	header("location:index.php");
}else{
	$qakun = mysql_query("SELECT * FROM akun WHERE id_akun = '$_SESSION[id_akun]'");
	$rakun = mysql_fetch_array($qakun);
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>Hutang | SewaUnit</title>
	<link rel="icon" href="assets/favicon.png">
	<link href="assets/css/bootstrap.css" rel="stylesheet" />
	<link href="assets/css/font-awesome.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet" />
	<link href="datatables/dataTables.bootstrap.css" rel="stylesheet" />
	<link href="assets/select2/select2.min.css" rel="stylesheet">
</head>
<!-- Author : Syaikhu Rizal -->
<body>
	<header>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<strong>Nama Perusahaan Persewaan</strong>
					&nbsp;&nbsp;
					alamat dan nomor telepon / hp
				</div>
			</div>
		</div>
	</header>

	<div class="navbar navbar-inverse set-radius-zero">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand">
					<h1 style="color:cyan;cursor:default"><b>SewaUnit</b></h1>
				</a>
			</div>

			<div class="left-div">
				<div class="user-settings-wrapper">
					<ul class="nav">
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
								<span class="glyphicon glyphicon-user" style="font-size: 25px;"></span>
							</a>
							<div class="dropdown-menu dropdown-settings">
								<div class="media">
									<h4 class="media-heading"><?php echo $rakun['nama_akun']; ?></h4>
									<h5><?php echo $rakun['level']; ?></h5>
								</div>
								<hr />
								<a href="logout.php" class="btn btn-danger btn-block btn-sm">Logout</a>
							</div>
						</li>
					</ul>
				</div>
			</div>

		</div>
	</div>

	<section class="menu-section">
		<?php
		if ($rakun['level'] == 'ADMIN') {
		}else{echo "<div class='container'>";};
		?>
			<div class="row">
				<div class="col-md-12">
					<div class="navbar-collapse collapse">
						<ul id="menu-top" class="nav navbar-nav navbar-right">
							<?php
							if ($rakun['level'] == 'ADMIN') { ?>
								<li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
								<li><a href="transaksi.php"><i class="fa fa-money"></i> Transaksi</a></li>
								<li><a href="unit.php"><i class="fa fa-suitcase"></i> Unit</a></li>
								<li><a href="rekening.php"><i class="fa fa-ticket"></i> Rekening</a></li>
								<li><a href="pelanggan.php"><i class="fa fa-users"></i> Pelanggan</a></li>
								<li><a href="jurnalumum.php"><i class="fa fa-file-text-o"></i> Jurnal Umum</a></li>
								<li><a class="menu-top-active" href="hutang.php"><i class="fa fa-minus-square-o"></i> Hutang</a></li>
								<li><a href="bukubesar.php"><i class="fa fa-book"></i> Buku Besar</a></li>
								<li><a href="pendapatan.php"><i class="fa fa-bar-chart-o"></i> Pendapatan Unit</a></li>
								<li><a href="petugas.php"><i class="fa fa-user"></i> Petugas</a></li>
							<?php
							}else{ ?>
								<li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
								<li><a href="bukubesar.php"><i class="fa fa-book"></i> Buku Besar</a></li>
								<li><a href="pendapatan.php"><i class="fa fa-bar-chart-o"></i> Pendapatan Unit</a></li>
							<?php
							};
							?>
						</ul>
					</div>
				</div>
			</div>
		<?php
		if ($rakun['level'] == 'ADMIN') {
		}else{echo "</div>";};
		?>
	</section>

	<div class="modal fade" id="modalTambah" data-backdrop="static" data-keyboard="false" tata-attention-animation="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3><i class="fa fa-minus-square-o"></i> Transaksi Hutang</h3>
				</div>
				<div class="modal-body">
					<label>No Hutang : <?php echo substr(md5(time()),0,8); ?></label>
					<input type="hidden" id="nohutang" value="<?php echo substr(md5(time()),0,8); ?>"><br>
					<label>Tanggal : </label>
					<input type="date" class="form-control" id="tanggal" value="<?php echo date('Y-m-d'); ?>">
					<label>Jenis Hutang : </label>
					<input type="text" class="form-control" id="jenis">
					<label>Uraian : </label>
					<textarea class="form-control" id="uraian"></textarea>
					<label>Nominal Hutang : </label>
					<input type="text" class="form-control" id="nominal">
					<div class="row">
						<div class="col-md-6">
							<label>Rekening Debet : </label>
							<select class="form-control select2" id="rek_deb" style="width: 100%">
								<option value="">--- Pilih Rekening Debet ---</option>
								<?php
								$qrek = mysql_query("SELECT * FROM rekening");
								while ($rrek = mysql_fetch_array($qrek)) { ?>
									<option value="<?php echo $rrek[0]; ?>"><?php echo $rrek[1]; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-6">
							<label>Rekening Kredit : </label>
							<select class="form-control select2" id="rek_kre" style="width: 100%">
								<option value="">--- Pilih Rekening Kredit ---</option>
								<?php
								$qrek = mysql_query("SELECT * FROM rekening");
								while ($rrek = mysql_fetch_array($qrek)) { ?>
									<option value="<?php echo $rrek[0]; ?>"><?php echo $rrek[1]; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<label>Jumlah Angsuran : </label>
					<input type="text" class="form-control" id="jml_angsuran">
					<hr>
					<button type="button" class="btn btn-primary btn-lg btn-flat pull-right" id="simpan" style="margin-left: 20px"><i class="fa fa-save"></i> SIMPAN</button>
					<button type="button" class="btn btn-warning pull-right" data-dismiss="modal"><i class="fa fa-close"></i> BATAL</button><br>
					<div id="hasil_simpan" style="display: none"></div>
					<br>
				</div>
			</div>
		</div>
	</div>

	<div class="content-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h4>
								<i class="fa fa-minus-square-o"></i> Transaksi Hutang
							</h4>
							<div class="row" align="right">
								<div class="col-md-12 form-inline">
									Dari Tanggal : <input type="date" class="form-control" id="dari" <?php if(!$_REQUEST['dari']){}else{echo "value='".$_REQUEST['dari']."'";} ?>>
									&nbsp;
									Sampai Tanggal : <input type="date" class="form-control" id="ke" <?php if(!$_REQUEST['ke']){}else{echo "value='".$_REQUEST['ke']."'";} ?>>
									<button type="button" class="btn btn-flat btn-warning" id="go"><i class="fa fa-search"></i> GO !!</button>
									&nbsp;
									<button type="button" class="btn btn-flat btn-info" id="prin"><i class="fa fa-print"></i> PRINT</button>
									&nbsp;
									<button type="button" class="btn btn-success btn-flat pull-right" data-toggle="modal" data-target="#modalTambah">
									<i class="fa fa-plus"></i> Tambah Hutang
								</button>
								</div>
							</div>
						</div>
						<div class="panel-body table-responsive">
							<table style="font-size: 13px" id="tbl_hutang" class="table table-condensed table-hovered table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Jenis Hutang</th>
										<th>Total hutang</th>
										<th>Total Bayar</th>
										<th>Sisa Hutang</th>
										<th>Banyaknya Angs.</th>
										<th>Sisa Angs.</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 1;
									if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
										$datahutang = mysql_query("SELECT * FROM hutang");
									}else{
										$datahutang = mysql_query("SELECT * FROM hutang WHERE tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
									}
									while ($isihutang = mysql_fetch_array($datahutang)) { ?>
									<tr>
										<td><?php echo $no++; ?></td>
										<td><?php echo $isihutang['jenis']; ?></td>
										<td><?php echo "Rp. ".number_format($isihutang['nominal'],0,",","."); ?></td>
										<td><?php
										if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
											$qbyar = mysql_query("SELECT SUM(total) FROM bayar_hutang WHERE no_hutang = '$isihutang[0]'");
										}else{
											$qbyar = mysql_query("SELECT SUM(total) FROM bayar_hutang WHERE no_hutang = '$isihutang[0]' AND tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
										}
										$rbyar = mysql_fetch_array($qbyar);
										echo "Rp. ".number_format($rbyar[0],0,",",".");
										?></td>
										<td><?php
										if ($isihutang['nominal']-$rbyar[0] == 0) {
											echo "<b style='color:green'>Rp. ".number_format($isihutang['nominal']-$rbyar[0],0,",",".")."</b>";
										}else{
											echo "<b style='color:red'>Rp. ".number_format($isihutang['nominal']-$rbyar[0],0,",",".")."</b>";
										}
										?></td>
										<td><?php echo $isihutang['jml_angsuran']." Kali"; ?></td>
										<td><?php
										if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
											$qangs = mysql_query("SELECT COUNT(no_hutang) FROM bayar_hutang WHERE no_hutang = '$isihutang[0]'");
										}else{
											$qangs = mysql_query("SELECT COUNT(no_hutang) FROM bayar_hutang WHERE no_hutang = '$isihutang[0]' AND tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
										}
										$rangs = mysql_fetch_array($qangs);
										$ahay = $isihutang['jml_angsuran']-$rangs[0];
										if ($isihutang['nominal']-$rbyar[0] == 0) {
											echo "<b style='color:green'>".$ahay." Kali</b>";
										}else{
											echo "<b style='color:red'>".$ahay." Kali</b>";
										}
										?></td>
										<td>
											<button type="button" id="tombol_hapus" class="btn btn-danger btn-xs btn-flat" data-toggle="modal" data-target="#<?php echo $isihutang[0]; ?>" title="HAPUS"><span class="fa fa-trash"></span></button>

											<div class="modal fade" id="<?php echo $isihutang[0]; ?>" role="dialog">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<center><h3 class="modal-title">YAKIN HAPUS <i class="fa fa-question"></i></h3></center>
														</div>
														<div class="modal-body" align="center">
															<a href="hapusHutang.php?nohutang=<?php echo $isihutang[0]; ?>"><button type="button" class="btn btn-danger"><span class="fa fa-trash"></span> HAPUS</button></a>
															&nbsp;&nbsp;&nbsp;
															<button type="button" class="btn btn-warning" data-dismiss="modal">CANCEL</button>
														</div>
													</div>
												</div>
											</div>
											|
											<button type="button" class="btn btn-xs btn-warning btn-flat buka_modal_edit" id="<?php echo $isihutang[0]; ?>" title="EDIT"><span class="fa fa-edit"></span></button> 
											|
											<button type="button" class="btn btn-xs btn-info btn-flat buka_modal_detail" id="<?php echo $isihutang[0]; ?>" title="DETAIL"><span class="fa fa-file-text"></span></button> 
											| 
											<button type="button" class="btn btn-xs btn-success btn-flat buka_modal_angsur" id="<?php echo $isihutang[0]; ?>" title="ANGSUR"><span class="fa fa-money"></span></button> 
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>

					<div class="modal fade" id="modalEditHutang" data-backdrop="static" data-keyboard="false" tata-attention-animation="true" aria-labelledby="myModalLabel" aria-hidden="true"></div>

					<div class="modal fade" id="modalEditDetail" data-backdrop="static" data-keyboard="false" tata-attention-animation="true" aria-labelledby="myModalLabel" aria-hidden="true"></div>

					<div class="modal fade" id="modalEditAngsur" data-backdrop="static" data-keyboard="false" tata-attention-animation="true" aria-labelledby="myModalLabel" aria-hidden="true"></div>

				</div>
			</div>

		</div>
	</div>

	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					&copy; Copyright 2017 | By : Syaikhu Rizal, ANMEDIACORP JEMBER
				</div>
			</div>
		</div>
	</footer>

<script src="assets/js/jquery-1.11.1.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="datatables/jquery.dataTables.min.js"></script>
<script src="datatables/dataTables.bootstrap.min.js"></script>
<script src="assets/select2/select2.full.min.js"></script>
<script>
$(function(){
	$('.buka_modal_detail').click(function() {
		var id = $(this).attr('id');
		$.ajax({
			url: 'detailHutang.php',
			type: 'GET',
			data: "idhut="+id,
			success:function(detail){
				$('#modalEditDetail').html(detail);
				$('#modalEditDetail').modal('show',{backdorp:'true'});
				$(".select2").select2();
			}
		});
	});

	$('.buka_modal_angsur').click(function() {
		var id = $(this).attr('id');
		$.ajax({
			url: 'angsurHutang.php',
			type: 'GET',
			data: "idhut="+id,
			success:function(angsur){
				$('#modalEditAngsur').html(angsur);
				$('#modalEditAngsur').modal('show',{backdorp:'true'});
				$(".select2").select2();
			}
		});
	});
	$('.buka_modal_edit').click(function() {
		var id = $(this).attr('id');
		$.ajax({
			url: 'editHutang.php',
			type: 'GET',
			data: "idhut="+id,
			success:function(edit){
				$('#modalEditHutang').html(edit);
				$('#modalEditHutang').modal('show',{backdorp:'true'});
				$(".select2").select2();
			}
		});
	});
});
$(document).ready(function() {
	$(".select2").select2();
	$('#tbl_hutang').DataTable();

	$('#simpan').click(function() {
		var dataa = {
			nohutang 		: $('#nohutang').val(),
			tanggal 		: $('#tanggal').val(),
			jenis 			: $('#jenis').val(),
			uraian 			: $('#uraian').val(),
			nominal 		: $('#nominal').val(),
			rek_deb 		: $('#rek_deb').val(),
			rek_kre 		: $('#rek_kre').val(),
			jml_angsuran	: $('#jml_angsuran').val()
		};
		$.ajax({
			url: 'simpanHutang.php',
			type: 'GET',
			data: dataa,
			success:function(simpan){
				$('#hasil_simpan').html(simpan);
				window.location="hutang.php";
			}
		});
	});

	$('.buka_modal_edit').click(function() {
		var id = $(this).attr('id');
		$.ajax({
			url: 'editHutang.php',
			type: 'GET',
			data: "idhut="+id,
			success:function(edit){
				$('#modalEditHutang').html(edit);
				$('#modalEditHutang').modal('show',{backdorp:'true'});
				$(".select2").select2();
			}
		});
	});

	$('#modalEditHutang').mouseenter(function() {
		$('#update').click(function() {
			var datau = {
				newnohutang 	: $('#newnohutang').val(),
				newtanggal 		: $('#newtanggal').val(),
				newjenis 		: $('#newjenis').val(),
				newuraian 		: $('#newuraian').val(),
				newnominal 		: $('#newnominal').val(),
				newrek_deb 		: $('#newrek_deb').val(),
				newrek_kre 		: $('#newrek_kre').val(),
				newjml_angsuran	: $('#newjml_angsuran').val()
			};
			$.ajax({
				url: 'updateHutang.php',
				type: 'GET',
				data: datau,
				success:function(update){
					$('#hasil_update').html(update);
					window.location="hutang.php";
				}
			});
		});
	});

	$('.buka_modal_detail').click(function() {
		var id = $(this).attr('id');
		$.ajax({
			url: 'detailHutang.php',
			type: 'GET',
			data: "idhut="+id,
			success:function(detail){
				$('#modalEditDetail').html(detail);
				$('#modalEditDetail').modal('show',{backdorp:'true'});
				$(".select2").select2();
			}
		});
	});

	$('.buka_modal_angsur').click(function() {
		var id = $(this).attr('id');
		$.ajax({
			url: 'angsurHutang.php',
			type: 'GET',
			data: "idhut="+id,
			success:function(angsur){
				$('#modalEditAngsur').html(angsur);
				$('#modalEditAngsur').modal('show',{backdorp:'true'});
				$(".select2").select2();
			}
		});
	});

	$('#modalEditAngsur').mouseenter(function() {
		
	});

	$('#go').click(function() {
		var dari = $('#dari').val();
		var ke   = $('#ke').val();
		window.location="hutang.php?dari="+dari+"&ke="+ke;
	});

	$('#prin').click(function() {
		var dari = $('#dari').val();
		var ke   = $('#ke').val();
		window.location="printHutang.php?dari="+dari+"&ke="+ke;
	});

});
</script>
</body>
</html>
