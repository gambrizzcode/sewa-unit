<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->hapusPel($_REQUEST['id_pel']);
header("location:pelanggan.php");