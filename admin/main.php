<?php
if(! empty($_SESSION['SES_ADMIN'])) {
	echo "<H2 align=center>Selamat Anda Berhasil Masuk</H2></p>";
	echo "<H4 align=center> Silahkan Cek Data Anda Dan Cek Data Yang Telah Masuk</H4>";
	exit;
}
else {
	echo "<H2 align=center>Selamat datang</H2></p>";
	echo "<H3 align=center>ADMIN</H3></p>";
	echo "<H5 align=center> Silahkan <a href='?open=Login' alt='Login'>login </a>untuk mengakses sistem data anda ";	
}
?>