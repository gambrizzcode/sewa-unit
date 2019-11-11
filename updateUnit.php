<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$data = mysql_query("SELECT * FROM unit WHERE id_unit = '$_GET[newidunit]'");
$isi  = mysql_fetch_array($data);

if ($_GET['newnama'] == $isi['nama_unit']) {
	$nama = $isi['nama_unit'];
}else if($_GET['newnama'] != $isi['nama_unit']) {
	$nama = $_GET['newnama'];
}

$krj->updateUnit($_GET['newidunit'],$nama);