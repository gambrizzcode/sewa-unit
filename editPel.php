<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$data = mysql_query("SELECT * FROM pelanggan WHERE id_pelanggan = '$_GET[idpel]'");
$isi = mysql_fetch_array($data);
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3><i class="fa fa-suitcase"></i> Edit Pelanggan <?php echo $isi[0]; ?></h3>
        </div>
        <div class="modal-body">
            <label>Id Pelanggan : <?php echo $isi[0]; ?></label>
            <input type="hidden" id="newidpel" value="<?php echo $isi[0]; ?>"><br>
            <label>Nama : </label>
            <input type="text" id="newnama" class="form-control" value="<?php echo $isi[1]; ?>"><br>
            <label>Alamat : </label>
            <textarea class="form-control" id="newalamat"><?php echo $isi[2]; ?></textarea><br>
            <label>Telepon : </label>
            <input type="text" id="newtelp" class="form-control" value="<?php echo $isi[3]; ?>">
            <hr>
            <button type="button" class="btn btn-primary btn-lg btn-flat pull-right" id="update" style="margin-left: 20px">
            <i class="fa fa-save"></i> UPDATE</button>
            <button type="button" class="btn btn-warning pull-right" data-dismiss="modal"><i class="fa fa-close"></i> BATAL</button><br>
            <div id="hasil_update" style="display: none"></div>
            <br>
        </div>
    </div>
</div>