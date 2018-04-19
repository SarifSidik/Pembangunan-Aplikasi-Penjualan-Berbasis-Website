<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";


if(isset($_GET['Kode'])) {
	
	$Kode	= $_GET['Kode'];
	
	if (trim($_GET['Kode']) == "") {
		$filterSQL = " ";
	}
	else {
		$filterSQL = "WHERE barang.kd_kategori='$Kode'";
	}
}


$baris	= 10;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 1;
$pageSql= "SELECT * FROM barang $filterSQL ORDER BY kd_barang DESC";
$pageQry= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	= mysql_num_rows($pageQry);
$maks	= ceil($jml/$baris);
$mulai	= $baris * ($hal-1);


$infoSql = "SELECT * FROM kategori WHERE kd_kategori='$Kode'";
$infoQry = mysql_query($infoSql, $koneksidb) or die ("Query salah".mysql_error());
$infoData= mysql_fetch_array($infoQry);
?>
<html>
<head>
</head>
<body>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td colspan="2" align="center" bgcolor="#CCCCCC" scope="col"><strong><?php echo strtoupper($infoData['nm_kategori']); ?></strong></td>
  </tr>
<?php

$barang2Sql = "SELECT barang.*,  kategori.nm_kategori FROM barang 
			LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
			$filterSQL 
			ORDER BY barang.kd_barang ASC LIMIT $mulai, $baris";
$barang2Qry = mysql_query($barang2Sql, $koneksidb) or die ("Gagal Query".mysql_error()); 
$nomor = 0;
while ($barang2Data = mysql_fetch_array($barang2Qry)) {
  $nomor++;
  $KodeBarang = $barang2Data['kd_barang'];
  $KodeKategori = $barang2Data['kd_kategori'];
  
  
  if ($barang2Data['file_gambar']=="") {
		$fileGambar = "noimage.jpg";
  }
  else {
		$fileGambar	= $barang2Data['file_gambar'];
  }
  

if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
?>
  <tr>
    <td width="24%" align="center">
		<a href="?open=Barang-Lihat&Kode=<?php echo $KodeBarang; ?>">
		<img src="img-barang/<?php echo $fileGambar; ?>" width="100" border="0"> </a> <br>
		<div class='harga'>Rp. <?php echo format_angka($barang2Data['harga_jual']); ?> </div> <br>
		<a href="?open=Barang-Beli&Kode=<?php echo $KodeBarang; ?>" class="button orange small"> <strong>Beli</strong></a>	</td>
    <td width="76%" valign="top">
		<a href="?open=Barang-Lihat&Kode=<?php echo $KodeBarang; ?>">
	  <div class='judul'> <?php echo $barang2Data['nm_barang']; ?> </div> </a>
		<p><?php echo substr($barang2Data['keterangan'], 0, 200); ?> ....</p>
		<p><strong>Stok :</strong> <?php echo $barang2Data['stok']; ?></p>
	<strong>Kategori :</strong> <a href="?open=Kategori-Barang&Kode=<?php echo $KodeKategori; ?>"> <?php echo $barang2Data['nm_kategori']; ?> </a>	</td>
  </tr>
<?php } ?>
  <tr>
    <td colspan="2" align="center"><b>Pages:
      <?php
	for ($h = 1; $h <= $maks; $h++) {
			echo "[  <a href='?open=Kategori-Barang&Kode=$KodeKategori&hal=$h'>$h</a> ]";
	}
	?>
    </b></td>
  </tr>
</table>
</body>
</html>
