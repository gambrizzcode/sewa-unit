<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$data = mysql_query("SELECT * FROM pelanggan WHERE id_pelanggan = '$_GET[newidpel]'");
$isi  = mysql_fetch_array($data);

if ($_GET['newnama'] == $isi['nama_pelanggan']) {
	$nama = $isi['nama_pelanggan'];
}else if($_GET['newnama'] != $isi['nama_pelanggan']) {
	$nama = $_GET['newnama'];
}

if ($_GET['newalamat'] == $isi['alamat']) {
	$alamat = $isi['alamat'];
}else if($_GET['newalamat'] != $isi['alamat']) {
	$alamat = $_GET['newalamat'];
}

if ($_GET['newtelp'] == $isi['telp']) {
	$telp = $isi['telp'];
}else if($_GET['newtelp'] != $isi['telp']) {
	$telp = $_GET['newtelp'];
}

$krj->updatePel($_GET['newidpel'],$nama,$alamat,$telp);