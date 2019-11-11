<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->ubahBayar($_POST['id_bayar_b'],$_POST['tgl_bayar_b'],$_POST['rek_deb_b'],$_POST['rek_kre_b'],$_POST['total_b'],$_POST['ketam_b']);
$q = mysql_query("SELECT id_transaksi FROM bayar WHERE id_bayar = '$_POST[id_bayar_b]'");
$r = mysql_fetch_array($q);
$data1 = mysql_query("SELECT * FROM transaksi INNER JOIN pelanggan ON transaksi.id_pelanggan = pelanggan.id_pelanggan INNER JOIN unit ON transaksi.id_unit = unit.id_unit WHERE transaksi.id_transaksi = '$r[0]'");
$isi1  = mysql_fetch_array($data1);

$uraian2 = "Pembayaran Nota : ".$isi1[0].". Atas Nama Pelanggan : ".$isi1['nama_pelanggan'].". Unit : ".$isi1['nama_unit'].". Ket : ".$_POST['ketam_b'];
$krj->updateBukuBesar($_POST['id_bayar_b'],$_POST['tgl_bayar_b'],$uraian2,$_POST['rek_deb_b'],$_POST['rek_kre_b'],$_POST['total_b']);
header("location:transaksi.php");