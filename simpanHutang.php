<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->simpanHutang($_GET['nohutang'],$_GET['tanggal'],$_GET['jenis'],$_GET['uraian'],$_GET['nominal'],$_GET['rek_deb'],$_GET['rek_kre'],$_GET['jml_angsuran']);
$uraian = $_GET['uraian']." (".$_GET['jenis'].")";
$krj->simpanBukuBesar($_GET['nohutang'],$_GET['tanggal'],$uraian,$_GET['rek_deb'],$_GET['rek_kre'],$_GET['nominal']);