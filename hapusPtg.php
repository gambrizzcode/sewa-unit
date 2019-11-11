<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->hapusPetugas($_REQUEST['id_akun']);
header("location:petugas.php");