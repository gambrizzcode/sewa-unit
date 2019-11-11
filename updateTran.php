<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$data = mysql_query("SELECT * FROM transaksi WHERE id_transaksi = '$_GET[newidtran]'");
$isi  = mysql_fetch_array($data);

if ($_GET['newidpel'] == $isi['id_pelanggan']) {
	$pelanggan = $isi['id_pelanggan'];
}else if($_GET['newidpel'] != $isi['id_pelanggan']) {
	$pelanggan = $_GET['newidpel'];
}

if ($_GET['newidunit'] == $isi['id_unit']) {
	$unit = $isi['id_unit'];
}else if($_GET['newidunit'] != $isi['id_unit']) {
	$unit = $_GET['newidunit'];
}

if ($_GET['newtgl_pelaksanaan'] == $isi['tgl_pelaksanaan']) {
	$tgl_pelaksanaan = $isi['tgl_pelaksanaan'];
}else if($_GET['newtgl_pelaksanaan'] != $isi['tgl_pelaksanaan']) {
	$tgl_pelaksanaan = $_GET['newtgl_pelaksanaan'];
}

if ($_GET['newlama'] == $isi['lama']) {
	$lama = $isi['lama'];
}else if($_GET['newlama'] != $isi['lama']) {
	$lama = $_GET['newlama'];
}

if ($_GET['newharga'] == $isi['harga']) {
	$harga = $isi['harga'];
}else if($_GET['newharga'] != $isi['harga']) {
	$harga = $_GET['newharga'];
}

if ($_GET['newidrek'] == $isi['id_rek']) {
	$rekening = $isi['id_rek'];
}else if($_GET['newidrek'] != $isi['id_rek']) {
	$rekening = $_GET['newidrek'];
}

if ($_GET['newdibayar'] == $isi['dibayar']) {
	$dibayar = $isi['dibayar'];
}else if($_GET['newdibayar'] != $isi['dibayar']) {
	$dibayar = $_GET['newdibayar'];
}

if ($_GET['newpiutang'] == $isi['piutang']) {
	$piutang = $isi['piutang'];
}else if($_GET['newpiutang'] != $isi['piutang']) {
	$piutang = $_GET['newpiutang'];
}

if ($_GET['newpengeluaran'] == $isi['pengeluaran']) {
	$pengeluaran = $isi['pengeluaran'];
}else if($_GET['newpengeluaran'] != $isi['pengeluaran']) {
	$pengeluaran = $_GET['newpengeluaran'];
}

if ($_GET['newket'] == $isi['ket']) {
	$ket = $isi['ket'];
}else if($_GET['newket'] != $isi['ket']) {
	$ket = $_GET['newket'];
}

if ($_GET['newidakun'] == $isi['id_akun']) {
	$akun = $isi['id_akun'];
}else if($_GET['newidakun'] != $isi['id_akun']) {
	$akun = $_GET['newidakun'];
}

if ($_GET['newrek_piutang'] == $isi['rek_piutang']) {
	$rek_piutang = $isi['rek_piutang'];
}else if($_GET['newrek_piutang'] != $isi['rek_piutang']) {
	$rek_piutang = $_GET['newrek_piutang'];
}

$krj->updateTran($_GET['newidtran'],$pelanggan,$unit,$tgl_pelaksanaan,$lama,$harga,$rekening,$dibayar,$piutang,$ket,$akun,$rek_piutang);

$data1 = mysql_query("SELECT * FROM transaksi INNER JOIN pelanggan ON transaksi.id_pelanggan = pelanggan.id_pelanggan INNER JOIN unit ON transaksi.id_unit = unit.id_unit WHERE transaksi.id_transaksi = '$_GET[newidtran]'");
$isi1  = mysql_fetch_array($data1);
$uraian1 = "Sewa Unit : ".$isi1['nama_unit'].". Atas Nama Pelanggan : ".$isi1['nama_pelanggan'];
$krj->updateBukuBesar($_GET['newidtran'],$_GET['newtanggal'],$uraian1,$rekening,$rek_piutang,$harga);

$krj->updateBayar($_GET['newidbayar'],$_GET['newidtran'],$isi1['tanggal'],$_GET['newrekdp'],$dibayar,$akun);

$uraian2 = "Pembayaran Nota : ".$isi1[0].". Atas Nama Pelanggan : ".$isi1['nama_pelanggan'].". Unit : ".$isi1['nama_unit'];
$krj->updateBukuBesar($_GET['newidbayar'],$isi1['tanggal'],$uraian2,$_GET['newrekdp'],$rek_piutang,$dibayar);