<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$data = mysql_query("SELECT * FROM jurnal WHERE no_mutasi = '$_GET[idjur]'");
$isi  = mysql_fetch_array($data);
?>
		<div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3><i class="fa fa-file-text"></i> Edit Jurnal <?php echo $isi[0]; ?></h3>
                </div>
                <div class="modal-body">
                    <label>No Mutasi : <?php echo $isi[0]; ?></label>
                    <input type="hidden" id="newnomutasi" value="<?php echo $isi[0]; ?>"><br>
                    <label>Tanggal : </label>
                    <input type="date" class="form-control" id="newtanggal" value="<?php echo $isi[1]; ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Rekening Debet : </label>
                            <select class="form-control select2" id="newrek_deb" style="width: 100%">
                                <option value="">--- Pilih Rekening Debet ---</option>
                                <?php
                                $qrek = mysql_query("SELECT * FROM rekening");
                                while ($rrek = mysql_fetch_array($qrek)) { ?>
                                    <option <?php if($isi[2] == $rrek[0]){echo "selected";}else{} ?> value="<?php echo $rrek[0]; ?>"><?php echo $rrek[1]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Rekening Kredit : </label>
                            <select class="form-control select2" id="newrek_kre" style="width: 100%">
                                <option value="">--- Pilih Rekening Kredit ---</option>
                                <?php
                                $qrek = mysql_query("SELECT * FROM rekening");
                                while ($rrek = mysql_fetch_array($qrek)) { ?>
                                    <option <?php if($isi[3] == $rrek[0]){echo "selected";}else{} ?> value="<?php echo $rrek[0]; ?>"><?php echo $rrek[1]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <label>Nilai Rupiah Mutasi : </label>
                    <input type="text" class="form-control" id="newtotal" value="<?php echo $isi[4]; ?>">
                    <label>Uraian : </label>
                    <textarea class="form-control" id="newuraian"><?php echo $isi[5]; ?></textarea>
                    <hr>
                    <button type="button" class="btn btn-primary btn-lg btn-flat pull-right" id="update" style="margin-left: 20px"><i class="fa fa-save"></i> UPDATE</button>
                    <button type="button" class="btn btn-warning pull-right" data-dismiss="modal"><i class="fa fa-close"></i> BATAL</button><br>
                    <div id="hasil_update" style="display: none"></div>
                    <br>
                </div>
            </div>
        </div>