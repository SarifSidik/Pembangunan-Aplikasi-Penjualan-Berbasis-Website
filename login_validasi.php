<?php 
include_once "library/inc.connection.php";


if(isset($_POST['btnLogin'])){
	
	$txtUsername   = $_POST['txtUsername'];
	$txtPassword   = $_POST['txtPassword'];
	
	
	$pesanError = array();
	if (trim($txtUsername)=="") {
		$pesanError[] = "Data <b>Username</b> kosong, silahkan isi dengan benar";
	}
	if (trim($txtPassword)=="") {
		$pesanError[] = "Data <b>Password</b> kosong, silahkan isi dengan benar";
	}

	
	$loginSql = "SELECT * FROM pelanggan WHERE username='$txtUsername' AND password=MD5('$txtPassword')";
	$loginQry = mysql_query($loginSql, $koneksidb) or die ("Gagal query password".mysql_error());
	$loginQty = mysql_num_rows($loginQry);
	if($loginQty < 1) {
		$pesanError[] = "Data <b>Username dan Password</b> yang Anda masukan belum benar";
	}	
	

	if (count($pesanError)>=1 ) {
		echo "<br>";
		echo "<div align='left'>";
		echo "&nbsp; <b> LOGIN ANDA SALAH .............</b><br><br>";
		echo "&nbsp; <b> Kesalahan Input : </b><br>";
		$urut_pesan = 0;
		foreach ($pesanError as $indeks=>$pesanTampil) {
			$urut_pesan++;
			echo "<div class='pesanError' align='left'>";
			echo "&nbsp; &nbsp;";
			echo "$urut_pesan . $pesanTampil <br>";
		}
		echo "<br>";
	}
	else {	
		
		if ($loginQty >=1) {
			
			$loginData = mysql_fetch_array($loginQry);
			
			
			$_SESSION['SES_PELANGGAN'] 	= $loginData['kd_pelanggan'];
			$_SESSION['SES_USERNAME'] 	= $loginData['username'];
			
		
			$KodePelanggan	= $loginData['kd_pelanggan'];
			
			
			$hapusSql = "DELETE FROM tmp_keranjang WHERE kd_pelanggan='$KodePelanggan'";
			mysql_query($hapusSql) or die ("Gagal query hapus".mysql_error());
	
			echo "<meta http-equiv='refresh' content='0; url=index.php'>";
			exit;
		}
	}
}
?>