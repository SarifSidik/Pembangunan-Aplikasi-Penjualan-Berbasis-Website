<?php
include_once "../library/inc.sesadmin.php";   
include_once "../library/inc.connection.php"; 
include_once "../library/inc.library.php";    

$filterSql = ""; $awalTgl=""; $akhirTgl=""; $tglAwal=""; $tglAkhir="";


$awalTgl 	= isset($_GET['awalTgl']) ? $_GET['awalTgl'] : "01-".date('m-Y');
$tglAwal 	= isset($_POST['txtTglAwal']) ? $_POST['txtTglAwal'] : $awalTgl ;

$akhirTgl 	= isset($_GET['akhirTgl']) ? $_GET['akhirTgl'] : date('d-m-Y'); 
$tglAkhir 	= isset($_POST['txtTglAkhir']) ? $_POST['txtTglAkhir'] : $akhirTgl;


if (isset($_POST['btnTampil'])) {
	$filterSql = "AND ( tgl_pemesanan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."') ";
}
else {
	$filterSql = "";
}
?>
<h2> LAPORAN PEMESANAN LUNAS PER PERIODE</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="550" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="130"><strong>Periode Transaksi</strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="401"><input name="txtTglAwal" type="text" class="tcal" value="<?php echo $tglAwal; ?>" />
        s/d
      <input name="txtTglAkhir" type="text" class="tcal"   value="<?php echo $tglAkhir; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnTampil" type="submit" value=" Tampilkan " /></td>
    </tr>
  </table>
</form>

Daftar <strong>Transaksi Pemesanan</strong> dari tanggal <b><?php echo $tglAwal; ?></b> s/d <b><?php echo $tglAkhir; ?></b><br />
<br />
<table class="table-list" width="850" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="23" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="72" bgcolor="#CCCCCC"><b>Tanggal</b></td>
    <td width="110" bgcolor="#CCCCCC"><b>No. Pemesanan </b> </td>
    <td width="100" bgcolor="#CCCCCC"><strong>Kode Plg </strong></td>
    <td width="218" bgcolor="#CCCCCC"><strong>Nama Pelanggan </strong></td>
    <td width="117" align="right" bgcolor="#CCCCCC"><strong>Qty Barang </strong></td>
    <td width="126" align="right" bgcolor="#CCCCCC"><strong>Total Belanja (Rp) </strong></td>
    <td width="43" align="center" bgcolor="#CCCCCC"><b>Tools</b></td>
  </tr>
  <?php
	
	$totalBayar 	= 0;
 	$totalBiayaKirim	= 0;
	$totItemBarang	= 0;
	$totOmset		= 0;

	
	$mySql = "SELECT pemesanan.*, pelanggan.nm_pelanggan, provinsi.biaya_kirim FROM pemesanan 
				LEFT JOIN pelanggan ON pemesanan.kd_pelanggan = pelanggan.kd_pelanggan
				LEFT JOIN provinsi ON pemesanan.kd_provinsi = provinsi.kd_provinsi
				WHERE pemesanan.status_bayar='Lunas' 
				$filterSql 
				ORDER BY pemesanan.no_pemesanan";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor  = 0; $totItem =0; $totOmset=0;
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		$Kode = $myData['no_pemesanan'];
		
		$my2Sql	= "SELECT SUM(harga * jumlah) As total_bayar,
					SUM(jumlah) As total_barang 
					FROM pemesanan_item WHERE no_pemesanan='$Kode'";
		$my2Qry = @mysql_query($my2Sql, $koneksidb) or die ("Gagal query".mysql_error());
		$my2Data =mysql_fetch_array($my2Qry);
		
		$totalBiayaKirim= $myData['biaya_kirim'] * $my2Data['total_barang'];
		$totalBayar 	= $my2Data['total_bayar'] + $totalBiayaKirim;
		
		$totItemBarang	= $totItemBarang + $my2Data['total_barang'];
		$totOmset		= $totOmset + $totalBayar;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pemesanan']); ?></td>
    <td><?php echo $myData['no_pemesanan']; ?></td>
    <td><?php echo $myData['kd_pelanggan']; ?></td>
    <td><?php echo $myData['nm_pelanggan']; ?></td>
    <td align="right"><?php echo $my2Data['total_barang']; ?></td>
    <td align="right"><?php echo format_angka($totalBayar); ?></td>
    <td align="center"><a href="pemesanan_lihat.php?Kode=<?php echo $Kode; ?>" target="_blank" class='button white small'>Lihat</a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="5" align="right"><strong>GRAND TOTAL     : </strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totItemBarang); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong>Rp. <?php echo format_angka($totOmset); ?></strong></td>
    <td align="right">&nbsp;</td>
  </tr>
</table>
