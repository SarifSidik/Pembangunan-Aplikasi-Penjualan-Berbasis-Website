<?php
include_once "../library/inc.sesadmin.php";


if(empty($_GET['Kode'])){
	echo "<b>Data yang dihapus tidak ada</b>";
}
else {
	
	$Kode	= $_GET['Kode'];
	$mySql 	= "DELETE FROM admin WHERE id='$Kode'";
	$myQry 	= mysql_query($mySql, $koneksidb) or die ("Eror hapus data".mysql_error());
	if($myQry){
		echo "<meta http-equiv='refresh' content='0; url=?open=Data-Admin'>";
	}
}
?>