<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$data = mysql_query("SELECT id_bayar FROM bayar_hutang WHERE no_hutang = '$_REQUEST[nohutang]'");
while ($isi = mysql_fetch_array($data)) {
	$krj->hapusBukuBesar($_REQUEST['nohutang']);
}
$krj->hapusHutang($_REQUEST['nohutang']);
header("location:hutang.php");