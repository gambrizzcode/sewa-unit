<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->simpanLuar($_POST['id_luar'],$_POST['idtranbayar'],$_POST['tgl_pengeluaran'],$_POST['rek_deb'],$_POST['rek_kre'],$_POST['total'],$_POST['ketam'],$_POST['idakunbaru']);

$data1 = mysql_query("SELECT * FROM transaksi INNER JOIN pelanggan ON transaksi.id_pelanggan = pelanggan.id_pelanggan INNER JOIN unit ON transaksi.id_unit = unit.id_unit WHERE transaksi.id_transaksi = '$_POST[idtranbayar]'");
$isi1  = mysql_fetch_array($data1);

$uraian2 = "Pengeluaran Nota : ".$isi1[0].". Atas Nama Pelanggan : ".$isi1['nama_pelanggan'].". Unit : ".$isi1['nama_unit'].". Ket : ".$_POST['ketam'];
$krj->simpanBukuBesar($_POST['id_luar'],$_POST['tgl_pengeluaran'],$uraian2,$_POST['rek_deb'],$_POST['rek_kre'],$_POST['total']);

header("location:transaksi.php");