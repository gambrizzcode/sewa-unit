<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$data = mysql_query("SELECT * FROM rekening WHERE id_rek = '$_GET[newidrek]'");
$isi  = mysql_fetch_array($data);

if ($_GET['newnama'] == $isi['nama_rek']) {
	$nama = $isi['nama_rek'];
}else if($_GET['newnama'] != $isi['nama_rek']) {
	$nama = $_GET['newnama'];
}

$krj->updateRek($_GET['newidrek'],$nama);