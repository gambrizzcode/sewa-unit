<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->simpanPetugas($_GET['idakun'],$_GET['nama'],$_GET['username'],md5($_GET['password']),$_GET['level'],$_GET['status']);