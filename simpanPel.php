<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->simpanPel($_GET['idpel'],$_GET['nama'],$_GET['alamat'],$_GET['telp'],0);