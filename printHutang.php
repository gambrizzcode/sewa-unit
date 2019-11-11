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
	<title>Laporan Hutang</title>
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
	window.location="hutang.php";
}
</script>
<body onload="prin()">
	<center>
		<b style="font-size: 20px">Nama Usaha</b><br>
		<b>Tagline Usaha</b><br>
		Jl. Raya Jember, Telp. 0331, Hp. 081<hr>
		<h4>Daftar Hutang</h4>
		<?php
		if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") { ?>
		<h4>Daftar Hutang Semua Periode</h4>	
		<?php }else{ ?>
		<h4>Daftar Hutang Periode <?php echo date('d-m-Y',strtotime($_REQUEST['dari'])); ?> Sampai <?php echo date('d-m-Y',strtotime($_REQUEST['ke'])); ?></h4>
		<?php } ?>
	</center>
			<table class="table table-condensed table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>Jenis Hutang</th>
						<th>Total hutang</th>
						<th>Total Bayar</th>
						<th>Sisa Hutang</th>
						<th>Banyaknya Angs.</th>
						<th>Sisa Angs.</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;
					if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
						$datahutang = mysql_query("SELECT * FROM hutang");
					}else{
						$datahutang = mysql_query("SELECT * FROM hutang WHERE tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
					}
					while ($isihutang = mysql_fetch_array($datahutang)) { ?>
					<tr>
						<td><?php echo $no++; ?></td>
						<td><?php echo $isihutang['jenis']; ?></td>
						<td><?php echo "Rp. ".number_format($isihutang['nominal'],0,",","."); ?></td>
						<td><?php
						if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
							$qbyar = mysql_query("SELECT SUM(total) FROM bayar_hutang WHERE no_hutang = '$isihutang[0]'");
						}else{
						$qbyar = mysql_query("SELECT SUM(total) FROM bayar_hutang WHERE no_hutang = '$isihutang[0]' AND tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
						}
						$rbyar = mysql_fetch_array($qbyar);
						echo "Rp. ".number_format($rbyar[0],0,",",".");
						?></td>
						<td><?php
						if ($isihutang['nominal']-$rbyar[0] == 0) {
							echo "<i>Rp. ".number_format($isihutang['nominal']-$rbyar[0],0,",",".")."</i>";
						}else{
							echo "Rp. ".number_format($isihutang['nominal']-$rbyar[0],0,",",".");
						}
						?></td>
						<td><?php echo $isihutang['jml_angsuran']." Kali"; ?></td>
						<td><?php
						if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
							$qangs = mysql_query("SELECT COUNT(no_hutang) FROM bayar_hutang WHERE no_hutang = '$isihutang[0]'");
						}else{
							$qangs = mysql_query("SELECT COUNT(no_hutang) FROM bayar_hutang WHERE no_hutang = '$isihutang[0]' AND tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
						}
						$rangs = mysql_fetch_array($qangs);
						$ahay = $isihutang['jml_angsuran']-$rangs[0];
						if ($isihutang['nominal']-$rbyar[0] == 0) {
							echo "<i>".$ahay." Kali</i>";
						}else{
							echo $ahay." Kali";
						}
						?></td>
					</tr>
					<?php } ?>
					<tr>
						<td colspan="2" align="center"><label>TOTAL</label></td>
						<td>
							<?php
							if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
								$qtothut = mysql_query("SELECT SUM(nominal) FROM hutang");
							}else{
								$qtothut = mysql_query("SELECT SUM(nominal) FROM hutang WHERE tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
							}
							$rtothut = mysql_fetch_array($qtothut);
							echo "<b>Rp. ".number_format($rtothut[0],0,",",".")."</b>";
							?>
						</td>
						<td>
							<?php
							if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
								$qtotbyar = mysql_query("SELECT SUM(total) FROM bayar_hutang");
							}else{
								$qtotbyar = mysql_query("SELECT SUM(total) FROM bayar_hutang WHERE tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]'");
							}
							$rtotbyar = mysql_fetch_array($qtotbyar);
							echo "<b>Rp. ".number_format($rtotbyar[0],0,",",".")."</b>";
							?>
						</td>
						<td>
							<?php
							echo "<b>Rp. ".number_format($rtothut[0]-$rtotbyar[0],0,",",".")."</b>";
							?>
						</td>
						<td align="center">-</td>
						<td align="center">-</td>
					</tr>
				</tbody>
			</table>
			<hr>
			<p align="right">NB : <b>Cetak Tebal</b> = Belum lunas,<br><i>Cetak Miring</i> = Lunas</p>
</body>
</html>