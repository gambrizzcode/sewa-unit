<?php
session_start();
ob_start();

ini_set("display_errors","off");

date_default_timezone_set('Asia/Jakarta');

/************************

|						|
|  By : Syaikhu Rizal	|
|						|	
|  ANMEDIACORP JEMBER	|
|						|

************************/

class sambung{
	private $host = "localhost";
	private $user = "root";
	private $pass = "";
	private $db   = "sewa_unit";
	function __construct(){
		mysql_connect($this->host,$this->user,$this->pass);
		mysql_select_db($this->db);
	}
}

class kerja{
	//________________________________________________________________________________________________________________________________
	function simpanPetugas($a,$b,$c,$d,$e,$f){
		mysql_query("INSERT INTO akun VALUES('$a','$b','$c','$d','$e','$f','')");
	}
	function hapusPetugas($a){
		mysql_query("DELETE FROM akun WHERE id_akun = '$a'");
	}
	function updatePetugas($a,$b,$c,$d,$e,$f){
		mysql_query("UPDATE akun SET nama_akun = '$b', username = '$c', password = '$d', level = '$e', status = '$f', ket = '' WHERE id_akun = '$a'");
	}
	//________________________________________________________________________________________________________________________________
	function simpanUnit($a,$b){
		mysql_query("INSERT INTO unit VALUES('$a','$b','')");
	}
	function hapusUnit($a){
		mysql_query("DELETE FROM unit WHERE id_unit = '$a'");
	}
	function updateUnit($a,$b){
		mysql_query("UPDATE unit SET nama_unit = '$b', ket = '' WHERE id_unit = '$a'");
	}
	//________________________________________________________________________________________________________________________________
	function simpanRek($a,$b){
		mysql_query("INSERT INTO rekening VALUES('$a','$b','')");
	}
	function hapusRek($a){
		mysql_query("DELETE FROM rekening WHERE id_rek = '$a'");
	}
	function updateRek($a,$b){
		mysql_query("UPDATE rekening SET nama_rek = '$b', ket = '' WHERE id_rek = '$a'");
	}
	//________________________________________________________________________________________________________________________________
	function simpanPel($a,$b,$c,$d,$e){
		mysql_query("INSERT INTO pelanggan VALUES('$a','$b','$c','$d','$e','')");
	}
	function hapusPel($a){
		mysql_query("DELETE FROM pelanggan WHERE id_pelanggan = '$a'");
	}
	function updatePel($a,$b,$c,$d){
		mysql_query("UPDATE pelanggan SET nama_pelanggan = '$b', alamat = '$c', telp = '$d', ket = '' WHERE id_pelanggan = '$a'");
	}
	function updatePiutangPel($a,$b){
		mysql_query("UPDATE pelanggan SET total_piutang = total_piutang+$b WHERE id_pelanggan = '$a'");
	}
	//________________________________________________________________________________________________________________________________
	function simpanTran($a,$b,$c,$d,$e,$f,$g,$h,$i,$j,$k,$l,$m,$n){
		mysql_query("INSERT INTO transaksi VALUES('$a','$b','$c','$d','$e','$f','$g','$h','$i','$j','$k','$l','$m','$n')");
	}
	function hapusTran($a){
		mysql_query("DELETE FROM transaksi WHERE id_transaksi = '$a'");
		mysql_query("DELETE FROM bayar WHERE id_transaksi = '$a'");
		mysql_query("DELETE FROM pengeluaran WHERE id_transaksi = '$a'");
	}
	function updateTran($a,$c,$d,$e,$f,$g,$h,$i,$j,$l,$m,$n){
		mysql_query("UPDATE transaksi SET id_pelanggan = '$c', id_unit = '$d', tgl_pelaksanaan = '$e', lama = '$f', harga = '$g', id_rek = '$h', dibayar = '$i', piutang = '$j', ket = '$l', id_akun = '$m', rek_piutang = '$n' WHERE id_transaksi = '$a'");
	}
	function updateBayar($a,$b,$c,$d,$f,$h){
		mysql_query("UPDATE bayar SET tgl_bayar = '$c', rek_debet = '$d', total = '$f', id_akun = '$h' WHERE id_transaksi = '$b' AND id_bayar = '$a'");
	}
	function updateDibayar($a,$b){
		mysql_query("UPDATE transaksi SET dibayar=dibayar+$b WHERE id_transaksi = '$a'");
	}
	function updatePiutangT($a,$b){
		mysql_query("UPDATE transaksi SET piutang=piutang-$b WHERE id_transaksi = '$a'");
	}
	function updateTotPiutangPel($a,$b){
		mysql_query("UPDATE pelanggan SET total_piutang=total_piutang-$b WHERE id_pelanggan = '$a'");
	}
	function updateLuarT($a,$b){
		mysql_query("UPDATE transaksi SET pengeluaran=pengeluaran+$b WHERE id_transaksi = '$a'");
	}
	function updateLuar($a,$b,$c,$d,$f,$h){
		mysql_query("UPDATE pengeluaran SET tgl_pengeluaran = '$c', rek_kredit = '$d', total = '$f', id_akun = '$h' WHERE id_transaksi = '$b' AND id_luar = '$a'");
	}
	function simpanBayar($a,$b,$c,$d,$e,$f,$g,$h){
		mysql_query("INSERT INTO bayar VALUES('$a','$b','$c','$d','$e','$f','$g','$h')");
	}
	function simpanLuar($a,$b,$c,$d,$e,$f,$g,$h){
		mysql_query("INSERT INTO pengeluaran VALUES('$a','$b','$c','$d','$e','$f','$g','$h')");
	}
	function ubahBayar($a,$b,$c,$d,$e,$f){
		mysql_query("UPDATE bayar SET tgl_bayar = '$b', rek_debet = '$c', rek_kredit = '$d', total = '$e', ket = '$f' WHERE id_bayar = '$a'");
	}
	function ubahLuar($a,$b,$c,$d,$e,$f){
		mysql_query("UPDATE pengeluaran SET tgl_pengeluaran = '$b', rek_debet = '$c', rek_kredit = '$d', total = '$e', ket = '$f' WHERE id_luar = '$a'");
	}
	//________________________________________________________________________________________________________________________________
	function simpanJurnal($a,$b,$c,$d,$e,$f){
		mysql_query("INSERT INTO jurnal VALUES('$a','$b','$c','$d','$e','$f')");
	}
	function updateJurnal($a,$b,$c,$d,$e,$f){
		mysql_query("UPDATE jurnal SET tanggal = '$b', rek_debet = '$c', rek_kredit = '$d', total = '$e', uraian = '$f' WHERE no_mutasi = '$a'");
	}
	//________________________________________________________________________________________________________________________________
	function simpanHutang($a,$b,$c,$d,$e,$f,$g,$h){
		mysql_query("INSERT INTO hutang VALUES('$a','$b','$c','$d','$e','$f','$g','$h')");
	}
	function hapusHutang($a){
		mysql_query("DELETE FROM hutang WHERE no_hutang = '$a'");
		mysql_query("DELETE FROM bayar_hutang WHERE no_hutang = '$a'");
	}
	function updateHutang($a,$b,$c,$d,$e,$f,$g,$h){
		mysql_query("UPDATE hutang SET tanggal = '$b', jenis = '$c', uraian = '$d', nominal = '$e', rek_debet = '$f', rek_kredit = '$g', jml_angsuran = '$h' WHERE no_hutang = '$a'");
	}
	function angsur($a,$b,$c,$d,$e,$f,$g,$h){
		mysql_query("INSERT INTO bayar_hutang VALUES('$a','$b','$c','$d','$e','$f','$g','$h')");
	}
	//________________________________________________________________________________________________________________________________
	function tranH(){
		$tgl  = date('Y-m-d');
		$data = mysql_query("SELECT COUNT(id_transaksi) AS jumlah FROM transaksi WHERE tanggal = '$tgl'");
		$isi  = mysql_fetch_array($data);
		if ($isi[0] == null) {
			echo "0";
		}else{
			echo $isi[0];
		}
	}
	function kotorH(){
		$tgl  = date('Y-m-d');
		$data = mysql_query("SELECT SUM(harga) AS harga FROM transaksi WHERE tanggal = '$tgl'");
		$isi  = mysql_fetch_array($data);
		if ($isi[0] == null) {
			echo "0";
		}else{
			echo "Rp. ".number_format($isi[0],0,",",".");
		}
	}
	function keluarH(){
		$tgl  = date('Y-m-d');
		$data = mysql_query("SELECT SUM(total) AS keluar FROM pengeluaran WHERE tgl_pengeluaran = '$tgl'");
		$isi  = mysql_fetch_array($data);
		if ($isi[0] == null) {
			echo "0";
		}else{
			echo "Rp. ".number_format($isi[0],0,",",".");
		}
	}
	function bersihH(){
		$tgl   = date('Y-m-d');
		$data1 = mysql_query("SELECT SUM(harga) AS harga FROM transaksi WHERE tanggal = '$tgl'");
		$isi1  = mysql_fetch_array($data1);

		$data2 = mysql_query("SELECT SUM(total) AS keluar FROM pengeluaran WHERE tgl_pengeluaran = '$tgl'");
		$isi2  = mysql_fetch_array($data2);

		$jadi  = $isi1[0]-$isi2[0];
		if ($jadi == null || $jadi == "0") {
			echo "Rp. 0";
		}elseif($jadi < 0){
			echo "(Rp. ".number_format($jadi,0,",",".").")";
		}else{
			echo "Rp. ".number_format($jadi,0,",",".");
		}
	}
	//________________________________________________________________________________________________________________________________
	function simpanBukuBesar($a,$b,$c,$d,$e,$f){
		mysql_query("INSERT INTO buku_besar VALUES('','$a','$b','$c','$d','$e','$f')");
	}
	function hapusBukuBesar($a){
		mysql_query("DELETE FROM buku_besar WHERE no_mutasi = '$a'");
	}
	function updateBukuBesar($a,$b,$c,$d,$e,$f){
		mysql_query("UPDATE buku_besar SET tanggal = '$b', uraian = '$c', rek_debet = '$d', rek_kredit = '$e', total = '$f' WHERE no_mutasi = '$a'");
	}
	//________________________________________________________________________________________________________________________________
}