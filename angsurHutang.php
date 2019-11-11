<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$data = mysql_query("SELECT * FROM hutang WHERE no_hutang = '$_GET[idhut]'");
$isi = mysql_fetch_array($data);

?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3><i class="fa fa-money"></i> Angsur Hutang <?php echo $isi['jenis']; ?><br><?php echo $isi['uraian']; ?></h3>
		</div>
		<div class="modal-body">
		<form name="MyForm" method="post" action="simpanAngsur.php">
			<input type="hidden" name="id_bayar" value="<?php echo substr(md5(time()),0,8); ?>">
			<label>No Hutang : <?php echo $isi[0]; ?></label>
			<input type="hidden" name="nohutangbaru" value="<?php echo $isi[0]; ?>">
			<div class="row">
				<div class="col-md-6">
					<label>Angsuran Ke : </label>
					<?php
					$qang = mysql_query("SELECT MAX(angsuran_ke) FROM bayar_hutang WHERE no_hutang = '$isi[0]'");
					$rang = mysql_fetch_array($qang);
					if ($rang[0] == null) {
						$lanjutanya = 1;
					}else{
						$lanjutanya = $rang[0]+1;
					}
					?>
					<input type="text" class="form-control" name="angsuranke" value="<?php echo $lanjutanya; ?>" readonly>
				</div>
				<div class="col-md-6">
					<label>Tanggal : </label>
					<input type="date" class="form-control" name="tgl" value="<?php echo date('Y-m-d'); ?>">
				</div>
			</div>
			<div class="row">
            	<div class="col-md-6">
            		<label>Rekening Debet : </label>
		            <select class="form-control select2" name="rek_debbaru" style="width: 100%">
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
					<select class="form-control select2" name="rek_krebaru" style="width: 100%">
						<option value="">--- Pilih Rekening Kredit ---</option>
						<?php
						$qrek = mysql_query("SELECT * FROM rekening");
						while ($rrek = mysql_fetch_array($qrek)) { ?>
							<option value="<?php echo $rrek[0]; ?>"><?php echo $rrek[1]; ?></option>
						<?php } ?>
					</select>
            	</div>
            </div>
            <label>Nominal Angsuran : </label>
            <input type="text" class="form-control" name="nominalbaru">
            <label>Keterangan Tambahan : </label>
            <textarea class="form-control" name="ketbaru"></textarea>
            <hr>
            <button type="submit" class="btn btn-primary btn-lg btn-flat pull-right" name="angsur" style="margin-left: 20px">
            <i class="fa fa-money"></i> BAYAR</button>
            <button type="button" class="btn btn-warning pull-right" data-dismiss="modal"><i class="fa fa-close"></i> BATAL</button><br>
            <div name="hasil_angsur" style="display: none"></div>
            <br>
            </form>
		</div>
	</div>
</div>