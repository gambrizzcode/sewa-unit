<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->ubahLuar($_POST['id_luar_l'],$_POST['tgl_pengeluaran_l'],$_POST['rek_deb_l'],$_POST['rek_kre_l'],$_POST['total_l'],$_POST['ketam_l']);
$q = mysql_query("SELECT id_transaksi FROM pengeluaran WHERE id_luar = '$_POST[id_luar_l]'");
$r = mysql_fetch_array($q);
$data1 = mysql_query("SELECT * FROM transaksi INNER JOIN pelanggan ON transaksi.id_pelanggan = pelanggan.id_pelanggan INNER JOIN unit ON transaksi.id_unit = unit.id_unit WHERE transaksi.id_transaksi = '$r[0]'");
$isi1  = mysql_fetch_array($data1);

$uraian2 = "Pengeluaran Nota : ".$isi1[0].". Atas Nama Pelanggan : ".$isi1['nama_pelanggan'].". Unit : ".$isi1['nama_unit'].". Ket : ".$_POST['ketam_l'];
$krj->updateBukuBesar($_POST['id_luar_l'],$_POST['tgl_pengeluaran_l'],$uraian2,$_POST['rek_deb_l'],$_POST['rek_kre_l'],$_POST['total_l']);
header("location:transaksi.php");