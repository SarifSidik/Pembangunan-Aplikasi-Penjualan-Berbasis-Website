<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";


if(isset($_POST['btnKirim'])){
	
	$txtNoPemesanan	= $_POST['txtNoPemesanan'];
	$txtNoPemesanan 		= str_replace("'","&acute;",$txtNoPemesanan);
	
	$txtNama		= $_POST['txtNama'];
	$txtNama 		= str_replace("'","&acute;",$txtNama);
	
	$txtJumlahTransfer		= $_POST['txtJumlahTransfer'];
	$txtJumlahTransfer 		= str_replace(".","",$txtJumlahTransfer);
	$txtJumlahTransfer 		= str_replace(",","",$txtJumlahTransfer); 
	$txtJumlahTransfer 		= str_replace(" ","",$txtJumlahTransfer); 
	
	$txtKeterangan	= $_POST['txtKeterangan'];
	$txtKeterangan 	= str_replace("'","&acute;",$txtKeterangan);
	
	
	$pesanError = array();
	if (trim($txtNoPemesanan)=="") {
		$pesanError[] = "Data <b>No. Pemesanan</b>  masih kosong, isi sesuai dengan <b>No Pemesanan</b> Anda";
	}
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Penerima</b>  masih kosong, isi sesuai nama akun Anda";
	}
	if (trim($txtJumlahTransfer)=="" or ! is_numeric(trim($txtJumlahTransfer))) {
		$pesanError[] = "Data <b> Jumlah Ditransfer (Rp)</b> masih kosong, dan <b> harus ditulis angka </b>";
	}
	if (trim($txtKeterangan)=="") {
		$pesanError[] = "Data <b> Keterangan </b> masih kosong";
	}

	
	if (count($pesanError)>=1 ){
		echo "<div class='pesanError' align='left'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "<br>"; 
	}
	else {
		
		$tanggal	= date('Y-m-d');
		
		
		$mySql = "INSERT INTO konfirmasi (no_pemesanan, nm_pelanggan, jumlah_transfer, keterangan, tanggal) 
				  VALUES ('$txtNoPemesanan', '$txtNama', '$txtJumlahTransfer', '$txtKeterangan', '$tanggal')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		
		echo "<b> SUKSES ...! KONFIRMASI SUDAH DIKIRIM </b>";
		echo "<meta http-equiv='refresh' content='2; url=?open=Barang'>";
		exit;
	}	
} 

$dataNoPemesanan	= isset($_POST['txtNoPemesanan']) ? $_POST['txtNoPemesanan'] : '';
$dataNama			= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataJumlahTransfer	= isset($_POST['txtJumlahTransfer']) ? $_POST['txtJumlahTransfer'] : '';
$dataKeterangan 	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1"  target="_self">
  <table width="100%" border="0"  cellpadding="4" cellspacing="0">
    <tr> 
      <td colspan="3"  class="HEAD"><b>KONFIRMASI PEMBAYARAN </b></td>
    </tr>
    <tr>
      <td width="459"><b>No. Pemesanan 
      </b></td>
      <td width="5"><b>:</b></td>
      <td width="726"><input name="txtNoPemesanan" type="text" value="<?php echo $dataNoPemesanan; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td><b>Nama Pelanggan </b></td>
      <td><b>:</b></td>
      <td><input name="txtNama" type="text" value="<?php echo $dataNama; ?>" size="60" maxlength="100" /></td>
    </tr>
    <tr>
      <td><b>Jumlah Transfer (Rp.) </b></td>
      <td><b>:</b></td>
      <td><input name="txtJumlahTransfer" type="text" value="<?php echo $dataJumlahTransfer; ?>" size="20" maxlength="12" />      </td>
    </tr>
    <tr>
      <td><b>Keterangan</b></td>
      <td><b>:</b></td>
      <td><textarea name="txtKeterangan" cols="45" rows="4"><?php echo $dataKeterangan; ?></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnKirim" value=" Kirim "></td>
    </tr>
    <tr>
      <td colspan="3"><b>Catatan:</b><br />
        <b>*)</b> Jika bingung dengan <b>No. Transaksi</b>, silahkan Anda Login, lalu lihatlah daftar <b>transaksi terakhir</b>, di sana Ada. <br />
**) Jumlah Transfer yang harus Anda tulis adalah sesuai dengan jumlah transfer yang telah dilakukan, gunakan 3 digit terakhir No HP Anda untuk tanda (misal : <b>Rp. 300.231</b> ).<br />
<br />
( <strong>231</strong> didapat dari 3 digit terakhir No HP Pemesan/ Tujuan Pengiriman juga bisa) </td>
    </tr>
  </table>
</form>
