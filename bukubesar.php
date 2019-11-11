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
	<title>Buku Besar | SewaUnit</title>
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
								<li><a class="menu-top-active" href="bukubesar.php"><i class="fa fa-book"></i> Buku Besar</a></li>
								<li><a href="pendapatan.php"><i class="fa fa-bar-chart-o"></i> Pendapatan Unit</a></li>
								<li><a href="petugas.php"><i class="fa fa-user"></i> Petugas</a></li>
							<?php
							}else{ ?>
								<li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
								<li><a class="menu-top-active" href="bukubesar.php"><i class="fa fa-book"></i> Buku Besar</a></li>
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
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h4>
								<i class="fa fa-book"></i> Buku Besar
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
							<table style="font-size: 13px" id="tbl_besar" class="table table-condensed table-hovered table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Id Rekening</th>
										<th>Rekening</th>
										<th>Debet</th>
										<th>Kredit</th>
										<th>Saldo</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$nomor = 1;
									$databesar = mysql_query("SELECT * FROM rekening");
									while ($rek = mysql_fetch_array($databesar)) { ?>
									<tr>
										<td><?php echo $nomor++; ?></td>
										<td><?php echo $rek[0]; ?></td>
										<td>
											<button type="button" class="btn btn-link" data-toggle="modal" data-target="#modal<?php echo $rek[0]; ?>"><?php echo $rek[1]; ?></button>

											<div class="modal fade" id="modal<?php echo $rek[0]; ?>" role="dialog">
												<div class="modal-dialog modal-lg">
													<div class="modal-content">
														<div class="modal-header">
															<h3>
																<button type="button" class="close" data-dismiss="modal">&times;</button>
																<i class="fa fa-file-text-o"></i> 
																Detail Buku Besar Rekening <?php echo $rek[1]; ?> (<?php echo $rek[0]; ?>)<br><br>
																<button type="button" id="cetak" onclick="fungsy('<?php echo $rek[0]; ?>')" class="btn btn-flat btn-info"><i class="fa fa-print"></i> Print</button>
															</h3>
														</div>
														<div class="modal-body">

<table class="table table-condensed table-bordered">
		<tr bgcolor="cyan">
			<th>#</th>
			<th>TANGGAL</th>
			<th>NO MUTASI</th>
			<th>URAIAN</th>
			<th>DEBET</th>
			<th>KREDIT</th>
			<th>SALDO</th>
		</tr>
		<?php
		$nourut = 1;
		if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
			$querybukubesar = mysql_query("SELECT * FROM buku_besar WHERE rek_debet = '$rek[0]' OR rek_kredit = '$rek[0]' ORDER BY tanggal ASC");
		}else{
			$querybukubesar = mysql_query("SELECT * FROM buku_besar WHERE rek_debet = '$rek[0]' AND tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]' OR rek_kredit = '$rek[0]' AND tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]' ORDER BY tanggal ASC");
		}
		while ($r = mysql_fetch_array($querybukubesar)) { ?>
		<tr>
			<td><?php echo $nourut++; ?></td>
			<td><?php echo date('d-m-Y',strtotime($r['tanggal'])); ?></td>
			<td><?php echo $r['no_mutasi']; ?></td>
			<td><?php echo $r['uraian']; ?></td>
			<td align="right"><?php			
				$qdebet = mysql_query("SELECT SUM(total) FROM buku_besar WHERE no_mutasi = '$r[1]' AND rek_debet = '$rek[0]' ORDER BY tanggal ASC");
				$rdebet = mysql_fetch_array($qdebet);
				echo number_format($rdebet[0],0,",",".");
			?></td>
			<td align="right"><?php
				$qkredit = mysql_query("SELECT SUM(total) FROM buku_besar WHERE no_mutasi = '$r[1]' AND rek_kredit = '$rek[0]' ORDER BY tanggal ASC");
				$rkredit = mysql_fetch_array($qkredit);
				echo number_format($rkredit[0],0,",",".");
			?></td>
			<td align="right">
				<?php
				$saldo = $rdebet[0]-$rkredit[0];
				if ($saldo < 0) {
					echo "(".number_format(abs($saldo),0,",",".").")";
				}else{
					echo number_format($saldo,0,",",".");
				}
				?>
			</td>
		</tr>
		<?php } ?>
		<!-- Begin Total -->
		<tr>
			<td colspan="4" align="center"><b style="font-size: 18px">TOTAL</b></td>
			<td align="right">
				<?php
				if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
					$qtotmod = mysql_query("SELECT SUM(total) FROM buku_besar WHERE rek_debet = '$rek[0]'");
				}else{
					$qtotmod = mysql_query("SELECT SUM(total) FROM buku_besar WHERE rek_debet = '$rek[0]' AND tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
				}
				$rtotmod = mysql_fetch_array($qtotmod);
					echo number_format($rtotmod[0],0,",",".");
				?>
			</td>
			<td align="right">
				<?php
				if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
					$qtotmodo = mysql_query("SELECT SUM(total) FROM buku_besar WHERE rek_kredit = '$rek[0]'");
				}else{
					$qtotmodo = mysql_query("SELECT SUM(total) FROM buku_besar WHERE rek_kredit = '$rek[0]' AND tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
				}
				$rtotmodo = mysql_fetch_array($qtotmodo);
					echo number_format($rtotmodo[0],0,",",".");
				?>
			</td>
			<td align="right">
				<?php
				$saldoTotal = $rtotmod[0]-$rtotmodo[0];
				if ($saldoTotal < 0) {
					echo "(".number_format(abs($saldoTotal),0,",",".").")";
				}else{
					echo number_format($saldoTotal,0,",",".");
				}
				?>
			</td>
		</tr>
		<!-- End Total -->
	</table>

														</div>
													</div>
												</div>
											</div>

										</td>
										<td align="right">
				
				<?php
				if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
					$qtotmod2 = mysql_query("SELECT SUM(total) FROM buku_besar WHERE rek_debet = '$rek[0]'");
				}else{
					$qtotmod2 = mysql_query("SELECT SUM(total) FROM buku_besar WHERE rek_debet = '$rek[0]' AND tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
				}
				$rtotmod2 = mysql_fetch_array($qtotmod2);
					echo number_format($rtotmod2[0],0,",",".");
				?>
			</td>
			<td align="right">
				<?php
				if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
					$qtotmodo2 = mysql_query("SELECT SUM(total) FROM buku_besar WHERE rek_kredit = '$rek[0]'");
				}else{
					$qtotmodo2 = mysql_query("SELECT SUM(total) FROM buku_besar WHERE rek_kredit = '$rek[0]' AND tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");					
				}
				$rtotmodo2 = mysql_fetch_array($qtotmodo2);
					echo number_format($rtotmodo2[0],0,",",".");
				?>
			</td>
			<td align="right">
				<?php
				$saldoAkhirBanget = $rtotmod2[0]-$rtotmodo2[0];
				if ($saldoAkhirBanget < 0) {
					echo "(".number_format(abs($saldoAkhirBanget),0,",",".").")";
				}else{
					echo number_format($saldoAkhirBanget,0,",",".");
				}
				?>
			</td>
									</tr>
									<?php }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
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
$(document).ready(function() {
	$('#tbl_besar').DataTable();

	$('#go').click(function() {
		var dari = $('#dari').val();
		var ke 	 = $('#ke').val();
		window.location="bukubesar.php?dari="+dari+"&ke="+ke;
	});

	$('#prin').click(function() {
		var dari = $('#dari').val();
		var ke 	 = $('#ke').val();
		window.location="printBukuBesar.php?dari="+dari+"&ke="+ke;
	});

});
	function fungsy(id_rek) {
		var dari = $('#dari').val();
		var ke 	 = $('#ke').val();
		window.location="printDetailBukuBesar.php?dari="+dari+"&ke="+ke+"&id_rek="+id_rek;
	}
</script>
</body>
</html>
