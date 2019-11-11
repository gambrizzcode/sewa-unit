<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$data = mysql_query("SELECT * FROM transaksi INNER JOIN bayar ON transaksi.id_transaksi = bayar.id_transaksi INNER JOIN pelanggan ON transaksi.id_pelanggan = pelanggan.id_pelanggan INNER JOIN unit ON transaksi.id_unit = unit.id_unit INNER JOIN akun ON transaksi.id_akun = akun.id_akun WHERE transaksi.id_transaksi = '$_REQUEST[idtran]'");
$isi = mysql_fetch_array($data);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Laporan Transaksi <?php echo $isi[0]; ?></title>
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
	</center>
	<h4 style="margin-left: 10px"><b>Data Persewaan : </b></h4>
	<table style="margin-left: 50px">
		<tr>
			<td align="right">Nomor Transaksi : </td>
			<td>&nbsp;<?php echo $isi[0]; ?></td>
		</tr>
		<tr>
			<td align="right">Tanggal Transaksi : </td>
			<td>&nbsp;<?php echo date('d-m-Y',strtotime($isi[1])); ?></td>
		</tr>
		<tr>
			<td align="right">Nama Pelanggan : </td>
			<td>&nbsp;<?php echo $isi['nama_pelanggan']; ?></td>
		</tr>
		<tr>
			<td align="right">Alamat / Telp : </td>
			<td>&nbsp;<?php echo $isi['alamat']." / ".$isi['telp']; ?></td>
		</tr>
		<tr>
			<td align="right">Pilihan Unit : </td>
			<td>&nbsp;<?php echo $isi['nama_unit']; ?></td>
		</tr>
		<tr>
			<td align="right">Tanggal Pelaksanaan : </td>
			<td>&nbsp;<?php echo $tgl = date('d-m-Y',strtotime($isi['tgl_pelaksanaan'])); ?></td>
		</tr>
		<tr>
			<td align="right">Lama Sewa : </td>
			<td>&nbsp;<?php echo $isi['lama']; ?> Hari</td>
		</tr>
		<tr>
			<td align="right">Harga Sewa : </td>
			<td>&nbsp;<b><?php echo "Rp. ".number_format($isi['harga'],0,",","."); ?></b></td>
		</tr>
		<tr>
			<td align="right">Keterangan / Uraian Sewa : </td>
			<td>&nbsp;<?php if($isi[11] == ""){echo "-";}else{echo $isi[11];}; ?></td>
		</tr>
	</table>
	<hr>
	<h4 style="margin-left: 10px"><b>Data Pembayaran : </b></h4>
	<table class="table table-condensed table-bordered">
		<tr bgcolor="grey">
			<th>Tanggal Penerimaan</th>
			<th>Rekening</th>
			<th>Keterangan</th>
			<th>Nominal</th>
		</tr>
		<?php
		$qbayar = mysql_query("SELECT * FROM bayar INNER JOIN rekening ON bayar.rek_debet = rekening.id_rek WHERE bayar.id_transaksi = '$_GET[idtran]'");
		while ($rbayar = mysql_fetch_array($qbayar)) {
		?>
		<tr>
			<td><?php echo date('d-m-Y',strtotime($rbayar['tgl_bayar'])); ?></td>
			<td><?php echo $rbayar['nama_rek']; ?></td>
			<td><?php echo $rbayar['ket']; ?></td>
			<td><?php echo "Rp. ".number_format($rbayar['total'],0,",","."); ?></td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="3" align="center"><b>TOTAL PENERIMAAN</b></td>
			<?php
			$sbayar = mysql_query("SELECT SUM(total) FROM bayar WHERE id_transaksi = '$_GET[idtran]'");
			$total = mysql_fetch_array($sbayar);
			?>
			<td><b><?php echo "Rp. ".number_format($total[0],0,",","."); ?></b></td>
		</tr>
	</table>
	<hr>
	<h4 style="margin-left: 10px"><b>Data Pengeluaran : </b></h4>
	<table class="table table-condensed table-bordered">
		<tr bgcolor="grey">
			<th>Tanggal Pengeluaran</th>
			<th>Rekening</th>
			<th>Keterangan</th>
			<th>Nominal</th>
		</tr>
		<?php
		$qluar = mysql_query("SELECT * FROM pengeluaran INNER JOIN rekening ON pengeluaran.rek_kredit = rekening.id_rek WHERE pengeluaran.id_transaksi = '$_GET[idtran]'");
		while ($rluar = mysql_fetch_array($qluar)) {
		?>
		<tr>
			<td><?php echo date('d-m-Y',strtotime($rluar['tgl_pengeluaran'])); ?></td>
			<td><?php echo $rluar['nama_rek']; ?></td>
			<td><?php echo $rluar['ket']; ?></td>
			<td><?php echo "Rp. ".number_format($rluar['total'],0,",","."); ?></td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="3" align="center"><b>TOTAL PENGELUARAN</b></td>
			<?php
			$sluar = mysql_query("SELECT SUM(total) FROM pengeluaran WHERE id_transaksi = '$_GET[idtran]'");
			$totar = mysql_fetch_array($sluar);
			?>
			<td><b><?php echo "Rp. ".number_format($totar[0],0,",","."); ?></b></td>
		</tr>
	</table>
	<hr>
	<table style="margin-left: 50px">
		<tr>
			<td align="right">TOTAL NOMINAL NILAI SEWA : </td>
			<td>&nbsp;<b><?php echo "Rp. ".number_format($isi['harga'],0,",","."); ?></b></td>
		</tr>
		<tr>
			<td align="right">TOTAL PEMBAYARAN : </td>
			<td>&nbsp;<b><?php echo "Rp. ".number_format($total[0],0,",","."); ?></b></td>
		</tr>
		<tr>
			<td align="right">SISA PEMBAYARAN : </td>
			<td>&nbsp;<b><?php echo "Rp. ".number_format($isi['harga']-$total[0],0,",","."); ?></b></td>
		</tr>
		<tr>
			<td align="right">TOTAL PENGELUARAN : </td>
			<td>&nbsp;<b><?php echo "Rp. ".number_format($totar[0],0,",","."); ?></b></td>
		</tr>
		<tr>
			<td align="right">TOTAL PENDAPATAN : </td>
			<td>&nbsp;<b><?php echo "Rp. ".number_format($isi['harga']-$totar[0],0,",","."); ?></b></td>
		</tr>
	</table>
<script src="assets/js/jquery-1.11.1.js"></script>
<script src="assets/js/bootstrap.js"></script>
</body>
</html>