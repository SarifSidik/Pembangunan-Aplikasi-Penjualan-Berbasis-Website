<?php

include_once "../library/inc.sesadmin.php";


if(empty($_GET['Kode'])){
	echo "<b>Data yang dihapus tidak ada</b>";
}
else {
	$Kode	= $_GET['Kode'];
	
	$mySql = "SELECT * FROM barang WHERE kd_barang='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$myData= mysql_fetch_array($myQry);
	
	if(! $myData['file_gambar']=="") {
		if(file_exists("../img-barang/".$myData['file_gambar'])) {
			unlink("../img-barang/".$myData['file_gambar']); 
		}
	}
	
	$mySql = "DELETE FROM barang WHERE kd_barang='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Query 2 salah".mysql_error());
	if($myQry){
		echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Data'>";
	}
}
?>