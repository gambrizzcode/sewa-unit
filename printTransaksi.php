<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Data Transaksi</title>
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
	window.location="transaksi.php";
}
</script>
<body onload="prin()">
	<center>
		<b style="font-size: 20px">Nama Usaha</b><br>
		<b>Tagline Usaha</b><br>
		Jl. Raya Jember, Telp. 0331, Hp. 081<hr>
		<?php
		if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") { ?>
		<h4>
			Data Transaksi Semua Periode
			<?php
			if (!$_REQUEST['unit'] || $_REQUEST['unit'] == "") {
				echo " Semua Unit";
			}else{
				$namaunit = mysql_fetch_array(mysql_query("SELECT nama_unit FROM unit WHERE id_unit = '$_REQUEST[unit]'"));
				echo ", Khusus Unit : ".$namaunit[0];
			}
			?>
		</h4>
		<?php }else{ ?>
		<h4>
			Data Transaksi Periode <?php echo date('d-m-Y',strtotime($_REQUEST['dari'])); ?> Sampai <?php echo date('d-m-Y',strtotime($_REQUEST['ke'])); ?>
			<?php
			if (!$_REQUEST['unit'] || $_REQUEST['unit'] == "") {
				echo " Semua Unit";
			}else{
				$namaunit = mysql_fetch_array(mysql_query("SELECT nama_unit FROM unit WHERE id_unit = '$_REQUEST[unit]'"));
				echo ", Khusus Unit : ".$namaunit[0];
			}
			?>
		</h4>
		<?php } ?>
	</center>
		<table class="table table-condensed table-bordered">
			<thead>
				<tr bgcolor="cyan">
					<th>#</th>
					<th>Id Transaksi</th>
					<th>Tanggal</th>
					<th>Pelanggan</th>
					<th>Unit</th>
					<th>Ket</th>
					<th>Harga Sewa</th>
					<th>Dibayar</th>
					<th>Sisa Piutang</th>
					<th>Pengeluaran</th>
					<th>Pendapatan Sewa (Berjalan)</th>
					<th>Pendapatan Saat Ini</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 1;
				if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
					if (!$_REQUEST['unit'] || $_REQUEST['unit'] == "") {
						$datatran = mysql_query("SELECT * FROM transaksi INNER JOIN pelanggan ON transaksi.id_pelanggan = pelanggan.id_pelanggan INNER JOIN unit ON transaksi.id_unit = unit.id_unit ORDER BY transaksi.tanggal");
					}else{
						$datatran = mysql_query("SELECT * FROM transaksi INNER JOIN pelanggan ON transaksi.id_pelanggan = pelanggan.id_pelanggan INNER JOIN unit ON transaksi.id_unit = unit.id_unit WHERE unit.id_unit = '$_REQUEST[unit]' ORDER BY transaksi.tanggal");
					}
				}else{
					if (!$_REQUEST['unit'] || $_REQUEST['unit'] == "") {
						$datatran = mysql_query("SELECT * FROM transaksi INNER JOIN pelanggan ON transaksi.id_pelanggan = pelanggan.id_pelanggan INNER JOIN unit ON transaksi.id_unit = unit.id_unit WHERE tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]' ORDER BY transaksi.tanggal");
					}else{
						$datatran = mysql_query("SELECT * FROM transaksi INNER JOIN pelanggan ON transaksi.id_pelanggan = pelanggan.id_pelanggan INNER JOIN unit ON transaksi.id_unit = unit.id_unit WHERE tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]' AND unit.id_unit = '$_REQUEST[unit]' ORDER BY transaksi.tanggal");
					}
				}
				while ($isitran = mysql_fetch_array($datatran)) {
					$qbayaro = mysql_query("SELECT SUM(total) FROM bayar WHERE id_transaksi = '$isitran[0]'");
					$rbayaro = mysql_fetch_array($qbayaro);
				if ($isitran['harga']-$rbayaro[0] == "0") {
					$warna = "green";
				}else{
					$warna = "red";
				}
				?>
				<tr>
					<td><?php echo $no++; ?></td>
					<td><?php echo $isitran['id_transaksi']; ?></td>
					<td><?php echo date('d-m-Y',strtotime($isitran['tanggal'])); ?></td>
					<td><?php echo $isitran['nama_pelanggan']; ?></td>
					<td><?php echo $isitran['nama_unit']; ?></td>
					<td><?php echo $isitran[11]; ?></td>
					<td><?php echo "<b>Rp. ".number_format($isitran['harga'],0,",",".")."</b>"; ?></td>
					<td><?php
					$qtotdibayar = mysql_query("SELECT SUM(total) FROM bayar WHERE id_transaksi = '$isitran[0]'");
					$rtotdibayar = mysql_fetch_array($qtotdibayar);
					echo "<b>Rp. ".number_format($rtotdibayar[0],0,",",".")."</b>";
					// echo "<b>Rp. ".number_format($isitran['dibayar'],0,",",".")."</b>";
					?></td>
					<td><?php echo "<b style='color:".$warna."'>Rp. ".number_format($isitran['harga']-$rtotdibayar[0],0,",",".")."</b>"; ?></td>
					<td><?php
					$qtotdiluar = mysql_query("SELECT SUM(total) FROM pengeluaran WHERE id_transaksi = '$isitran[0]'");
					$rtotdiluar = mysql_fetch_array($qtotdiluar);
					echo "<b>Rp. ".number_format($rtotdiluar[0],0,",",".")."</b>";
					// echo "<b>Rp. ".number_format($isitran['pengeluaran'],0,",",".")."</b>";
					?></td>
					<td><?php echo "<b>Rp. ".number_format($isitran['harga']-$rtotdiluar[0],0,",",".")."</b>"; ?></td>					
					<td><?php echo "<b>Rp. ".number_format($rtotdibayar[0]-$rtotdiluar[0],0,",",".")."</b>"; ?></td>					
				</tr>
				<?php } ?>
				<tr>
					<td colspan="6" align="center"><label>TOTAL</label></td>
					<td>
						<?php
						if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
							if (!$_REQUEST['unit'] || $_REQUEST['unit'] == "") {
								$qtotharga = mysql_query("SELECT SUM(harga) FROM transaksi");
							}else{
								$qtotharga = mysql_query("SELECT SUM(harga) FROM transaksi WHERE id_unit = '$_REQUEST[unit]'");
							}
						}else{
							if (!$_REQUEST['unit'] || $_REQUEST['unit'] == "") {
								$qtotharga = mysql_query("SELECT SUM(harga) FROM transaksi WHERE tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
							}else{
								$qtotharga = mysql_query("SELECT SUM(harga) FROM transaksi WHERE tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]' AND id_unit = '$_REQUEST[unit]'");
							}
						}
						$rtotharga = mysql_fetch_array($qtotharga);
						echo "<b>Rp. ".number_format($rtotharga[0],0,",",".")."</b>";
						?>
					</td>
					<td>
						<?php
						if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
							if (!$_REQUEST['unit'] || $_REQUEST['unit'] == "") {
								$qtotbayar = mysql_query("SELECT SUM(total) FROM bayar");
							}else{
								$qtotbayar = mysql_query("SELECT SUM(bayar.total) FROM bayar INNER JOIN transaksi ON bayar.id_transaksi = transaksi.id_transaksi WHERE transaksi.id_unit = '$_REQUEST[unit]'");
							}
						}else{
							if (!$_REQUEST['unit'] || $_REQUEST['unit'] == "") {
								$qtotbayar = mysql_query("SELECT SUM(total) FROM bayar WHERE tgl_bayar BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
							}else{
								$qtotbayar = mysql_query("SELECT SUM(bayar.total) FROM bayar INNER JOIN transaksi ON bayar.id_transaksi = transaksi.id_transaksi WHERE bayar.tgl_bayar BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]' AND transaksi.id_unit = '$_REQUEST[unit]'");
							}
						}
						$rtotbayar = mysql_fetch_array($qtotbayar);
						echo "<b>Rp. ".number_format($rtotbayar[0],0,",",".")."</b>";
						?>
					</td>
					<td>
						<?php echo "<b>Rp. ".number_format($rtotharga[0]-$rtotbayar[0],0,",",".")."</b>"; ?>
					</td>
					<td>
						<?php
						if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
							if (!$_REQUEST['unit'] || $_REQUEST['unit'] == "") {
								$qtotluar = mysql_query("SELECT SUM(total) FROM pengeluaran");
							}else{
								$qtotluar = mysql_query("SELECT SUM(pengeluaran.total) FROM pengeluaran INNER JOIN transaksi ON pengeluaran.id_transaksi = transaksi.id_transaksi WHERE transaksi.id_unit = '$_REQUEST[unit]'");
							}
						}else{
							if (!$_REQUEST['unit'] || $_REQUEST['unit'] == "") {
								$qtotluar = mysql_query("SELECT SUM(total) FROM pengeluaran WHERE tgl_pengeluaran BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
							}else{
								$qtotluar = mysql_query("SELECT SUM(pengeluaran.total) FROM pengeluaran INNER JOIN transaksi ON pengeluaran.id_transaksi = transaksi.id_transaksi WHERE pengeluaran.tgl_pengeluaran BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]' AND transaksi.id_unit = '$_REQUEST[unit]'");
							}
						}
						$rtotluar = mysql_fetch_array($qtotluar);
						echo "<b>Rp. ".number_format($rtotluar[0],0,",",".")."</b>";
						?>
					</td>
					<td>
						<?php echo "<b>Rp. ".number_format($rtotharga[0]-$rtotluar[0],0,",",".")."</b>"; ?>
					</td>
					<td>
						<?php echo "<b>Rp. ".number_format($rtotbayar[0]-$rtotluar[0],0,",",".")."</b>"; ?>
					</td>
				</tr>
			</tbody>
		</table>
</body>
</html>