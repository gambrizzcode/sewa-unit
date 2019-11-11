<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$data = mysql_query("SELECT * FROM hutang WHERE no_hutang = '$_GET[newnohutang]'");
$isi  = mysql_fetch_array($data);

if ($_GET['newtanggal'] == $isi['tanggal']) {
	$tanggal = $isi['tanggal'];
}else if($_GET['newtanggal'] != $isi['tanggal']) {
	$tanggal = $_GET['newtanggal'];
}

if ($_GET['newjenis'] == $isi['jenis']) {
	$jenis = $isi['jenis'];
}else if($_GET['newjenis'] != $isi['jenis']) {
	$jenis = $_GET['newjenis'];
}

if ($_GET['newuraian'] == $isi['uraian']) {
	$uraian = $isi['uraian'];
}else if($_GET['newuraian'] != $isi['uraian']) {
	$uraian = $_GET['newuraian'];
}

if ($_GET['newnominal'] == $isi['nominal']) {
	$nominal = $isi['nominal'];
}else if($_GET['newnominal'] != $isi['nominal']) {
	$nominal = $_GET['newnominal'];
}

if ($_GET['newrek_deb'] == $isi['rek_debet']) {
	$rek_debet = $isi['rek_debet'];
}else if($_GET['newrek_deb'] != $isi['rek_debet']) {
	$rek_debet = $_GET['newrek_deb'];
}

if ($_GET['newrek_kre'] == $isi['rek_kredit']) {
	$rek_kredit = $isi['rek_kredit'];
}else if($_GET['newrek_kre'] != $isi['rek_kredit']) {
	$rek_kredit = $_GET['newrek_kre'];
}

if ($_GET['newjml_angsuran'] == $isi['jml_angsuran']) {
	$jml_angsuran = $isi['jml_angsuran'];
}else if($_GET['newjml_angsuran'] != $isi['jml_angsuran']) {
	$jml_angsuran = $_GET['newjml_angsuran'];
}

$krj->updateHutang($_GET['newnohutang'],$tanggal,$jenis,$uraian,$nominal,$rek_debet,$rek_kredit,$jml_angsuran);

$uraiano = $uraian." (".$jenis.")";
$krj->updateBukuBesar($_GET['newnohutang'],$tanggal,$uraiano,$rek_debet,$rek_kredit,$nominal);