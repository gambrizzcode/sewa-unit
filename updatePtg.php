<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$data = mysql_query("SELECT * FROM akun WHERE id_akun = '$_GET[newidakun]'");
$isi  = mysql_fetch_array($data);

if ($_GET['newnama'] == $isi['nama_akun']) {
	$nama = $isi['nama_akun'];
}else if($_GET['newnama'] != $isi['nama_akun']) {
	$nama = $_GET['newnama'];
}

if ($_GET['newusername'] == $isi['username']) {
	$username = $isi['username'];
}else if($_GET['newusername'] != $isi['username']) {
	$username = $_GET['newusername'];
}

if ($_GET['newpassword'] == $isi['password']) {
	$password = $isi['password'];
}else if($_GET['newpassword'] != $isi['password']) {
	$password = md5($_GET['newpassword']);
}

if ($_GET['newlevel'] == $isi['level']) {
	$level = $isi['level'];
}else if($_GET['newlevel'] != $isi['nama_levelakun']) {
	$level = $_GET['newlevel'];
}

if ($_GET['newstatus'] == $isi['status']) {
	$status = $isi['status'];
}else if($_GET['newstatus'] != $isi['status']) {
	$status = $_GET['newstatus'];
}

$krj->updatePetugas($_GET['newidakun'],$nama,$username,$password,$level,$status);