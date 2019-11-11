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
	<title>Rekening | SewaUnit</title>
	<link rel="icon" href="assets/favicon.png">
	<link href="assets/css/bootstrap.css" rel="stylesheet" />
	<link href="assets/css/font-awesome.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet" />
	<link href="datatables/dataTables.bootstrap.css" rel="stylesheet" />
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
								<li><a class="menu-top-active" href="rekening.php"><i class="fa fa-ticket"></i> Rekening</a></li>
								<li><a href="pelanggan.php"><i class="fa fa-users"></i> Pelanggan</a></li>
								<li><a href="jurnalumum.php"><i class="fa fa-file-text-o"></i> Jurnal Umum</a></li>
								<li><a href="hutang.php"><i class="fa fa-minus-square-o"></i> Hutang</a></li>
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

	<div class="modal fade" id="modalTambah" tabindex="-1" data-backdrop="static" data-keyboard="false" tata-attention-animation="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3><i class="fa fa-suitcase"></i> Tambah Rekening</h3>
				</div>
				<div class="modal-body">
					<label>Id Rekening : <?php echo substr(md5(time()),0,8); ?></label>
					<input type="hidden" id="idrek" value="<?php echo substr(md5(time()),0,8); ?>"><br>
					<label>Nama : </label>
					<textarea class="form-control" id="nama"></textarea>
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
								<i class="fa fa-ticket"></i> Master Data Rekening
								<button type="button" class="btn btn-success btn-flat pull-right" data-toggle="modal" data-target="#modalTambah">
									<i class="fa fa-plus"></i> Tambah Rekening
								</button>
							</h4>
						</div>
						<div class="panel-body table-responsive">
							<table style="font-size: 13px" id="tbl_rek" class="table table-condensed table-hovered table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Id Rekening</th>
										<th>Nama Rekening</th>
										<th>Ket</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 1;
									$datarek = mysql_query("SELECT * FROM rekening");
									while ($isirek = mysql_fetch_array($datarek)) { ?>
									<tr>
										<td><?php echo $no++; ?></td>
										<td><?php echo $isirek[0]; ?></td>
										<td><?php echo $isirek[1]; ?></td>
										<td><?php echo $isirek[2]; ?></td>
										<td>
											<button type="button" id="tombol_hapus" class="btn btn-danger btn-xs btn-flat" data-toggle="modal" data-target="#<?php echo $isirek[0]; ?>"><span class="fa fa-trash"></span></button>
											<div class="modal fade" id="<?php echo $isirek[0]; ?>" role="dialog">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<center><h3 class="modal-title">YAKIN HAPUS <i class="fa fa-question"></i></h3></center>
														</div>
														<div class="modal-body" align="center">
															<a href="hapusRek.php?id_rek=<?php echo $isirek[0]; ?>"><button type="button" class="btn btn-danger"><span class="fa fa-trash"></span> HAPUS</button></a>
															&nbsp;&nbsp;&nbsp;
															<button type="button" class="btn btn-warning" data-dismiss="modal">CANCEL</button>
														</div>
													</div>
												</div>
											</div>
											||
											<button type="button" class="btn btn-xs btn-warning btn-flat buka_modal_edit" id="<?php echo $isirek[0]; ?>"><span class="fa fa-edit"></span></button>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="modalEditRek" tabindex="-1" data-backdrop="static" data-keyboard="false" tata-attention-animation="true" aria-labelledby="myModalLabel" aria-hidden="true"></div>

			<!-- <div class="row">
				<div class="col-md-12">
					
				</div>
			</div> -->
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
<script>
$(function(){
	$('.buka_modal_edit').click(function() {
		var id = $(this).attr('id');
		$.ajax({
			url: 'editRek.php',
			type: 'GET',
			data: "idrek="+id,
			success:function(edit){
				$('#modalEditRek').html(edit);
				$('#modalEditRek').modal('show',{backdorp:'true'});
			}
		});
	});
});
$(document).ready(function() {
	$('#tbl_rek').DataTable();

	$('#modalTambah').mouseenter(function() {
		$('#nama').focus(); 
	});

	$('#simpan').click(function() {
		var dataa = {
			idrek  : $('#idrek').val(),
			nama    : $('#nama').val()
		};
		$.ajax({
			url: 'simpanRek.php',
			type: 'GET',
			data: dataa,
			success:function(simpan){
				$('#hasil_simpan').html(simpan);
				window.location="rekening.php";
			}
		});
	});

	$('.buka_modal_edit').click(function() {
		var id = $(this).attr('id');
		$.ajax({
			url: 'editRek.php',
			type: 'GET',
			data: "idrek="+id,
			success:function(edit){
				$('#modalEditRek').html(edit);
				$('#modalEditRek').modal('show',{backdorp:'true'});
			}
		});
	});

	$('#modalEditRek').mouseenter(function() {
		$('#update').click(function() {
			var datau = {
				newidrek    : $('#newidrek').val(),
				newnama     : $('#newnama').val()
			};
			$.ajax({
				url: 'updateRek.php',
				type: 'GET',
				data: datau,
				success:function(update){
					$('#hasil_update').html(update);
					window.location="rekening.php";
				}
			});
		});
	});
});
</script>
</body>
</html>
