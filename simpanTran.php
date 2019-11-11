<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->simpanTran($_GET['idtran'],$_GET['tanggal'],$_GET['idpel'],$_GET['idunit'],$_GET['tgl_pelaksanaan'],$_GET['lama'],$_GET['harga'],$_GET['idrek'],$_GET['dibayar'],$_GET['piutang'],0,$_GET['ket'],$_GET['idakun'],$_GET['rek_piutang']);
$krj->updatePiutangPel($_GET['idpel'],$_GET['piutang']);
$krj->simpanBayar($_GET['id_bayar'],$_GET['idtran'],$_GET['tanggal'],$_GET['rekdp'],$_GET['rek_piutang'],$_GET['dibayar'],$_GET['ket'],$_GET['idakun']);

$data1 = mysql_query("SELECT * FROM transaksi INNER JOIN pelanggan ON transaksi.id_pelanggan = pelanggan.id_pelanggan INNER JOIN unit ON transaksi.id_unit = unit.id_unit WHERE transaksi.id_transaksi = '$_GET[idtran]'");
$isi1  = mysql_fetch_array($data1);
$uraian1 = "Sewa Unit : ".$isi1['nama_unit'].". Atas Nama Pelanggan : ".$isi1['nama_pelanggan'];
$krj->simpanBukuBesar($_GET['idtran'],$_GET['tanggal'],$uraian1,$_GET['idrek'],$_GET['rek_piutang'],$_GET['harga']);

$uraian2 = "Pembayaran Nota : ".$isi1[0].". Atas Nama Pelanggan : ".$isi1['nama_pelanggan'].". Unit : ".$isi1['nama_unit'];
$krj->simpanBukuBesar($_GET['id_bayar'],$_GET['tanggal'],$uraian2,$_GET['rekdp'],$_GET['rek_piutang'],$_GET['dibayar']);