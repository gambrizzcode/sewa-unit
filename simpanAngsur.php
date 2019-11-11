<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->angsur($_POST['id_bayar'],$_POST['nohutangbaru'],$_POST['angsuranke'],$_POST['tgl'],$_POST['rek_debbaru'],$_POST['rek_krebaru'],$_POST['nominalbaru'],$_POST['ketbaru']);
$data = mysql_query("SELECT * FROM hutang WHERE no_hutang = '$_POST[nohutangbaru]'");
$isi  = mysql_fetch_array($data);
$uraian = "Pembayaran Hutang ".$isi[0].". ".$isi['uraian']." (".$isi['jenis']."). Ket : ".$_POST['ketbaru'];
$krj->simpanBukuBesar($_POST['id_bayar'],$_POST['tgl'],$uraian,$_POST['rek_debbaru'],$_POST['rek_krebaru'],$_POST['nominalbaru']);
header("location:hutang.php");