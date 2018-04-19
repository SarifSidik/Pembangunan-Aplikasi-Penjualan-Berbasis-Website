<?php
include_once "../library/inc.sesadmin.php";
include_once "../library/inc.library.php";
include_once "../library/inc.connection.php";


if(isset($_POST['btnSimpan'])){
	
	$txtNama=$_POST['txtNama'];
	$txtNama= str_replace("'","&acute;",$txtNama);
	
		$txtPass= $_POST['txtPass'];$txtPass= str_replace("'","&acute;",$txtPass);


	
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Username</b> tidak boleh kosong !";		
	}
	$pesanError = array();
	if (trim($txtPass)=="") {
		$pesanError[] = "Data <b> Password </b> belum diisi !";		
	}

	
	$cekSql	= "SELECT * FROM admin WHERE username='$txtNama'";
	$cekQry	= mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
	if(mysql_num_rows($cekQry)>=1){
		$pesanError[] = "Maaf, Username <b> $txtNama </b> sudah dimasukan";
		}
			$cekSql	= "SELECT * FROM admin WHERE password='$txtPass'";
	$cekQry	= mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error());
	
	
	
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		

		$mySql	= "INSERT INTO admin SET username='$txtNama',password='".md5($txtPass)."'";
		$myQry	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Data-Admin'>";
		
		}
	}	

}  



$dataNama 	= isset($_POST['txtNama']) ?  $_POST['txtNama'] : '';
$dataNama2	= isset($_POST['$txtPass']) ?  $_POST['$txtPass'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd">
<table class="table-list" width="100%" style="margin-top:0px;">
	<tr>
	  <th colspan="3">TAMBAH DATA ADMIN</th>
	</tr>
	<tr>
	  <td width="18%"><strong>Username </strong></td>
	  <td width="1%"><strong>:</strong></td>
	  <td width="81%"><input name="txtNama" value="<?php echo $dataNama; ?>" size="30" maxlength="100" /></td>
	</tr>
	<tr>
	  <td><strong>Password </strong></td>
	  <td><b>:</b></td>
	  <td><input name="txtPass" type="password"  value=value="<?php echo $dataNama2; ?>" size="30" maxlength="30"/></td>
    </tr>
	<tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="btnSimpan" value=" SIMPAN " style="cursor:pointer;"></td>
    </tr>
</table>
</form>
