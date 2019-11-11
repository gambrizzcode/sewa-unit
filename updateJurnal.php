<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$data = mysql_query("SELECT * FROM jurnal WHERE no_mutasi = '$_GET[newnomutasi]'");
$isi  = mysql_fetch_array($data);

if ($_GET['newtanggal'] == $isi['tanggal']) {
	$tanggal = $isi['tanggal'];
}else if($_GET['newtanggal'] != $isi['tanggal']) {
	$tanggal = $_GET['newtanggal'];
}

if ($_GET['newrek_deb'] == $isi['rek_debet']) {
	$rek_deb = $isi['rek_debet'];
}else if($_GET['newrek_deb'] != $isi['rek_debet']) {
	$rek_deb = $_GET['newrek_deb'];
}

if ($_GET['newrek_kre'] == $isi['rek_kredit']) {
	$rek_kre = $isi['rek_kredit'];
}else if($_GET['newrek_kre'] != $isi['rek_kredit']) {
	$rek_kre = $_GET['newrek_kre'];
}

if ($_GET['newtotal'] == $isi['total']) {
	$total = $isi['total'];
}else if($_GET['newtotal'] != $isi['total']) {
	$total = $_GET['newtotal'];
}

if ($_GET['newuraian'] == $isi['uraian']) {
	$uraian = $isi['uraian'];
}else if($_GET['newuraian'] != $isi['uraian']) {
	$uraian = $_GET['newuraian'];
}

$krj->updateJurnal($_GET['newnomutasi'],$tanggal,$rek_deb,$rek_kre,$total,$uraian);
$krj->updateBukuBesar($_GET['newnomutasi'],$tanggal,$uraian,$rek_deb,$rek_kre,$total);