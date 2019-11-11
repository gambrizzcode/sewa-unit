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
	<title>Jurnal Umum | SewaUnit</title>
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
								<li><a class="menu-top-active" href="jurnalumum.php"><i class="fa fa-file-text-o"></i> Jurnal Umum</a></li>
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

	<div class="modal fade" id="modalTambah" data-backdrop="static" data-keyboard="false" tata-attention-animation="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3><i class="fa fa-file-text"></i> Pengisian Jurnal Umum</h3>
				</div>
				<?php
				$qnom = mysql_num_rows(mysql_query("SELECT * FROM jurnal"));
				$nomor = $qnom+1;
				?>
				<div class="modal-body">
					<?php
					$bulan = array(1=>"I","II","III","IV","V","VI","VII","VIII","IX","X","XI","XII");
					?>
					<label>No Mutasi : <?php echo "JM-".$bulan[date('n')]."-".date('Y')."-".$nomor; ?></label>
					<input type="hidden" id="nomutasi" value="<?php echo 'JM-'.$bulan[date('n')].'-'.date('Y').'-'.$nomor; ?>"><br>
					<label>Tanggal : </label>
					<input type="date" class="form-control" id="tanggal" value="<?php echo date('Y-m-d'); ?>">
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
					<label>Nilai Rupiah Mutasi : </label>
					<input type="text" class="form-control" id="total">
					<label>Uraian : </label>
					<textarea class="form-control" id="uraian"></textarea>
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
								<i class="fa fa-file-text"></i> Data Jurnal Umum
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
									<i class="fa fa-plus"></i> Tambah Jurnal
								</button>
								</div>
							</div>
						</div>
						<div class="panel-body table-responsive">
							<table style="font-size: 13px" id="tbl_jurnal" class="table table-condensed table-hovered table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Tanggal</th>
										<th>No Mutasi</th>
										<th>Uraian</th>
										<th>Rek. Debet</th>
										<th>Rek. Kredit</th>
										<th>Mutasi</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 1;
									if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
										$datajur = mysql_query("SELECT * FROM jurnal ORDER BY tanggal");
									}else{
										$datajur = mysql_query("SELECT * FROM jurnal WHERE tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]' ORDER BY tanggal");
									}
									while ($isijur = mysql_fetch_array($datajur)) { ?>
									<tr>
										<td><?php echo $no++; ?></td>
										<td><?php echo date('d-m-Y',strtotime($isijur[1])); ?></td>
										<td><?php echo $isijur[0]; ?></td>
										<td><?php echo $isijur[5]; ?></td>
										<td><?php
										$rekdeb = mysql_query("SELECT nama_rek FROM rekening WHERE id_rek = '$isijur[2]'");
										$vrekdeb = mysql_fetch_array($rekdeb);
										echo $vrekdeb[0];
										?></td>
										<td><?php
										$rekkre = mysql_query("SELECT nama_rek FROM rekening WHERE id_rek = '$isijur[3]'");
										$vrekkre = mysql_fetch_array($rekkre);
										echo $vrekkre[0];
										?></td>
										<td><?php echo "Rp. ".number_format($isijur[4],0,",","."); ?></td>
										<td>
											<button type="button" class="btn btn-xs btn-warning btn-flat buka_modal_edit" id="<?php echo $isijur[0]; ?>"><span class="fa fa-edit"></span> EDIT</button>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="modalEditJurnal" data-backdrop="static" data-keyboard="false" tata-attention-animation="true" aria-labelledby="myModalLabel" aria-hidden="true"></div>
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
<script src="assets/select2/select2.full.min.js"></script>
<script>
$(function(){
	$('.buka_modal_edit').click(function() {
		var id = $(this).attr('id');
		$.ajax({
			url: 'editJurnal.php',
			type: 'GET',
			data: "idjur="+id,
			success:function(edit){
				$('#modalEditJurnal').html(edit);
				$('#modalEditJurnal').modal('show',{backdorp:'true'});
				$(".select2").select2();
			}
		});
	});
});
$(document).ready(function() {
	$(".select2").select2();
	$('#tbl_jurnal').DataTable();

	$('#simpan').click(function() {
		var dataa = {
			nomutasi    : $('#nomutasi').val(),
			tanggal     : $('#tanggal').val(),
			rek_deb     : $('#rek_deb').val(),
			rek_kre     : $('#rek_kre').val(),
			total       : $('#total').val(),
			uraian      : $('#uraian').val()
		};
		$.ajax({
			url: 'simpanJurnal.php',
			type: 'GET',
			data: dataa,
			success:function(simpan){
				$('#hasil_simpan').html(simpan);
				window.location="jurnalumum.php";
			}
		});
	});

	$('.buka_modal_edit').click(function() {
		var id = $(this).attr('id');
		$.ajax({
			url: 'editJurnal.php',
			type: 'GET',
			data: "idjur="+id,
			success:function(edit){
				$('#modalEditJurnal').html(edit);
				$('#modalEditJurnal').modal('show',{backdorp:'true'});
				$(".select2").select2();
			}
		});
	});

	$('#modalEditJurnal').mouseenter(function() {
		$('#update').click(function() {
			var datau = {
				newnomutasi    : $('#newnomutasi').val(),
				newtanggal     : $('#newtanggal').val(),
				newrek_deb     : $('#newrek_deb').val(),
				newrek_kre     : $('#newrek_kre').val(),
				newtotal       : $('#newtotal').val(),
				newuraian      : $('#newuraian').val()
			};
			$.ajax({
				url: 'updateJurnal.php',
				type: 'GET',
				data: datau,
				success:function(update){
					$('#hasil_update').html(update);
					window.location="jurnalumum.php";
				}
			});
		});
	});

	$('#go').click(function() {
		var dari = $('#dari').val();
		var ke   = $('#ke').val();
		window.location="jurnalumum.php?dari="+dari+"&ke="+ke;
	});

	$('#prin').click(function() {
		var dari = $('#dari').val();
		var ke   = $('#ke').val();
		window.location="printJurnal.php?dari="+dari+"&ke="+ke;
	});
});
</script>
</body>
</html>