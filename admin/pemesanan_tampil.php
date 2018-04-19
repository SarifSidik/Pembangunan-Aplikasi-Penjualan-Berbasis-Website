<?php
include_once "../library/inc.sesadmin.php";
include_once "../library/inc.library.php";

$SqlPeriode = ""; $awalTgl=""; $akhirTgl=""; $tglAwal=""; $tglAkhir="";


$awalTgl 	= isset($_GET['awalTgl']) ? $_GET['awalTgl'] : "01-".date('m-Y');
$tglAwal 	= isset($_POST['txtTglAwal']) ? $_POST['txtTglAwal'] : $awalTgl ;

$akhirTgl 	= isset($_GET['akhirTgl']) ? $_GET['akhirTgl'] : date('d-m-Y'); 
$tglAkhir 	= isset($_POST['txtTglAkhir']) ? $_POST['txtTglAkhir'] : $akhirTgl;


if (isset($_POST['btnTampil'])) {
	$SqlPeriode = " tgl_pemesanan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."'";
}
else {
	$SqlPeriode = " tgl_pemesanan BETWEEN '".InggrisTgl($awalTgl)."' AND '".InggrisTgl($akhirTgl)."'";
}


$baris = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM pemesanan WHERE $SqlPeriode";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$maksData	 = ceil($jml/$baris); 
?>
<H3 align=center>DAFTAR PEMESANAN</h3>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="550" border="5"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><b>FILTER DATA </b></td>
    </tr>
    <tr>
      <td width="55"><b>Periode </b></td>
      <td width="5"><b>:</b></td>
      <td width="426"><input name="txtTglAwal" type="text" class="tcal" value="<?php echo $tglAwal; ?>" /> 
        s/d 
          <input name="txtTglAkhir" type="text" class="tcal"  value="<?php echo $tglAkhir; ?>" />
      <input name="btnTampil" type="submit" value=" Tampilkan " /></td>
    </tr>
  </table>
</form>

<table width="1070" border="5" cellpadding="2" cellspacing="1" class="table-list" >
  <tr>
    <th width="4%" align="center" bgcolor="#CCCCCC"><b>No</b></th>
    <th width="10%" bgcolor="#CCCCCC"><b>No Pesan </b></th>
    <th width="11%" bgcolor="#CCCCCC"><b>Tanggal</b></th>
    <th width="19%" bgcolor="#CCCCCC"><strong>Nama Pelanggan </strong></th>
    <th width="14%" align="right" bgcolor="#CCCCCC"><b>Total  Transfer </b></th>
    <th width="10%" align="right" bgcolor="#CCCCCC"><strong>Status </strong></th>
    <td width="23%" align="center" bgcolor="#CCCCCC"><b>Set Bayar </b></td>
    <td align="center" bgcolor="#CCCCCC"><b>Tools</b></td>
  </tr>
  <?php
  
  $totalBayar = 0;
  $unikTransfer = 0;

  
  $mySql = "SELECT pemesanan.*, pelanggan.nm_pelanggan, provinsi.biaya_kirim
  			  FROM pelanggan, pemesanan, provinsi
			  WHERE pelanggan.kd_pelanggan=pemesanan.kd_pelanggan AND pemesanan.kd_provinsi=provinsi.kd_provinsi
			  AND $SqlPeriode ORDER BY RIGHT(pemesanan.no_pemesanan,5) DESC";
  $myQry = @mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
  $nomor = 0;
  while ($myData =mysql_fetch_array($myQry)) {
	  $nomor++;
	  $Kode = $myData['no_pemesanan'];
	  $digitHp 	= substr($myData['no_telepon'],-3); 
	  
	  
	  $my2Sql	= "SELECT SUM(harga * jumlah) As total_bayar,
	  				SUM(jumlah) As total_barang FROM pemesanan_item WHERE no_pemesanan='$Kode'";
	  $my2Qry 	= @mysql_query($my2Sql, $koneksidb) or die ("Gagal query".mysql_error());
	  $my2Data 	= mysql_fetch_array($my2Qry);
		
		
		$totalBayar = $my2Data['total_bayar'] + ($myData['biaya_kirim'] * $my2Data['total_barang']);
		$unikTransfer = substr($totalBayar,0,-3).$digitHp;
  ?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['no_pemesanan']; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pemesanan']); ?></td>
    <td><?php echo $myData['nm_pelanggan']; ?></td>
    <td align="right">Rp. <b><?php echo format_angka($unikTransfer); ?></b></td>
    <td align="right" bgcolor="#FFFF66"><?php echo $myData['status_bayar']; ?></td>
    <td align="center">
	<?php if($myData['status_bayar']=="Pesan") { ?> 
	  <a href="?open=Pemesanan-Bayar&Aksi=Lunas&Kode=<?php echo $myData['no_pemesanan']; ?>" class='button orange small' target="_blank"> <strong>Bayar </strong></a>
	  <?php } else { ?> 
	  <a href="?open=Pemesanan-Bayar&Aksi=Pesan&Kode=<?php echo $myData['no_pemesanan']; ?>" class='button red small'  target="_blank"> <strong>Batalkan</strong></a>
	  <?php } ?>	  </td>
    <td width="9%" align="center"><a href="pemesanan_lihat.php?Kode=<?php echo $Kode; ?>" target="_blank" class='button white small'>Lihat</a> </td>
  </tr>
  <?php } ?>
</table>
