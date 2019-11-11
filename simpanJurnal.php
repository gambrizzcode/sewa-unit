<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->simpanJurnal($_GET['nomutasi'],$_GET['tanggal'],$_GET['rek_deb'],$_GET['rek_kre'],$_GET['total'],$_GET['uraian']);
$krj->simpanBukuBesar($_GET['nomutasi'],$_GET['tanggal'],$_GET['uraian'],$_GET['rek_deb'],$_GET['rek_kre'],$_GET['total']);