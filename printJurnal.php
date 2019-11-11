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
	<title>Rincian Buku Besar Jurnal Umum</title>
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
	window.location="jurnalumum.php";
}
</script>
<body onload="prin()">
	<center>
		<b style="font-size: 20px">Nama Usaha</b><br>
		<b>Tagline Usaha</b><br>
		Jl. Raya Jember, Telp. 0331, Hp. 081<hr>
		<h4>Rincian Buku Besar Jurnal Umum </h4>
		<?php
		if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") { ?>
		<h4>Jurnal Umum Semua Periode</h4>	
		<?php }else{ ?>
		<h4>Jurnal Umum Periode <?php echo date('d-m-Y',strtotime($_REQUEST['dari'])); ?> Sampai <?php echo date('d-m-Y',strtotime($_REQUEST['ke'])); ?></h4>
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
		<tr>
			<!-- Begin Jurnal -->
		<?php
		$no = 1;
		if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
		$qjurnal1 = mysql_query("SELECT * FROM jurnal WHERE rek_debet = '$rek[0]' OR rek_kredit = '$rek[0]' ORDER BY tanggal ASC");
		}else{
		$qjurnal1 = mysql_query("SELECT * FROM jurnal WHERE rek_debet = '$rek[0]' AND tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]' OR rek_kredit = '$rek[0]' AND tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]' ORDER BY tanggal ASC");
		}
		while ($rjurnal1 = mysql_fetch_array($qjurnal1)) { ?>
		<tr>
			<td><?php echo $no++; ?></td>
			<td><?php echo date('d-m-Y',strtotime($rjurnal1['tanggal'])); ?></td>
			<td><?php echo $rjurnal1[0]; ?></td>
			<td><?php echo $rjurnal1['uraian'] ?></td>
			<td>
				<?php
				$qjurnal2 = mysql_query("SELECT SUM(total) FROM jurnal WHERE no_mutasi = '$rjurnal1[0]' AND rek_debet = '$rek[0]'");
				$rjurnal2 = mysql_fetch_array($qjurnal2);
				echo number_format($rjurnal2[0],0,",",".");
				?>
			</td>
			<td>
				<?php
				$qjurnal4 = mysql_query("SELECT SUM(total) FROM jurnal WHERE no_mutasi = '$rjurnal1[0]' AND rek_kredit = '$rek[0]'");
				$rjurnal4 = mysql_fetch_array($qjurnal4);
				echo number_format($rjurnal4[0],0,",",".");
				?>
			</td>
			<td>
				<?php
				$saldojurnal = $rjurnal2[0]-$rjurnal4[0];
				if ($saldojurnal < 0) {
					echo "(".number_format(abs($saldojurnal),0,",",".").")";
				}else{
					echo number_format($saldojurnal,0,",",".");
				}				
				?>
			</td>
		</tr>
		<?php }//end while
		?>
		<!-- End Jurnal -->
		<tr>
			<td colspan="4" align="center"><b style="font-size: 18px">TOTAL</b></td>
			<td>
				<?php
				if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
					$qdebet2 = mysql_query("SELECT SUM(total) FROM jurnal WHERE rek_debet = '$rek[0]'");
				}else{
					$qdebet2 = mysql_query("SELECT SUM(total) FROM jurnal WHERE rek_debet = '$rek[0]' AND tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
				}
				$rdebet2 = mysql_fetch_array($qdebet2);
					echo "Rp. ".number_format($rdebet2[0],0,",",".");
				?>
			</td>
			<td>
				<?php
				if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
					$qkredit2 = mysql_query("SELECT SUM(total) FROM jurnal WHERE rek_kredit = '$rek[0]'");
				}else{
					$qkredit2 = mysql_query("SELECT SUM(total) FROM jurnal WHERE rek_kredit = '$rek[0]' AND tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");					
				}
				$rkredit2 = mysql_fetch_array($qkredit2);
					echo "Rp. ".number_format($rkredit2[0],0,",",".");
				?>
			</td>
			<td>
				<?php
				$saldo2 = $rdebet2[0]-$rkredit2[0];
				if ($saldo2 < 0) {
					echo "<b>(Rp. ".number_format(abs($saldo2),0,",",".").")</b>";
				}else{
					echo "<b>Rp. ".number_format($saldo2,0,",",".")."</b>";
				}
				?>
			</td>
		</tr>
	</table>
	<?php } ?>
</body>
</html>