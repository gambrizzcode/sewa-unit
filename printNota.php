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
	<title>Nota Transaksi <?php echo $isi[0]; ?></title>
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
		<h4><b>--- TAGIHAN / NOTA PEMBAYARAN ---</b></h4>
	</center>
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
	<table class="table table-condensed table-bordered">
		<tr bgcolor="grey">
			<th>Tanggal Bayar</th>
			<th>Uraian</th>
			<th>Nominal</th>
		</tr>
		<?php
		$qbayar = mysql_query("SELECT * FROM bayar WHERE id_transaksi = '$_GET[idtran]'");
		while ($rbayar = mysql_fetch_array($qbayar)) {
		?>
		<tr>
			<td><?php echo date('d-m-Y',strtotime($rbayar['tgl_bayar'])); ?></td>
			<td><?php echo $rbayar['ket']; ?></td>
			<td><?php echo "Rp. ".number_format($rbayar['total'],0,",","."); ?></td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="2" align="center"><b>TOTAL BAYAR</b></td>
			<?php
			$sbayar = mysql_query("SELECT SUM(total) FROM bayar WHERE id_transaksi = '$_GET[idtran]'");
			$total = mysql_fetch_array($sbayar);
			?>
			<td><b><?php echo "Rp. ".number_format($total[0],0,",","."); ?></b></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><b>KEKURANGAN PEMBAYARAN</b></td>
			<td><b><?php echo "Rp. ".number_format($isi['harga']-$total[0],0,",","."); ?></b></td>
		</tr>
	</table>
	<hr>
	<p align="center">
	Customer
	<i style="margin-left: 100px"></i>
	Petugas / Kasir
	<br><br><br>
	<b><?php echo $isi['nama_pelanggan']; ?></b>
	<i style="margin-left: 100px"></i>
	<b><?php echo $isi['nama_akun']; ?></b>
	</p>
<script src="assets/js/jquery-1.11.1.js"></script>
<script src="assets/js/bootstrap.js"></script>
</body>
</html>