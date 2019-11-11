<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$data = mysql_query("SELECT * FROM hutang WHERE no_hutang = '$_GET[idhut]'");
$isi  = mysql_fetch_array($data);
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h3><i class="fa fa-minus-square-o"></i> Detail Hutang <?php echo $isi['jenis']; ?><br><?php echo $isi['uraian']; ?></h3>
		</div>
		<div class="modal-body">
		<h4 style="margin-left: 10px">
			<b>Data Hutang : </b> 
			<button type="button" class="btn btn-flat btn-info pull-right" onclick="window.location='printDetailHutang.php?idhut=<?php echo $_GET['idhut']; ?>'"><i class="fa fa-print"></i> PRINT</button>
		</h4>
			<table style="margin-left: 50px">
				<tr>
					<td align="right">No Hutang : </td>
					<td>&nbsp;<?php echo $isi[0]; ?></td>
				</tr>
				<tr>
					<td align="right">Tanggal Hutang : </td>
					<td>&nbsp;<?php echo date('d-m-Y',strtotime($isi[1])); ?></td>
				</tr>
				<tr>
					<td align="right">Jenis Hutang : </td>
					<td>&nbsp;<?php echo $isi['jenis']; ?></td>
				</tr>
				<tr>
					<td align="right">Uraian : </td>
					<td>&nbsp;<?php echo $isi['uraian']; ?></td>
				</tr>
				<tr>
					<td align="right">Nominal : </td>
					<td>&nbsp;<?php echo "Rp. ".number_format($isi['nominal'],0,",","."); ?></td>
				</tr>
				<tr>
					<td align="right">Total Angsuran : </td>
					<?php
					$qtotang = mysql_query("SELECT SUM(total) FROM bayar_hutang WHERE no_hutang = '$_GET[idhut]'");
					$rtotang = mysql_fetch_array($qtotang);
					?>
					<td>&nbsp;<?php echo "Rp. ".number_format($rtotang[0],0,",","."); ?></td>
				</tr>
				<tr>
					<td align="right">Sisa Hutang : </td>
					<td>&nbsp;<?php echo "Rp. ".number_format($isi['nominal']-$rtotang[0],0,",","."); ?></td>
				</tr>
				<tr>
					<td align="right">Rekening Debet : </td>
					<td>&nbsp;
						<?php
						$qrekdeb = mysql_query("SELECT * FROM rekening WHERE id_rek = '$isi[5]'");
						$rrekdeb = mysql_fetch_array($qrekdeb);
						echo $rrekdeb[1];
						?>
					</td>
				</tr>
				<tr>
					<td align="right">Rekening Kredit : </td>
					<td>&nbsp;
						<?php
						$qrekkre = mysql_query("SELECT * FROM rekening WHERE id_rek = '$isi[6]'");
						$rrekkre = mysql_fetch_array($qrekkre);
						echo $rrekkre[1];
						?>
					</td>
				</tr>
				<tr>
					<td align="right">Jumlah Angsuran : </td>
					<td>&nbsp;<?php echo $isi['jml_angsuran']." Kali"; ?></td>
				</tr>
				<tr>
					<td align="right">Sudah Di Angsur : </td>
					<?php
					$qtotang1 = mysql_query("SELECT COUNT(no_hutang) FROM bayar_hutang WHERE no_hutang = '$_GET[idhut]'");
					$rtotang1 = mysql_fetch_array($qtotang1);
					?>
					<td>&nbsp;<?php echo $rtotang1[0]." Kali"; ?></td>
				</tr>
				<tr>
					<td align="right">Sisa Angsuran : </td>
					<?php $uhuy = $isi['jml_angsuran']-$rtotang1[0]; ?>
					<td>&nbsp;<?php echo $uhuy." Kali"; ?></td>
				</tr>
			</table>
			<hr>
			<h4 style="margin-left: 10px"><b>Data Angsuran : </b></h4>
			<table class="table table-condensed table-bordered">
				<tr bgcolor="grey">
					<th>Angsuran</th>
					<th>Tgl</th>
					<th>Rek. Debet</th>
					<th>Rek. Kredit</th>
					<th>Ket</th>
					<th>Nominal</th>
				</tr>
				<?php
				$wwwww = mysql_query("SELECT * FROM bayar_hutang WHERE no_hutang = '$_GET[idhut]'");
				while ($www = mysql_fetch_array($wwwww)) { ?>
				<tr>
					<td><?php echo "Ke ".$www[2]; ?></td>
					<td><?php echo date('d-m-Y',strtotime($www[3])); ?></td>
					<td>
						<?php
						$qrekdeb1 = mysql_query("SELECT * FROM rekening WHERE id_rek = '$www[4]'");
						$rrekdeb1 = mysql_fetch_array($qrekdeb1);
						echo $rrekdeb1[1];
						?>
					</td>
					<td>
						<?php
						$qrekkre1 = mysql_query("SELECT * FROM rekening WHERE id_rek = '$www[5]'");
						$rrekkre1 = mysql_fetch_array($qrekkre1);
						echo $rrekkre1[1];
						?>
					</td>
					<td><?php echo $www[7]; ?></td>
					<td><?php echo "Rp. ".number_format($www[6],0,",","."); ?></td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="5" align="center">TOTAL</td>
					<td><?php echo "Rp. ".number_format($rtotang[0],0,",","."); ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>