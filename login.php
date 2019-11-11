<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>Login | SewaUnit</title>
	<link rel="icon" href="assets/favicon.png">
	<link href="assets/css/bootstrap.css" rel="stylesheet" />
	<link href="assets/css/font-awesome.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet" />
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
				
			</div>
			<div class="left-div">
				<h1 style="color:cyan;cursor:default"><img src="assets/favicon.png" style="max-width: 50px;margin-right: 20px"><b>SewaUnit</b></h1>
			</div>
		</div>
	</div>

	<div class="content-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h4 class="page-head-line">Silahkan Login Terlebih Dahulu</h4>
				</div>

			</div>
			<div class="row">
				<div class="col-md-6">
						<label>Masukkan Username : </label>
							<input type="text" class="form-control" id="username"><br>
						<label>Masukkan Password :  </label>
							<input type="password" class="form-control" id="password">
						<hr>
						<button type="button" class="btn btn-info btn-lg" id="masuk"><span class="glyphicon glyphicon-user"></span> &nbsp;MASUK</button>&nbsp;<hr>
						<!-- <div id="kotak"></div> -->
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-12" id="loading"><h1 align="center"><i class="fa fa-spinner fa-spin"></i></h1></div>
						<br>
						<div class="col-md-12" id="kotak"></div>
					</div>
				</div>
			</div>
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
	<script>
	$(document).ready(function() {
		$("input[id='username']").focus();
		$('#loading').hide();
		$('#masuk').click(function() {
			var data = {
				username : $("#username").val(),
				password : $("#password").val()
			};
			$('#loading').fadeIn(500);
			$.ajax({
				url: 'login_do.php',
				type: 'GET',
				data: data,
				success:function(data){
					$('#kotak').html(data);
					if ($('#uhu').text() == "Berhasil Login !! ") {
						window.location="dashboard.php";
					}else{
						$('#loading').fadeOut(500);
					}
				}
			});
		});
	});
	</script>
</body>
</html>
