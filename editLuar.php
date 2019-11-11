<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$data = mysql_query("SELECT * FROM transaksi WHERE id_transaksi = '$_GET[idtran]'");
$isi = mysql_fetch_array($data);
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3><i class="fa fa-upload"></i> Pengeluaran Transaksi <?php echo $isi[0]; ?></h3>
		</div>
		<div class="modal-body">
		<form id="MyForm" method="post" action="updateLuar.php">
			<input type="hidden" name="id_luar" value="<?php echo substr(md5(time()),0,8); ?>">
			<label>Id Transaksi : <?php echo $isi[0]; ?></label>
            <input type="hidden" name="idtranbayar" value="<?php echo $isi[0]; ?>">
            <input type="hidden" name="idakunbaru" value="<?php echo $_GET['idakun']; ?>"> <br>
            <label>Biaya Sewa : <?php echo "Rp. ".number_format($isi['harga'],0,",","."); ?></label><br>
            <label>Pengeluaran : <?php echo "Rp. ".number_format($isi['pengeluaran'],0,",","."); ?></label><br>
            <label>Tanggal Pembayaran : </label>
            <input type="date" name="tgl_pengeluaran" class="form-control" value="<?php echo date('Y-m-d'); ?>">
            <div class="row">
            	<div class="col-md-6">
            		<label>Rekening Debet : </label>
		            <select class="form-control select2" name="rek_deb" style="width: 100%">
						<option value="">--- Pilih Rekening Debet ---</option>
						<?php
						$qrek = mysql_query("SELECT * FROM rekening");
						while ($rrek = mysql_fetch_array($qrek)) { ?>
							<option value="<?php echo $rrek[0]; ?>"><?php echo $rrek[1]; ?></option>
						<?php } ?>
					</select>
            	</div>
            	<div class="col-md-6">
            		<label>Rekening Kredit : </label>
					<select class="form-control select2" name="rek_kre" style="width: 100%">
						<option value="">--- Pilih Rekening Kredit ---</option>
						<?php
						$qrek = mysql_query("SELECT * FROM rekening");
						while ($rrek = mysql_fetch_array($qrek)) { ?>
							<option value="<?php echo $rrek[0]; ?>"><?php echo $rrek[1]; ?></option>
						<?php } ?>
					</select>
            	</div>
            </div>
			<label>Nilai Pengeluaran : </label>
			<input type="text" class="form-control" name="total">
			<label>Uraian / Keterangan Tambahan : </label>
			<textarea class="form-control" name="ketam"></textarea>
            <hr>
            <button type="submit" class="btn btn-primary btn-lg btn-flat pull-right" id="keluar" style="margin-left: 20px">
            <i class="fa fa-money"></i> BAYAR PENGELUARAN</button>
            <button type="button" class="btn btn-warning pull-right" data-dismiss="modal"><i class="fa fa-close"></i> BATAL</button><br>
            <div id="hasil_luar" style="display: none"></div>
            <br>
            </form>
		</div>
	</div>
</div>