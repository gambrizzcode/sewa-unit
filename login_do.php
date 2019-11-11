<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$password = $_GET['password'];
$pass = md5($password);
$pilih = mysql_query("SELECT * FROM akun WHERE username = '$_GET[username]' AND password = '$pass' AND status = '1'");
$log_in = mysql_num_rows($pilih);
if ($log_in == 1) {
	$isi = mysql_fetch_array($pilih);
	$id_akun = $isi[0];
	$_SESSION['id_akun'] = $id_akun;
	echo "
	<div class='alert alert-success'>
		<button type='button' class='close' data-dismiss='alert'><i class='fa fa-close pull-right'></i></button>
		<h4 id='uhu'>Berhasil Login !! </h4>
	</div>
	";
}else{
	echo "
	<div class='alert alert-danger'>
		<button type='button' class='close' data-dismiss='alert'><i class='fa fa-close pull-right'></i></button>
		<h4 id='uhu'>Periska Kembali Username dan Password Anda !! </h4>
	</div>
	";
}
?>