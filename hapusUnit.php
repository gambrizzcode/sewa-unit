<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->hapusUnit($_REQUEST['id_unit']);
header("location:unit.php");