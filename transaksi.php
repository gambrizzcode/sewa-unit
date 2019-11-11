<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

if (!$_SESSION['id_akun'] || $_SESSION['id_akun'] == "") {
	header("location:index.php");
}else{
	$qakun = mysql_query("SELECT * FROM akun WHERE id_akun = '$_SESSION[id_akun]'");
	$rakun = mysql_fetch_array($qakun);
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>Transaksi | SewaUnit</title>
	<link rel="icon" href="assets/favicon.png">
	<link href="assets/css/bootstrap.css" rel="stylesheet" />
	<link href="assets/css/font-awesome.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet" />
	<link href="datatables/dataTables.bootstrap.css" rel="stylesheet" />
	<link href="assets/select2/select2.min.css" rel="stylesheet">
</head>
<!-- Author : Syaikhu Rizal -->
<body>
	<header>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<strong>Nama Perusahaan Persewaan</strong>
					&nbsp;&nbsp;
					alamat dan nomor telepon / hp
				</div>
			</div>
		</div>
	</header>

	<div class="navbar navbar-inverse set-radius-zero">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand">
					<h1 style="color:cyan;cursor:default"><b>SewaUnit</b></h1>
				</a>
			</div>

			<div class="left-div">
				<div class="user-settings-wrapper">
					<ul class="nav">
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
								<span class="glyphicon glyphicon-user" style="font-size: 25px;"></span>
							</a>
							<div class="dropdown-menu dropdown-settings">
								<div class="media">
									<h4 class="media-heading"><?php echo $rakun['nama_akun']; ?></h4>
									<h5><?php echo $rakun['level']; ?></h5>
								</div>
								<hr />
								<a href="logout.php" class="btn btn-danger btn-block btn-sm">Logout</a>
							</div>
						</li>
					</ul>
				</div>
			</div>

		</div>
	</div>

	<section class="menu-section">
        <?php
        if ($rakun['level'] == 'ADMIN') {
        }else{echo "<div class='container'>";};
        ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <?php
                            if ($rakun['level'] == 'ADMIN') { ?>
                                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                                <li><a class="menu-top-active" href="transaksi.php"><i class="fa fa-money"></i> Transaksi</a></li>
                                <li><a href="unit.php"><i class="fa fa-suitcase"></i> Unit</a></li>
                                <li><a href="rekening.php"><i class="fa fa-ticket"></i> Rekening</a></li>
                                <li><a href="pelanggan.php"><i class="fa fa-users"></i> Pelanggan</a></li>
                                <li><a href="jurnalumum.php"><i class="fa fa-file-text-o"></i> Jurnal Umum</a></li>
                                <li><a href="hutang.php"><i class="fa fa-minus-square-o"></i> Hutang</a></li>
                                <li><a href="bukubesar.php"><i class="fa fa-book"></i> Buku Besar</a></li>
                                <li><a href="pendapatan.php"><i class="fa fa-bar-chart-o"></i> Pendapatan Unit</a></li>
                                <li><a href="petugas.php"><i class="fa fa-user"></i> Petugas</a></li>
                            <?php
                            }else{ ?>
                                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                                <li><a href="bukubesar.php"><i class="fa fa-book"></i> Buku Besar</a></li>
                                <li><a href="pendapatan.php"><i class="fa fa-bar-chart-o"></i> Pendapatan Unit</a></li>
                            <?php
                            };
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php
        if ($rakun['level'] == 'ADMIN') {
        }else{echo "</div>";};
        ?>
    </section>

	<div class="modal fade" id="modalTambah" data-backdrop="static" data-keyboard="false" tata-attention-animation="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3><i class="fa fa-suitcase"></i> SEWAAAAA... !!</h3>
                </div>
                <div class="modal-body">
                	<?php
                	$nota = strtoupper("TR/".substr(md5(time()),0,6));
                	?>
                    <label>Id Transaksi : <?php echo $nota; ?></label>
                    <input type="hidden" id="idtran" value="<?php echo $nota; ?>"> || 
                    <label>Tanggal : <?php echo date('d-m-Y'); ?></label>
                    <input type="hidden" id="tanggal" value="<?php echo date('Y-m-d'); ?>">
                    <input type="hidden" id="idakun" value="<?php echo $rakun[0]; ?>">
                    <input type="hidden" id="id_bayar" value="<?php echo substr(md5(time()),0,8); ?>">
                    <input type="hidden" id="id_luar" value="<?php echo substr(md5(time()),0,8); ?>"><br>
                    <label>Pelanggan : </label>
                    <div class="form-group">
                    <select class="form-control select2" id="idpel" style="width: 100%;">
                    	<option value="">--- Pilih Pelanggan ---</option>
                    	<?php
                    	$qpel = mysql_query("SELECT * FROM pelanggan");
                    	while ($rpel = mysql_fetch_array($qpel)) { ?>
                    		<option value="<?php echo $rpel[0]; ?>"><?php echo $rpel[1]." - ".$rpel[2]." - ".$rpel[3]; ?></option>
                    	<?php } ?>
                    </select>
                    </div>
                    <label>Pilih Unit : </label>
                    <select class="form-control select2" id="idunit" style="width: 100%">
                    	<option value="">--- Pilih Unit ---</option>
                    	<?php
                    	$qunit = mysql_query("SELECT * FROM unit");
                    	while ($runit = mysql_fetch_array($qunit)) { ?>
                    		<option value="<?php echo $runit[0]; ?>"><?php echo $runit[1]; ?></option>
                    	<?php } ?>
                    </select>
                    <label>Tanggal Mulai Pelaksanaan : </label>
                    <input type="date" id="tgl_pelaksanaan" class="form-control">
                    <label>Lama Sewa : </label>
                    <input type="text" class="form-control" id="lama" placeholder="Hari">
                    <div class="row">
                    	<div class="col-md-6">
                    		<label>Harga : </label>
                    		<input type="text" class="form-control" id="harga">
                    	</div>
                    	<div class="col-md-6">
                    		<label>Rekening : </label>
		                    <select class="form-control select2" id="idrek" style="width: 100%">
		                    	<option value="">--- Pilih Rekening ---</option>
		                    	<?php
		                    	$qrek = mysql_query("SELECT * FROM rekening");
		                    	while ($rrek = mysql_fetch_array($qrek)) { ?>
		                    		<option value="<?php echo $rrek[0]; ?>"><?php echo $rrek[1]; ?></option>
		                    	<?php } ?>
		                    </select>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-md-6">
                    		<label>Dibayar : </label>
                    		<input type="text" class="form-control" id="dibayar">
                    	</div>
                    	<div class="col-md-6">
                    		<label>Rekening : </label>
                    		<select class="form-control select2" id="rekdp" style="width: 100%">
		                    	<option value="">--- Pilih Rekening ---</option>
		                    	<?php
		                    	$qrek = mysql_query("SELECT * FROM rekening");
		                    	while ($rrek = mysql_fetch_array($qrek)) { ?>
		                    		<option value="<?php echo $rrek[0]; ?>"><?php echo $rrek[1]; ?></option>
		                    	<?php } ?>
		                    </select>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-md-6">
                    		<label>Piutang : </label>
                    		<input type="text" class="form-control" id="piutang" readonly>
                    	</div>
                    	<div class="col-md-6">
                    		<label>Rekening : </label>
                    		<select class="form-control select2" id="rek_piutang" style="width: 100%">
		                    	<option value="">--- Pilih Rekening ---</option>
		                    	<?php
		                    	$qrek = mysql_query("SELECT * FROM rekening");
		                    	while ($rrek = mysql_fetch_array($qrek)) { ?>
		                    		<option value="<?php echo $rrek[0]; ?>"><?php echo $rrek[1]; ?></option>
		                    	<?php } ?>
		                    </select>
                    	</div>
                    </div>
                    <label>Uraian / Keterangan Tambahan : </label>
                    <input type="text" class="form-control" id="ket">
                    <hr>
                    <button type="button" class="btn btn-primary btn-lg btn-flat pull-right" id="simpan" style="margin-left: 20px"><i class="fa fa-save"></i> SIMPAN</button>
                    <button type="button" class="btn btn-warning pull-right" data-dismiss="modal"><i class="fa fa-close"></i> BATAL</button><br>
                    <div id="hasil_simpan" style="display: none"></div>
                    <br>
                </div>
            </div>
        </div>
    </div>

	<div class="content-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3>
								<i class="fa fa-money"></i> Data Transaksi
								<button type="button" class="btn btn-success btn-lg btn-flat" style="margin-left: 700px;padding-left: 70px;padding-right: 70px" data-toggle="modal" data-target="#modalTambah">
									<i class="fa fa-plus"></i> Sewa
								</button>
							</h3>
							<div class="row" align="right">
								<div class="col-md-12 form-inline">
									Filter Unit : <select id="filunit" class="form-control select2" style="max-width: 260px">
										<option value="">--- Semua Unit ---</option>
										<?php
										$qfunit = mysql_query("SELECT * FROM unit");
										while ($funit = mysql_fetch_array($qfunit)) { ?>
										<option <?php if($_REQUEST['unit'] == $funit[0]){echo "selected";}else{} ?> value="<?php echo $funit[0]; ?>"><?php echo $funit[1]; ?></option>
										<?php } ?>
									</select>
									&nbsp;
									Dari Tanggal : <input type="date" class="form-control" id="dari" <?php if(!$_REQUEST['dari']){}else{echo "value='".$_REQUEST['dari']."'";} ?>>
									&nbsp;
									Sampai Tanggal : <input type="date" class="form-control" id="ke" <?php if(!$_REQUEST['ke']){}else{echo "value='".$_REQUEST['ke']."'";} ?>>
									<button type="button" class="btn btn-flat btn-warning" id="go"><i class="fa fa-search"></i> GO !!</button>
									&nbsp;
									<button type="button" class="btn btn-flat btn-info" id="prin"><i class="fa fa-print"></i> PRINT</button>
								</div>
							</div>
						</div>
						<div class="panel-body">
						<!-- table-responsive ,tambahkan itu  ke panel-body jika pengen ada scroll.x di datatable.x -->
							<table style="font-size: 13px" id="tbl_transaksi" class="table table-condensed table-hovered table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Id Transaksi</th>
										<th>Tanggal</th>
										<th>Pelanggan</th>
										<th>Unit</th>
										<th>Ket</th>
										<th>Harga Sewa</th>
										<th>Dibayar</th>
										<th>Sisa Piutang</th>
										<th>Pengeluaran</th>
										<th>Pendapatan Sewa (Berjalan)</th>
										<th>Pendapatan Saat Ini</th>
										<th>Opsi</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 1;
									if (!$_REQUEST['dari'] || !$_REQUEST['ke'] || $_REQUEST['dari'] == "" || $_REQUEST['ke'] == "") {
										if (!$_REQUEST['unit'] || $_REQUEST['unit'] == "") {
											$datatran = mysql_query("SELECT * FROM transaksi INNER JOIN pelanggan ON transaksi.id_pelanggan = pelanggan.id_pelanggan INNER JOIN unit ON transaksi.id_unit = unit.id_unit ORDER BY transaksi.id_transaksi");	
										}
										else{
											$datatran = mysql_query("SELECT * FROM transaksi INNER JOIN pelanggan ON transaksi.id_pelanggan = pelanggan.id_pelanggan INNER JOIN unit ON transaksi.id_unit = unit.id_unit WHERE unit.id_unit = '$_REQUEST[unit]' ORDER BY transaksi.id_transaksi");	
										}
									}else{
										if (!$_REQUEST['unit'] || $_REQUEST['unit'] == "") {
											$datatran = mysql_query("SELECT * FROM transaksi INNER JOIN pelanggan ON transaksi.id_pelanggan = pelanggan.id_pelanggan INNER JOIN unit ON transaksi.id_unit = unit.id_unit WHERE tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]' ORDER BY transaksi.id_transaksi");
										}else{
											$datatran = mysql_query("SELECT * FROM transaksi INNER JOIN pelanggan ON transaksi.id_pelanggan = pelanggan.id_pelanggan INNER JOIN unit ON transaksi.id_unit = unit.id_unit WHERE tanggal BETWEEN '$_REQUEST[dari]' AND '$_REQUEST[ke]' AND unit.id_unit = '$_REQUEST[unit]' ORDER BY transaksi.id_transaksi");
										}
									}
									while ($isitran = mysql_fetch_array($datatran)) {
										$qbayaro = mysql_query("SELECT SUM(total) FROM bayar WHERE id_transaksi = '$isitran[0]'");
										$rbayaro = mysql_fetch_array($qbayaro);
										if ($isitran['harga']-$rbayaro[0] == "0") {
											$warna = "green";
										}else{
											$warna = "red";
										}
									?>
									<tr>
										<td><?php echo $no++; ?></td>
										<td><?php echo $isitran['id_transaksi']; ?></td>
										<td><?php echo date('d-m-Y',strtotime($isitran['tanggal'])); ?></td>
										<td><?php echo $isitran['nama_pelanggan']; ?></td>
										<td><?php echo $isitran['nama_unit']; ?></td>
										<td><?php echo $isitran[11]; ?></td>
										<td><?php echo "<b>Rp. ".number_format($isitran['harga'],0,",",".")."</b>"; ?></td>
										<td><?php
										$qtotdibayar = mysql_query("SELECT SUM(total) FROM bayar WHERE id_transaksi = '$isitran[0]'");
										$rtotdibayar = mysql_fetch_array($qtotdibayar);
										echo "<b>Rp. ".number_format($rtotdibayar[0],0,",",".")."</b>";
										// echo "<b>Rp. ".number_format($isitran['dibayar'],0,",",".")."</b>";
										?></td>
										<td><?php echo "<b style='color:".$warna."'>Rp. ".number_format($isitran['harga']-$rtotdibayar[0],0,",",".")."</b>"; ?></td>
										<td><?php
										$qtotdiluar = mysql_query("SELECT SUM(total) FROM pengeluaran WHERE id_transaksi = '$isitran[0]'");
										$rtotdiluar = mysql_fetch_array($qtotdiluar);
										echo "<b>Rp. ".number_format($rtotdiluar[0],0,",",".")."</b>";
										// echo "<b>Rp. ".number_format($isitran['pengeluaran'],0,",",".")."</b>";
										?></td>
										<td><?php echo "<b>Rp. ".number_format($isitran['harga']-$rtotdiluar[0],0,",",".")."</b>"; ?></td>
										<td><?php echo "<b>Rp. ".number_format($rtotdibayar[0]-$rtotdiluar[0],0,",",".");"</b>"; ?></td>
										<td>
											<div class="dropdown">
												<button class="btn btn-danger dropdown-toggle btn-xs" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
													Opsi
													<span class="caret"></span>
												</button>
												<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
													<li role="presentation">
														<a role="menuitem" href="javascript:;">
															<button type="button" style="min-width: 120px" class="btn btn-xs btn-flat btn-primary buka_modal_detail" id="<?php echo $isitran[0]; ?>">
																<i class="fa fa-exclamation"></i> Detail
															</button>
														</a>
													</li>
													<li role="presentation">
														<a role="menuitem" href="javascript:;">
															<button type="button" style="min-width: 120px" class="btn btn-xs btn-flat btn-warning buka_modal_edit" id="<?php echo $isitran[0]; ?>">
																<i class="fa fa-edit"></i> Edit
															</button>
														</a>
													</li>
													<li role="presentation">
														<a role="menuitem" href="javascript:;">
															<button type="button" style="min-width: 120px" class="btn btn-danger btn-xs btn-flat" data-toggle="modal" data-target="#hapus<?php echo md5($isitran[0]); ?>"><span class="fa fa-trash"></span> Hapus</button>
														</a>
													</li>
													<li role="presentation">
														<a role="menuitem" href="javascript:;">
															<button type="button" style="min-width: 120px" class="btn btn-xs btn-flat btn-success buka_modal_bayar" id="<?php echo $isitran[0]; ?>">
																<i class="fa fa-money"></i> Bayar
															</button>
														</a>
													</li>
													<li role="presentation">
														<a role="menuitem" href="javascript:;">
															<button type="button" style="min-width: 120px" class="btn btn-xs btn-flat btn-info buka_modal_keluar" id="<?php echo $isitran[0]; ?>">
																<i class="fa fa-upload"></i> Pengeluaran
															</button>
														</a>
													</li>
													<li role="presentation">
														<a role="menuitem" href="printLaporan.php?idtran=<?php echo $isitran[0]; ?>" target="_blank">
															<button type="button" style="min-width: 120px" class="btn btn-xs btn-flat btn-default">
																<i class="fa fa-print"></i> Print Laporan
															</button>
														</a>
													</li>
													<li role="presentation">
														<a role="menuitem" href="printNota.php?idtran=<?php echo $isitran[0]; ?>" target="_blank">
															<button type="button" style="min-width: 120px" class="btn btn-xs btn-flat btn-default">
																<i class="fa fa-print"></i> Print Nota
															</button>
														</a>
													</li>
												</ul>
												<div class="modal fade" id="hapus<?php echo md5($isitran[0]); ?>" role="dialog">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
																<center><h3 class="modal-title">YAKIN HAPUS <i class="fa fa-question"></i></h3></center>
																</div>
																<div class="modal-body" align="center">
																<a href="hapusTran.php?id_tran=<?php echo $isitran[0]; ?>"><button type="button" class="btn btn-danger"><span class="fa fa-trash"></span> HAPUS</button></a>
																&nbsp;&nbsp;&nbsp;
																<button type="button" class="btn btn-warning" data-dismiss="modal">CANCEL</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="modalEditTran" data-backdrop="static" data-keyboard="false" tata-attention-animation="true" aria-labelledby="myModalLabel" aria-hidden="true"></div>

			<div class="modal fade" id="modalDetail" data-backdrop="static" data-keyboard="false" tata-attention-animation="true" aria-labelledby="myModalLabel" aria-hidden="true"></div>

			<div class="modal fade" id="modalBayar" data-backdrop="static" data-keyboard="false" tata-attention-animation="true" aria-labelledby="myModalLabel" aria-hidden="true"></div>

			<div class="modal fade" id="modalKeluar" data-backdrop="static" data-keyboard="false" tata-attention-animation="true" aria-labelledby="myModalLabel" aria-hidden="true"></div>

			<!-- <div class="row">
				<div class="col-md-12">
			
				</div>
			</div> -->
		</div>
	</div>

	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					&copy; Copyright 2017 | By : Syaikhu Rizal, ANMEDIACORP JEMBER
				</div>
			</div>
		</div>
	</footer>

<script src="assets/js/jquery-1.11.1.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="datatables/jquery.dataTables.min.js"></script>
<script src="datatables/dataTables.bootstrap.min.js"></script>
<script src="assets/select2/select2.full.min.js"></script>
<script>
$(function(){
	$('.buka_modal_edit').click(function() {
        var id = $(this).attr('id');
        var idakun = $('#idakun').val();
        $.ajax({
            url: 'editTran.php',
            type: 'GET',
            data: "idtran="+id+"&idakun="+idakun,
            success:function(edit){
                $('#modalEditTran').html(edit);
                $('#modalEditTran').modal('show',{backdorp:'true'});
                $(".select2").select2();
            }
        });
    });
	$('.buka_modal_bayar').click(function() {
        var id = $(this).attr('id');
        var idakun = $('#idakun').val();
        $.ajax({
            url: 'editBayar.php',
            type: 'GET',
            data: "idtran="+id+"&idakun="+idakun,
            success:function(edit){
                $('#modalBayar').html(edit);
                $('#modalBayar').modal('show',{backdorp:'true'});
                $(".select2").select2();
            }
        });
    });
	$('.buka_modal_keluar').click(function() {
        var id = $(this).attr('id');
        var idakun = $('#idakun').val();
        $.ajax({
            url: 'editLuar.php',
            type: 'GET',
            data: "idtran="+id+"&idakun="+idakun,
            success:function(edit){
                $('#modalKeluar').html(edit);
                $('#modalKeluar').modal('show',{backdorp:'true'});
                $(".select2").select2();
            }
        });
    });
	$('.buka_modal_detail').click(function() {
        var id = $(this).attr('id');
        $.ajax({
            url: 'detail.php',
            type: 'GET',
            data: "idtran="+id,
            success:function(edit){
                $('#modalDetail').html(edit);
                $('#modalDetail').modal('show',{backdorp:'true'});
                $(".select2").select2();

                $('.buka_modal_edit_bayar').click(function(){
                	var aidi = $(this).attr('id');
                	$.ajax({
                		url : 'editbayar2.php',
                		type : 'GET',
                		data : 'id_bayar='+aidi,
                		success:function(editbayar2){
                			$('#modalEditBayar').html(editbayar2);
                			$('#modalEditBayar').modal('show',{backdorp:'true'});
                			$(".select2").select2();
                		}
                	});
                });
                $('.buka_modal_edit_luar').click(function(){
                	var aidu = $(this).attr('id');
                	$.ajax({
                		url : 'editluar2.php',
                		type : 'GET',
                		data : 'id_luar='+aidu,
                		success:function(editluar2){
                			$('#modalEditKeluar').html(editluar2);
                			$('#modalEditKeluar').modal('show',{backdorp:'true'});
                			$(".select2").select2();
                		}
                	});
                });

            }
        });
    });
});
$(document).ready(function() {
	$(".select2").select2();
	$('#tbl_transaksi').DataTable();

	$('#dibayar').keyup(function() {
		var harga = parseInt($('#harga').val());
		var dibayar = parseInt($(this).val());
		piutang = harga-dibayar;
		$('#piutang').val(piutang);
	});
	$('#dibayar').keydown(function() {
		var harga = parseInt($('#harga').val());
		var dibayar = parseInt($(this).val());
		piutang = harga-dibayar;
		$('#piutang').val(piutang);
	});
	$('#dibayar').focusout(function() {
		var harga = parseInt($('#harga').val());
		var dibayar = parseInt($(this).val());
		piutang = harga-dibayar;
		$('#piutang').val(piutang);
	});

    $('#simpan').click(function() {
        var dataa = {
            idtran			: $('#idtran').val(),
            tanggal 		: $('#tanggal').val(),
            idpel			: $('#idpel').val(),
            idunit			: $('#idunit').val(),
            tgl_pelaksanaan : $('#tgl_pelaksanaan').val(),
            lama 			: $('#lama').val(),
            harga			: $('#harga').val(),
            idrek			: $('#idrek').val(),
            rekdp 			: $('#rekdp').val(),
            rekluar 		: $('#rekluar').val(),
            dibayar 		: $('#dibayar').val(),
            piutang 		: $('#piutang').val(),
            ket 			: $('#ket').val(),
            idakun			: $('#idakun').val(),
            id_bayar 		: $('#id_bayar').val(),
            id_luar 		: $('#id_luar').val(),
            rek_piutang 	: $('#rek_piutang').val()
        };
        $.ajax({
            url: 'simpanTran.php',
            type: 'GET',
            data: dataa,
            success:function(simpan){
                $('#hasil_simpan').html(simpan);
                window.location="transaksi.php";
            }
        });
    });

    $('.buka_modal_edit').click(function() {
        var id = $(this).attr('id');
        var idakun = $('#idakun').val();
        $.ajax({
            url: 'editTran.php',
            type: 'GET',
            data: "idtran="+id+"&idakun="+idakun,
            success:function(edit){
                $('#modalEditTran').html(edit);
                $('#modalEditTran').modal('show',{backdorp:'true'});
                $(".select2").select2();
            }
        });
    });

    $('#modalEditTran').mouseenter(function() {
    	$('#newdibayar').keyup(function() {
			var harga = parseInt($('#newharga').val());
			var dibayar = parseInt($(this).val());
			piutang = harga-dibayar;
			$('#newpiutang').val(piutang);
		});
		$('#newdibayar').keydown(function() {
			var harga = parseInt($('#newharga').val());
			var dibayar = parseInt($(this).val());
			piutang = harga-dibayar;
			$('#newpiutang').val(piutang);
		});
		$('#newdibayar').focusout(function() {
			var harga = parseInt($('#newharga').val());
			var dibayar = parseInt($(this).val());
			piutang = harga-dibayar;
			$('#newpiutang').val(piutang);
		});

        $('#update').click(function() {
            var datau = {
	            newidtran			: $('#newidtran').val(),
	            newtanggal 			: $('#newtanggal').val(),
	            newidpel			: $('#newidpel').val(),
	            newidunit			: $('#newidunit').val(),
	            newtgl_pelaksanaan 	: $('#newtgl_pelaksanaan').val(),
	            newlama 			: $('#newlama').val(),
	            newharga			: $('#newharga').val(),
	            newidrek			: $('#newidrek').val(),
	            newrekdp 			: $('#newrekdp').val(),
            	newrekluar 			: $('#newrekluar').val(),
	            newdibayar 			: $('#newdibayar').val(),
	            newpiutang 			: $('#newpiutang').val(),
	            newket 				: $('#newket').val(),
	            newidakun			: $('#newidakun').val(),
	            newidbayar			: $('#newidbayar').val(),
            	newidluar 			: $('#newidluar').val(),
            	newrek_piutang 		: $('#newrek_piutang').val()
	        };
            $.ajax({
                url: 'updateTran.php',
                type: 'GET',
                data: datau,
                success:function(update){
                    $('#hasil_update').html(update);
                    window.location="transaksi.php";
                }
            });
        });
    });

    $('.buka_modal_bayar').click(function() {
        var id = $(this).attr('id');
        var idakun = $('#idakun').val();
        $.ajax({
            url: 'editBayar.php',
            type: 'GET',
            data: "idtran="+id+"&idakun="+idakun,
            success:function(edit){
                $('#modalBayar').html(edit);
                $('#modalBayar').modal('show',{backdorp:'true'});
                $(".select2").select2();
            }
        });
    });

    $('.buka_modal_keluar').click(function() {
        var id = $(this).attr('id');
        var idakun = $('#idakun').val();
        $.ajax({
            url: 'editLuar.php',
            type: 'GET',
            data: "idtran="+id+"&idakun="+idakun,
            success:function(edit){
                $('#modalKeluar').html(edit);
                $('#modalKeluar').modal('show',{backdorp:'true'});
                $(".select2").select2();
            }
        });
    });

    $('.buka_modal_detail').click(function() {
        var id = $(this).attr('id');
        $.ajax({
            url: 'detail.php',
            type: 'GET',
            data: "idtran="+id,
            success:function(edit){
                $('#modalDetail').html(edit);
                $('#modalDetail').modal('show',{backdorp:'true'});
                $(".select2").select2();

                $('.buka_modal_edit_bayar').click(function(){
                	var aidi = $(this).attr('id');
                	$.ajax({
                		url : 'editbayar2.php',
                		type : 'GET',
                		data : 'id_bayar='+aidi,
                		success:function(editbayar2){
                			$('#modalEditBayar').html(editbayar2);
                			$('#modalEditBayar').modal('show',{backdorp:'true'});
                			$(".select2").select2();
                		}
                	});
                });
                $('.buka_modal_edit_luar').click(function(){
                	var aidu = $(this).attr('id');
                	$.ajax({
                		url : 'editluar2.php',
                		type : 'GET',
                		data : 'id_luar='+aidu,
                		success:function(editluar2){
                			$('#modalEditKeluar').html(editluar2);
                			$('#modalEditKeluar').modal('show',{backdorp:'true'});
                			$(".select2").select2();
                		}
                	});
                });
            }
        });
    });

    $('#go').click(function() {
		var dari = $('#dari').val();
		var ke 	 = $('#ke').val();
		var fun  = $('#filunit').val();
		window.location="transaksi.php?dari="+dari+"&ke="+ke+"&unit="+fun;
	});

	$('#prin').click(function() {
		var dari = $('#dari').val();
		var ke 	 = $('#ke').val();
		var fun  = $('#filunit').val();
		window.location="printTransaksi.php?dari="+dari+"&ke="+ke+"&unit="+fun;
	});

});
</script>
</body>
</html>
