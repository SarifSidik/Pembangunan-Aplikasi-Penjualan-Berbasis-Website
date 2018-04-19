<?php
include_once "../library/inc.sesadmin.php";

if(isset($_POST['btnSimpan'])){

	$txtNama	= $_POST['txtNama'];
	$txtNama 	= str_replace("'","&acute;",$txtNama); // Membuang karakter petik (')
	
	
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Kategori</b> tidak boleh kosong !";		
	}
	
	$cekSql	="SELECT * FROM kategori WHERE nm_kategori='$txtNama'";
	$cekQry	=mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
	if(mysql_num_rows($cekQry)>=1){
		$pesanError[] = "Maaf, Kategori <b> $txtNama </b> sudah ada, ganti dengan yang nama berbeda";
	}
	
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
		$kodeBaru= buatKode("kategori", "K");
		$mySql	= "INSERT INTO kategori SET kd_kategori='$kodeBaru', nm_kategori='$txtNama'";
		$myQry	= mysql_query($mySql) or die ("Query salah : ".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Kategori-Add'>";
		}
	}
} 
$dataKode		= buatKode("kategori", "K");
$dataKategori	= isset($_POST['txtNama']) ?  $_POST['txtNama'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd" target="_self">
<table width="100%" border="5" class="table-list" style="margin-top: 0px; font-weight: bold; text-align: left;">
	<tr>
	  <th colspan="3"> TAMBAH DATA KATEGORI</th>
	</tr>
	<tr>
	  <td width="18%"><strong>Kode</strong></td>
	  <td width="1%"><strong>:</strong></td>
	  <td width="81%"><input name="textfield" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly"/></td></tr>
	<tr>
	  <td><strong>Nama Kategori</strong></td>
	  <td><strong>:</strong></td>
	  <td><input name="txtNama" value="<?php echo $dataKategori; ?>" size="80" maxlength="100" /></td>
	</tr>
	<tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="btnSimpan" value=" SIMPAN " style="cursor:pointer;"></td>
    </tr>
</table>
</form>
