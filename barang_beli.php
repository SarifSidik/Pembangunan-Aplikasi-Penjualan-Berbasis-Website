<?php
include_once "inc.session.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";


$KodePelanggan	= $_SESSION['SES_PELANGGAN'];

if(isset($_GET['Kode'])) {
	
	$Kode = $_GET['Kode'];
	
	
	$cekSql = "SELECT * FROM tmp_keranjang WHERE kd_barang='$Kode' AND kd_pelanggan='$KodePelanggan'";
	$cekQry = mysql_query($cekSql, $koneksidb) or die ("Cek data barang".mysql_error());
	if(mysql_num_rows($cekQry) >=1) {
		
		$mySql = "UPDATE tmp_keranjang SET jumlah=jumlah + 1 WHERE kd_barang='$Kode' AND kd_pelanggan='$KodePelanggan'";

	}
	else {
		
		$mySql = "SELECT * FROM barang WHERE kd_barang='$Kode'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal ambil data barang".mysql_error());
		$myData = mysql_fetch_array($myQry);
		
		
		$hargaModal	= $myData['harga_modal'];
		$hargaJual	= $myData['harga_jual'];
		$tanggal	= date('Y-m-d');
		
		
		$mySql	= "INSERT INTO tmp_keranjang (kd_barang, harga, jumlah, tanggal, kd_pelanggan) 
					VALUES('$Kode', '$hargaJual', '1', '$tanggal', '$KodePelanggan')";
	}
	
	
	$myQry = mysql_query($mySql, $koneksidb) or die ("Error".mysql_error());
	if ($myQry) {
		echo "<meta http-equiv='refresh' content='0; url=?open=Keranjang-Belanja'>";
	}
}

?>
