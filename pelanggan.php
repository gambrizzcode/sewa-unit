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
	<title>Pelanggan | SewaUnit</title>
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
								<li><a href="rekening.php"><i class="fa fa-ticket"></i> Rekening</a></li>
								<li><a class="menu-top-active" href="pelanggan.php"><i class="fa fa-users"></i> Pelanggan</a></li>
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
					<h3><i class="fa fa-users"></i> Tambah Pelanggan</h3>
				</div>
				<div class="modal-body">
					<label>Id Pelanggan : <?php echo substr(md5(time()),0,8); ?></label>
					<input type="hidden" id="idpel" value="<?php echo substr(md5(time()),0,8); ?>"><br>
					<label>Nama : </label>
					<input type="text" class="form-control" id="nama"><br>
					<label>Alamat : </label>
					<textarea class="form-control" id="alamat"></textarea><br>
					<label>Telepon : </label>
					<input type="text" class="form-control" id="telp">
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
								<i class="fa fa-users"></i> Master Data Pelanggan
								<button type="button" class="btn btn-success btn-flat pull-right" data-toggle="modal" data-target="#modalTambah">
									<i class="fa fa-plus"></i> Tambah Pelanggan
								</button>
								<?php
								$qt1 = mysql_query("SELECT SUM(harga) FROM transaksi");
								$rt1 = mysql_fetch_array($qt1);
								$qp1 = mysql_query("SELECT SUM(total) FROM bayar");
								$rp1 = mysql_fetch_array($qp1);
								// $qtot = mysql_query("SELECT SUM(total_piutang) FROM pelanggan");
								// $rtot = mysql_fetch_array($qtot);                               
								?>
								 | <i class="fa fa-money"></i> <i>
									Total Piutang :
									<?php echo "Rp. ".number_format($rt1[0]-$rp1[0],0,",","."); ?>
								</i>
							</h4>
						</div>
						<div class="panel-body table-responsive">
							<table style="font-size: 13px" id="tbl_pel" class="table table-condensed table-hovered table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Id Pelanggan</th>
										<th>Nama Pelanggan</th>
										<th>Alamat</th>
										<th>Telepon</th>
										<th>Total Piutang</th>
										<th>Ket</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 1;
									$datapel = mysql_query("SELECT * FROM pelanggan");
									while ($isipel = mysql_fetch_array($datapel)) { ?>
									<tr>
										<td><?php echo $no++; ?></td>
										<td><?php echo $isipel[0]; ?></td>
										<td><?php echo $isipel[1]; ?></td>
										<td><?php echo $isipel[2]; ?></td>
										<td><?php echo $isipel[3]; ?></td>
										<td><?php
											$aa = mysql_query("SELECT SUM(harga) FROM transaksi WHERE id_pelanggan = '$isipel[0]'");
											$bb = mysql_fetch_array($aa);
											$cc = mysql_query("SELECT SUM(total) FROM bayar INNER JOIN transaksi ON bayar.id_transaksi = transaksi.id_transaksi WHERE transaksi.id_pelanggan = '$isipel[0]'");
											$dd = mysql_fetch_array($cc);
											$aha = $bb[0]-$dd[0];
											if ($aha == 0) {
												echo "Rp. ".number_format($aha,0,",",".");
											}else{
												echo "<b style='color:red'>Rp. ".number_format($aha,0,",",".")."</b>";
											}
										?></td>
										<td><?php echo $isipel[5]; ?></td>
										<td>
											<button type="button" id="tombol_hapus" class="btn btn-danger btn-xs btn-flat" data-toggle="modal" data-target="#<?php echo $isipel[0]; ?>"><span class="fa fa-trash"></span></button>
											<div class="modal fade" id="<?php echo $isipel[0]; ?>" role="dialog">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<center><h3 class="modal-title">YAKIN HAPUS <i class="fa fa-question"></i></h3></center>
														</div>
														<div class="modal-body" align="center">
															<a href="hapusPel.php?id_pel=<?php echo $isipel[0]; ?>"><button type="button" class="btn btn-danger"><span class="fa fa-trash"></span> HAPUS</button></a>
															&nbsp;&nbsp;&nbsp;
															<button type="button" class="btn btn-warning" data-dismiss="modal">CANCEL</button>
														</div>
													</div>
												</div>
											</div>
											||
											<button type="button" class="btn btn-xs btn-warning btn-flat buka_modal_edit" id="<?php echo $isipel[0]; ?>"><span class="fa fa-edit"></span></button>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="modalEditPel" tabindex="-1" data-backdrop="static" data-keyboard="false" tata-attention-animation="true" aria-labelledby="myModalLabel" aria-hidden="true"></div>

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
			url: 'editPel.php',
			type: 'GET',
			data: "idpel="+id,
			success:function(edit){
				$('#modalEditPel').html(edit);
				$('#modalEditPel').modal('show',{backdorp:'true'});
			}
		});
	});
});
$(document).ready(function() {
	$('#tbl_pel').DataTable();

	$('#modalTambah').mouseenter(function() {
		$('#nama').focus(); 
	});

	$('#simpan').click(function() {
		var dataa = {
			idpel   : $('#idpel').val(),
			nama    : $('#nama').val(),
			alamat  : $('#alamat').val(),
			telp    : $('#telp').val()
		};
		$.ajax({
			url: 'simpanPel.php',
			type: 'GET',
			data: dataa,
			success:function(simpan){
				$('#hasil_simpan').html(simpan);
				window.location="pelanggan.php";
			}
		});
	});

	$('.buka_modal_edit').click(function() {
		var id = $(this).attr('id');
		$.ajax({
			url: 'editPel.php',
			type: 'GET',
			data: "idpel="+id,
			success:function(edit){
				$('#modalEditPel').html(edit);
				$('#modalEditPel').modal('show',{backdorp:'true'});
			}
		});
	});

	$('#modalEditPel').mouseenter(function() {
		$('#update').click(function() {
			var datau = {
				newidpel    : $('#newidpel').val(),
				newnama     : $('#newnama').val(),
				newalamat   : $('#newalamat').val(),
				newtelp     : $('#newtelp').val()
			};
			$.ajax({
				url: 'updatePel.php',
				type: 'GET',
				data: datau,
				success:function(update){
					$('#hasil_update').html(update);
					window.location="pelanggan.php";
				}
			});
		});
	});
});
</script>
</body>
</html>
