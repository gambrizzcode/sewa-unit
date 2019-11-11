<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$data = mysql_query("SELECT * FROM transaksi INNER JOIN bayar ON transaksi.id_transaksi = bayar.id_transaksi WHERE transaksi.id_transaksi = '$_GET[idtran]'");
$isi = mysql_fetch_array($data);
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h3><i class="fa fa-edit"></i> Edit Transaksi Sewa <?php echo $isi[0]; ?></h3>
		</div>
		<div class="modal-body">
			<input type="hidden" id="newidbayar" value="<?php echo $isi[13]; ?>">
			<input type="hidden" id="newidluar" value="<?php echo $isi[21]; ?>">
			<label>Id Transaksi : <?php echo $isi[0]; ?></label>
			<input type="hidden" id="newidtran" value="<?php echo $isi[0]; ?>"> || 
			<label>Tanggal : <?php echo $isi['tanggal']; ?></label>
			<input type="hidden" id="newtanggal" value="<?php echo $isi['tanggal']; ?>">
			<input type="hidden" id="newidakun" value="<?php echo $_GET['idakun']; ?>"><br>
			<label>Pelanggan : </label>
			<select class="form-control select2" id="newidpel" style="width: 100%">
				<option value="">--- Pilih Pelanggan ---</option>
				<?php
				$qpel = mysql_query("SELECT * FROM pelanggan");
				while ($rpel = mysql_fetch_array($qpel)) { ?>
					<option <?php if($isi['id_pelanggan'] == $rpel[0]){echo "selected";} ?> value="<?php echo $rpel[0]; ?>"><?php echo $rpel[1]." - ".$rpel[2]." - ".$rpel[3]; ?></option>
				<?php } ?>
			</select>
			<label>Pilih Unit : </label>
			<select class="form-control select2" id="newidunit" style="width: 100%">
			<option value="">--- Pilih Unit ---</option>
			<?php
			$qunit = mysql_query("SELECT * FROM unit");
			while ($runit = mysql_fetch_array($qunit)) { ?>
				<option <?php if($isi['id_unit'] == $runit[0]){echo "selected";} ?> value="<?php echo $runit[0]; ?>"><?php echo $runit[1]; ?></option>
			<?php } ?>
			</select>
			<label>Tanggal Mulai Pelaksanaan : </label>
			<input type="date" id="newtgl_pelaksanaan" class="form-control" value="<?php echo $isi['tgl_pelaksanaan']; ?>">
			<label>Lama Sewa : </label>
			<input type="text" class="form-control" id="newlama" placeholder="Hari" value="<?php echo $isi['lama']; ?>">
			<div class="row">
				<div class="col-md-6">
					<label>Harga : </label>
					<input type="text" class="form-control" id="newharga" value="<?php echo $isi['harga']; ?>">
				</div>
				<div class="col-md-6">
					<label>Rekening : </label>
					<select class="form-control select2" id="newidrek" style="width: 100%">
						<option value="">--- Pilih Rekening ---</option>
						<?php
						$qrek = mysql_query("SELECT * FROM rekening");
						while ($rrek = mysql_fetch_array($qrek)) { ?>
							<option <?php if($isi['id_rek'] == $rrek[0]){echo "selected";} ?> value="<?php echo $rrek[0]; ?>"><?php echo $rrek[1]; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<label>Dibayar : </label>
					<input type="text" class="form-control" id="newdibayar" value="<?php echo $isi['dibayar']; ?>">
				</div>
				<div class="col-md-6">
					<label>Rekening : </label>
					<select class="form-control select2" id="newrekdp" style="width: 100%">
						<option value="">--- Pilih Rekening ---</option>
						<?php
						$qrek = mysql_query("SELECT * FROM rekening");
						while ($rrek = mysql_fetch_array($qrek)) { ?>
							<option <?php if($isi[17] == $rrek[0]){echo "selected";} ?> value="<?php echo $rrek[0]; ?>"><?php echo $rrek[1]; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<label>Piutang : </label>
					<input type="text" class="form-control" id="newpiutang" readonly value="<?php echo $isi['piutang']; ?>">
				</div>
				<div class="col-md-6">
					<label>Rekening : </label>
					<select class="form-control select2" id="newrek_piutang" style="width: 100%">
						<option value="">--- Pilih Rekening ---</option>
						<?php
						$qrek = mysql_query("SELECT * FROM rekening");
						while ($rrek = mysql_fetch_array($qrek)) { ?>
							<option <?php if($isi[13] == $rrek[0]){echo "selected";} ?> value="<?php echo $rrek[0]; ?>"><?php echo $rrek[1]; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<label>Uraian / Keterangan Tambahan : </label>
			<textarea class="form-control" id="newket"><?php echo $isi['ket']; ?></textarea>
			<hr>
			<button type="button" class="btn btn-primary btn-lg btn-flat pull-right" id="update" style="margin-left: 20px"><i class="fa fa-save"></i> UPDATE</button>
			<button type="button" class="btn btn-warning pull-right" data-dismiss="modal"><i class="fa fa-close"></i> BATAL</button><br>
			<div id="hasil_update" style="display: none"></div>
			<br>
		</div>
	</div>
</div>