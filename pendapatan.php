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
	<title>Pendapatan Unit | SewaUnit</title>
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
                                <li><a href="pelanggan.php"><i class="fa fa-users"></i> Pelanggan</a></li>
                                <li><a href="jurnalumum.php"><i class="fa fa-file-text-o"></i> Jurnal Umum</a></li>
                                <li><a href="hutang.php"><i class="fa fa-minus-square-o"></i> Hutang</a></li>
                                <li><a href="bukubesar.php"><i class="fa fa-book"></i> Buku Besar</a></li>
                                <li><a class="menu-top-active" href="pendapatan.php"><i class="fa fa-bar-chart-o"></i> Pendapatan Unit</a></li>
                                <li><a href="petugas.php"><i class="fa fa-user"></i> Petugas</a></li>
                            <?php
                            }else{ ?>
                                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                                <li><a href="bukubesar.php"><i class="fa fa-book"></i> Buku Besar</a></li>
                                <li><a class="menu-top-active" href="pendapatan.php"><i class="fa fa-bar-chart-o"></i> Pendapatan Unit</a></li>
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

	<div class="content-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h4>
								<i class="fa fa-bar-chart-o"></i> Pendapatan Unit
							</h4>
							<div class="row" align="right">
								<div class="col-md-12 form-inline">
									Dari Tanggal : <input type="date" class="form-control" id="dari" <?php if(!$_REQUEST['dari']){}else{echo "value='".$_REQUEST['dari']."'";} ?>>
									&nbsp;
									Sampai Tanggal : <input type="date" class="form-control" id="ke" <?php if(!$_REQUEST['ke']){}else{echo "value='".$_REQUEST['ke']."'";} ?>>
									<button type="button" class="btn btn-flat btn-warning" id="go"><i class="fa fa-search"></i> GO !!</button>
									&nbsp;
									<button type="button" class="btn btn-flat btn-info" id="prin"><i class="fa fa-print"></i> PRINT</button>
								</div>
							</div>
						</div>
						<div class="panel-body table-responsive">
							<table style="font-size: 12px" id="tbl_unit" class="table table-condensed table-hovered table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Id Unit</th>
										<th>Nama Unit</th>
										<th>Harga Sewa</th>
										<th>Dibayar</th>
										<th>Piutang</th>
										<th>Biaya Operasional Sewa</th>
										<th>Pendapatan Sewa (Berjalan)</th>
										<th>Pendapatan Saat Ini</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 1;
									$dataunit = mysql_query("SELECT * FROM unit");
									while ($isiunit = mysql_fetch_array($dataunit)) { ?>
									<tr>
										<td><?php echo $no++; ?></td>
										<td><?php echo $isiunit[0]; ?></td><!-- id unit -->
										<td><?php echo $isiunit[1]; ?></td><!-- nama -->
										<td><?php
										if (!$_REQUEST['dari'] || !$_REQUEST['ke']) {
											$qdapat = mysql_query("SELECT SUM(harga) FROM transaksi WHERE id_unit = '$isiunit[0]'");
										}else{
											$qdapat = mysql_query("SELECT SUM(harga) FROM transaksi WHERE id_unit = '$isiunit[0]' AND tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
										}
										$rdapat = mysql_fetch_array($qdapat);
										echo "Rp. ".number_format($rdapat[0],0,",",".");
										?></td><!-- harga sewa -->
										<td><?php
										if (!$_REQUEST['dari'] || !$_REQUEST['ke']) {
											$qbayar = mysql_query("SELECT SUM(total) FROM transaksi INNER JOIN bayar ON transaksi.id_transaksi = bayar.id_transaksi WHERE transaksi.id_unit = '$isiunit[0]'");
										}else{
											$qbayar = mysql_query("SELECT SUM(total) FROM transaksi INNER JOIN bayar ON transaksi.id_transaksi = bayar.id_transaksi WHERE transaksi.id_unit = '$isiunit[0]' AND tgl_bayar BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
										}
										$rbayar = mysql_fetch_array($qbayar);
										echo "Rp. ".number_format($rbayar[0],0,",",".");
										?>										
										</td><!-- dibayar -->
										<td><?php
										echo "Rp. ".number_format($rdapat[0]-$rbayar[0],0,",",".");
										?>
										</td><!-- piutang -->
										<td><?php
										if (!$_REQUEST['dari'] || !$_REQUEST['ke']) {
											$qluar = mysql_query("SELECT SUM(total) FROM transaksi INNER JOIN pengeluaran ON transaksi.id_transaksi = pengeluaran.id_transaksi WHERE transaksi.id_unit = '$isiunit[0]'");
										}else{
											$qluar = mysql_query("SELECT SUM(total) FROM transaksi INNER JOIN pengeluaran ON transaksi.id_transaksi = pengeluaran.id_transaksi WHERE transaksi.id_unit = '$isiunit[0]' AND tgl_pengeluaran BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
										}
										$uhuy = mysql_fetch_array($qluar);
										echo "Rp. ".number_format($uhuy[0],0,",",".");
										?></td><!-- biaya ops -->
										<td><?php
										echo "<b>Rp. ".number_format($rdapat[0]-$uhuy[0],0,",",".")."</b>";
										?></td><!-- pendapatan berjalan -->
										<td><?php
										echo "<b>Rp. ".number_format($rbayar[0]-$uhuy[0],0,",",".")."</b>";
										?></td><!-- pendapatan saat ini -->
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					
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
<script>
$(document).ready(function() {
	$('#tbl_unit').DataTable();

	$('#go').click(function() {
		var dari = $('#dari').val();
		var ke 	 = $('#ke').val();
		window.location="pendapatan.php?dari="+dari+"&ke="+ke;
	});

	$('#prin').click(function() {
		var dari = $('#dari').val();
		var ke 	 = $('#ke').val();
		window.location="printPendapatan.php?dari="+dari+"&ke="+ke;
	});
});
</script>
</body>
</html>
