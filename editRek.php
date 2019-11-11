<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$data = mysql_query("SELECT * FROM rekening WHERE id_rek = '$_GET[idrek]'");
$isi = mysql_fetch_array($data);
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3><i class="fa fa-suitcase"></i> Edit Rekening <?php echo $isi[0]; ?></h3>
        </div>
        <div class="modal-body">
            <label>Id Rekening : <?php echo $isi[0]; ?></label>
            <input type="hidden" id="newidrek" value="<?php echo $isi[0]; ?>"><br>
            <label>Nama : </label>
            <textarea class="form-control" id="newnama"><?php echo $isi[1]; ?></textarea>
            <hr>
            <button type="button" class="btn btn-primary btn-lg btn-flat pull-right" id="update" style="margin-left: 20px">
            <i class="fa fa-save"></i> UPDATE</button>
            <button type="button" class="btn btn-warning pull-right" data-dismiss="modal"><i class="fa fa-close"></i> BATAL</button><br>
            <div id="hasil_update" style="display: none"></div>
            <br>
        </div>
    </div>
</div>