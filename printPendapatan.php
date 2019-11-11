<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

// header("Content-type:application");
// header("Content-Disposition:attachment; filename=Data Pendapatan.pdf");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Laporan Pendapatan Per Unit</title>
	<link rel="icon" href="assets/favicon.png">
	<link href="assets/css/bootstrap.css" rel="stylesheet" />
	<link href="assets/css/font-awesome.css" rel="stylesheet" />
</head>
<style type="text/css">
body{
	font-size: 11px;
}
</style>
<script>
function prin() {
	window.print();
	window.location="pendapatan.php";
}
</script>
<body onload="prin()">
	<center>
		<b style="font-size: 20px">Nama Usaha</b><br>
		<b>Tagline Usaha</b><br>
		Jl. Raya Jember, Telp. 0331, Hp. 081<hr>
		<?php
		if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") { ?>
		<h4>Laporan Pendapatan Per Unit Semua Periode</h4>	
		<?php }else{ ?>
		<h4>Laporan Pendapatan Per Unit Periode <?php echo $_REQUEST['dari']; ?> Sampai <?php echo $_REQUEST['ke']; ?></h4>
		<?php } ?>
	</center>
	<table class="table table-condensed table-bordered">
		<thead>
			<tr bgcolor="grey">
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
			<tr>
				<td colspan="3" align="center"><b>TOTAL</b></td>
				<td>
					<?php
					if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
						$qtots = mysql_query("SELECT SUM(harga) FROM transaksi");
						$rtots = mysql_fetch_array($qtots);
						echo "<b>Rp. ".number_format($rtots[0],0,",",".")."</b>";
					}else{
						$qtots = mysql_query("SELECT SUM(harga) FROM transaksi WHERE tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
						$rtots = mysql_fetch_array($qtots);
						echo "<b>Rp. ".number_format($rtots[0],0,",",".")."</b>";
					}
					?>
				</td>
				<td><?php
				if (!$_REQUEST['dari'] || !$_REQUEST['ke']) {
					$qbayars = mysql_query("SELECT SUM(total) FROM transaksi INNER JOIN bayar ON transaksi.id_transaksi = bayar.id_transaksi");
				}else{
					$qbayars = mysql_query("SELECT SUM(total) FROM transaksi INNER JOIN bayar ON transaksi.id_transaksi = bayar.id_transaksi WHERE tgl_bayar BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
				}
				$rbayars = mysql_fetch_array($qbayars);
				echo "Rp. ".number_format($rbayars[0],0,",",".");
				?>										
				</td><!-- dibayar -->
				<td><?php
				echo "Rp. ".number_format($rtots[0]-$rbayars[0],0,",",".");
				?>
				</td><!-- piutang -->
				<td>
					<?php
					if (!$_REQUEST['dari'] || !$_REQUEST['ke']) {
						$qluar = mysql_query("SELECT SUM(total) FROM transaksi INNER JOIN pengeluaran ON transaksi.id_transaksi = pengeluaran.id_transaksi");
						$uhuy = mysql_fetch_array($qluar);
						echo "Rp. ".number_format($uhuy[0],0,",",".");
						}else{
						$qluar = mysql_query("SELECT SUM(total) FROM transaksi INNER JOIN pengeluaran ON transaksi.id_transaksi = pengeluaran.id_transaksi WHERE tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
						$uhuy = mysql_fetch_array($qluar);
						echo "Rp. ".number_format($uhuy[0],0,",",".");
					}
					?>
				</td>
				<td>
					<?php
					echo "<b>Rp. ".number_format($rtots[0]-$uhuy[0],0,",",".")."</b>";
					?>
				</td>
				<td>
					<?php
					echo "<b>Rp. ".number_format($rbayars[0]-$uhuy[0],0,",",".")."</b>";
					?>
				</td>
			</tr>
		</tbody>
	</table>
</body>
</html>
