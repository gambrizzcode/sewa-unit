<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$data = mysql_query("SELECT * FROM transaksi INNER JOIN bayar ON transaksi.id_transaksi = bayar.id_transaksi WHERE transaksi.id_transaksi = '$_REQUEST[id_tran]'");
while ($isi = mysql_fetch_array($data)) {
	$krj->hapusBukuBesar($isi['id_bayar']);
}
$data2 = mysql_query("SELECT * FROM transaksi INNER JOIN pengeluaran ON transaksi.id_transaksi = pengeluaran.id_transaksi WHERE transaksi.id_transaksi = '$_REQUEST[id_tran]'");
while ($isi2 = mysql_fetch_array($data2)) {
	$krj->hapusBukuBesar($isi2['id_luar']);
}
$krj->hapusBukuBesar($_REQUEST['id_tran']);
$krj->hapusTran($_REQUEST['id_tran']);
header("location:transaksi.php");