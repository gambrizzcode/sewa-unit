<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->hapusRek($_REQUEST['id_rek']);
header("location:rekening.php");