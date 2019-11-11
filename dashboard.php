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
	<title>Dashboard | SewaUnit</title>
	<link rel="icon" href="assets/favicon.png">
	<link href="assets/css/bootstrap.css" rel="stylesheet" />
	<link href="assets/css/font-awesome.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet" />
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
								<li><a class="menu-top-active" href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
								<li><a href="transaksi.php"><i class="fa fa-money"></i> Transaksi</a></li>
								<li><a href="unit.php"><i class="fa fa-suitcase"></i> Unit</a></li>
								<li><a href="rekening.php"><i class="fa fa-ticket"></i> Rekening</a></li>
								<li><a href="pelanggan.php"><i class="fa fa-users"></i> Pelanggan</a></li>
								<li><a href="jurnalumum.php"><i class="fa fa-file-text-o"></i> Jurnal Umum</a></li>
								<li><a href="hutang.php"><i class="fa fa-minus-square-o"></i> Hutang</a></li>
								<li><a href="bukubesar.php"><i class="fa fa-book"></i> Buku Besar</a></li>
								<li><a href="pendapatan.php"><i class="fa fa-bar-chart-o"></i> Pendapatan Unit</a></li>
								<li><a href="petugas.php"><i class="fa fa-user"></i> Petugas</a></li>
							<?php
							}else{ ?>
								<li><a class="menu-top-active" href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
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

	<div class="content-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-sm-3 col-xs-6">
					<div class="dashboard-div-wrapper bk-clr-one">
						<i  class="fa fa-shopping-cart dashboard-div-icon" ></i>
						<h4>Jumlah Transaksi Hari Ini</h4>
						<h3><?php $krj->tranH(); ?></h3>
					</div>
				</div>
				 <div class="col-md-3 col-sm-3 col-xs-6">
					<div class="dashboard-div-wrapper bk-clr-three">
						<i  class="fa fa-download dashboard-div-icon" ></i>
						<h4>Pendapatan Kotor Hari Ini</h4>
						<h3><?php $krj->kotorH(); ?></h3>
					</div>
				</div>
				 <div class="col-md-3 col-sm-3 col-xs-6">
					<div class="dashboard-div-wrapper bk-clr-two">
						<i  class="fa fa-upload dashboard-div-icon" ></i>
						<h4>Pengeluaran Hari Ini</h4>
						<h3><?php $krj->keluarH(); ?></h3>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6">
					<div class="dashboard-div-wrapper bk-clr-four">
						<i  class="fa fa-money dashboard-div-icon" ></i>
						<h4>Pendapatan Bersih Hari Ini</h4>
						<h3><?php $krj->bersihH(); ?></h3>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
									<?php
									$no = 1;
									$databesar = mysql_query("SELECT * FROM rekening");
									while ($rek = mysql_fetch_array($databesar)) {
									$qtotmod2  = mysql_query("SELECT SUM(total) FROM buku_besar WHERE rek_debet = '$rek[0]'");
									$rtotmod2  = mysql_fetch_array($qtotmod2);
									$qtotmodo2 = mysql_query("SELECT SUM(total) FROM buku_besar WHERE rek_kredit = '$rek[0]'");
									$rtotmodo2 = mysql_fetch_array($qtotmodo2);
									?>
									<div class="col-md-3 col-sm-3 col-xs-6">
										<div class="dashboard-div-wrapper" style="background: rgba(100,100,200,0.9);">
											<i  class="fa fa-money dashboard-div-icon"></i>
											<h4><?php echo $rek[1]; ?></h4>
											<?php
											$saldoAkhirBanget = $rtotmod2[0]-$rtotmodo2[0];
											if ($saldoAkhirBanget < 0) {
												echo "(".number_format(abs($saldoAkhirBanget),0,",",".").")";
											}else{
												echo number_format($saldoAkhirBanget,0,",",".");
											}
											?>
										</div>
									</div>
									<?php } ?>
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
</body>
</html>