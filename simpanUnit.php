<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->simpanUnit($_GET['idunit'],$_GET['nama']);