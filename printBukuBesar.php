<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Rincian Buku Besar</title>
	<link rel="icon" href="assets/favicon.png">
	<link href="assets/css/bootstrap.css" rel="stylesheet" />
	<link href="assets/css/font-awesome.css" rel="stylesheet" />
</head>
<style type="text/css">
	body{
		font-size: 11px;
	}
</style>
<script>
function prin() {
	window.print();
	window.location="bukubesar.php";
}
</script>
<body onload="prin()">
	<center>
		<b style="font-size: 20px">Nama Usaha</b><br>
		<b>Tagline Usaha</b><br>
		Jl. Raya Jember, Telp. 0331, Hp. 081<hr>
		<h4>Rincian Buku Besar</h4>
		<?php
		if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") { ?>
		<h4>Rincian Buku Besar Semua Periode</h4>	
		<?php }else{ ?>
		<h4>Rincian Buku Besar Periode <?php echo date('d-m-Y',strtotime($_REQUEST['dari'])); ?> Sampai <?php echo date('d-m-Y',strtotime($_REQUEST['ke'])); ?></h4>
		<?php } ?>
	</center>
	<?php
	$data = mysql_query("SELECT * FROM rekening");
	while ($rek = mysql_fetch_array($data)) { ?>
	<br><br>
	<table>
		<tr>
			<td><label>Id Rekening : </label></td>
			<td><label><?php echo $rek[0]; ?></label></td>
		</tr>
		<tr>
			<td><label>Nama Rekening : </label></td>
			<td><label><?php echo $rek[1]; ?></label></td>
		</tr>
	</table>
	<br>
	<table class="table table-condensed table-bordered">
		<tr bgcolor="cyan">
			<th>#</th>
			<th>TANGGAL</th>
			<th>NO MUTASI</th>
			<th>URAIAN</th>
			<th>DEBET</th>
			<th>KREDIT</th>
			<th>SALDO</th>
		</tr>
		<?php
		$nourut = 1;
		if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
			$querybukubesar = mysql_query("SELECT * FROM buku_besar WHERE rek_debet = '$rek[0]' OR rek_kredit = '$rek[0]' ORDER BY tanggal ASC");
		}else{
			$querybukubesar = mysql_query("SELECT * FROM buku_besar WHERE rek_debet = '$rek[0]' AND tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]' OR rek_kredit = '$rek[0]' AND tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]' ORDER BY tanggal ASC");
		}
		while ($r = mysql_fetch_array($querybukubesar)) { ?>
		<tr>
			<td><?php echo $nourut++; ?></td>
			<td><?php echo date('d-m-Y',strtotime($r['tanggal'])); ?></td>
			<td><?php echo $r['no_mutasi']; ?></td>
			<td><?php echo $r['uraian']; ?></td>
			<td align="right"><?php			
				$qdebet = mysql_query("SELECT SUM(total) FROM buku_besar WHERE no_mutasi = '$r[1]' AND rek_debet = '$rek[0]' ORDER BY tanggal ASC");
				$rdebet = mysql_fetch_array($qdebet);
				echo number_format($rdebet[0],0,",",".");
			?></td>
			<td align="right"><?php
				$qkredit = mysql_query("SELECT SUM(total) FROM buku_besar WHERE no_mutasi = '$r[1]' AND rek_kredit = '$rek[0]' ORDER BY tanggal ASC");
				$rkredit = mysql_fetch_array($qkredit);
				echo number_format($rkredit[0],0,",",".");
			?></td>
			<td align="right">
				<?php
				$saldo = $rdebet[0]-$rkredit[0];
				if ($saldo < 0) {
					echo "(".number_format(abs($saldo),0,",",".").")";
				}else{
					echo number_format($saldo,0,",",".");
				}
				?>
			</td>
		</tr>
		<?php } ?>
		<!-- Begin Total -->
		<tr>
			<td colspan="4" align="center"><b style="font-size: 18px">TOTAL</b></td>
			<td align="right">
				<?php
				if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
					$qtotmod = mysql_query("SELECT SUM(total) FROM buku_besar WHERE rek_debet = '$rek[0]'");
				}else{
					$qtotmod = mysql_query("SELECT SUM(total) FROM buku_besar WHERE rek_debet = '$rek[0]' AND tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
				}
				$rtotmod = mysql_fetch_array($qtotmod);
					echo number_format($rtotmod[0],0,",",".");
				?>
			</td>
			<td align="right">
				<?php
				if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
					$qtotmodo = mysql_query("SELECT SUM(total) FROM buku_besar WHERE rek_kredit = '$rek[0]'");
				}else{
					$qtotmodo = mysql_query("SELECT SUM(total) FROM buku_besar WHERE rek_kredit = '$rek[0]' AND tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
				}
				$rtotmodo = mysql_fetch_array($qtotmodo);
					echo number_format($rtotmodo[0],0,",",".");
				?>
			</td>
			<td align="right">
				<?php
				$saldoTotal = $rtotmod[0]-$rtotmodo[0];
				if ($saldoTotal < 0) {
					echo "(".number_format(abs($saldoTotal),0,",",".").")";
				}else{
					echo number_format($saldoTotal,0,",",".");
				}
				?>
			</td>
		</tr>
		<!-- End Total -->
	</table>
	<?php } ?>
</body>
</html>