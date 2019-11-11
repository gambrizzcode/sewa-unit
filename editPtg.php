<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$data = mysql_query("SELECT * FROM akun WHERE id_akun = '$_GET[idakun]'");
$isi = mysql_fetch_array($data);
?>
		<div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3><i class="fa fa-user"></i> Edit Petugas <?php echo $isi[0]; ?></h3>
                </div>
                <div class="modal-body">
                    <label>Id Petugas : <?php echo $isi[0]; ?></label>
                    <input type="hidden" name="idakun" id="newidakun" value="<?php echo $isi[0]; ?>"><br>
                    <label>Nama : </label>
                    <input type="text" class="form-control" name="nama" id="newnama" value="<?php echo $isi[1]; ?>"><br>
                    <label>Username : </label>
                    <input type="text" class="form-control" name="username" id="newusername" value="<?php echo $isi[2]; ?>"><br>
                    <label>Password : </label>
                    <input type="password" class="form-control" name="password" id="newpassword" value="<?php echo $isi[3]; ?>">
                    <div id="ketpass">
        
                    </div>
                    <br>
                    <label>Konfirmasi Password : </label>
                    <input type="password" class="form-control" name="konpass" id="newkonpass" value="<?php echo $isi[3]; ?>"><br>
                    <label>Level : </label>
                    <select class="form-control" name="level" id="newlevel">
                        <option value="">--- Pilih ---</option>
                        <option <?php if($isi[4] == "PETUGAS"){echo "selected";} ?> value="PETUGAS">PETUGAS</option>
                        <option <?php if($isi[4] == "ADMIN"){echo "selected";} ?> value="ADMIN">ADMIN</option>
                    </select><br>
                    <label>Status : </label>
                    <select class="form-control" name="status" id="newstatus">
                        <option value="">--- Pilih ---</option>
                        <option <?php if($isi[5] == "1"){echo "selected";} ?> value="1">AKTIF</option>
                        <option <?php if($isi[5] == "0"){echo "selected";} ?> value="0">TIDAK AKTIF</option>
                    </select><hr>
                    <button type="button" class="btn btn-primary btn-lg btn-flat pull-right" id="update" style="margin-left: 20px"><i class="fa fa-save"></i> UPDATE</button>
                    <button type="button" class="btn btn-warning pull-right" data-dismiss="modal"><i class="fa fa-close"></i> BATAL</button><br>
                    <div id="hasil_update" style="display: none"></div>
                    <br>
                </div>
            </div>
        </div>