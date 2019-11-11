<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$data = mysql_query("SELECT * FROM bayar WHERE id_bayar = '$_GET[id_bayar]'");
$isi = mysql_fetch_array($data);

?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3><i class="fa fa-money"></i> Edit Pembayaran <?php echo $isi[0]; ?></h3>
		</div>
		<div class="modal-body">
		<form id="myForm" method="post" action="updateBayar2.php">
			<input type="hidden" name="id_bayar_b" value="<?php echo $isi[0]; ?>">
            <label>Tanggal Pembayaran : </label>
            <input type="date" name="tgl_bayar_b" class="form-control" value="<?php echo $isi['tgl_bayar']; ?>">
            <div class="row">
            	<div class="col-md-6">
            		<label>Rekening Debet : </label>
		            <select class="form-control select2" name="rek_deb_b" style="width: 100%">
						<option value="">--- Pilih Rekening Debet ---</option>
						<?php
						$qrek1 = mysql_query("SELECT * FROM rekening");
						while ($rrek1 = mysql_fetch_array($qrek1)) { ?>
							<option <?php if($isi['rek_debet'] == $rrek1[0]){echo "selected";}else{} ?> value="<?php echo $rrek1[0]; ?>"><?php echo $rrek1[1]; ?></option>
						<?php } ?>
					</select>
            	</div>
            	<div class="col-md-6">
            		<label>Rekening Kredit : </label>
					<select class="form-control select2" name="rek_kre_b" style="width: 100%">
						<option value="">--- Pilih Rekening Kredit ---</option>
						<?php
						$qrek = mysql_query("SELECT * FROM rekening");
						while ($rrek = mysql_fetch_array($qrek)) { ?>
							<option <?php if($isi['rek_kredit'] == $rrek[0]){echo "selected";}else{} ?> value="<?php echo $rrek[0]; ?>"><?php echo $rrek[1]; ?></option>
						<?php } ?>
					</select>
            	</div>
            </div>
			<label>Nilai Bayar : </label>
			<input type="text" class="form-control" name="total_b" value="<?php echo $isi['total']; ?>">
			<label>Uraian / Keterangan Tambahan : </label>
			<textarea class="form-control" name="ketam_b"><?php echo $isi['ket']; ?></textarea>
            <hr>
            <button type="submit" class="btn btn-primary btn-lg btn-flat pull-right" id="update_bayar" style="margin-left: 20px">
            <i class="fa fa-money"></i> BAYAR..</button>
            <button type="button" class="btn btn-warning pull-right" data-dismiss="modal"><i class="fa fa-close"></i> BATAL</button><br>
            <div id="hasil_update_bayar" style="display: none"></div>
            <br>
            </form>
		</div>
	</div>
</div>