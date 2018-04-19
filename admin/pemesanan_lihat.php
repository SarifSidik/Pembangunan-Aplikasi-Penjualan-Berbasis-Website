<?php
session_start();
include_once "../library/inc.sesadmin.php";   
include_once "../library/inc.connection.php"; 
include_once "../library/inc.library.php";   

if(isset($_GET['Kode'])) {
	
	$Kode	= $_GET['Kode'];
	
	
	$mySql = "SELECT pemesanan.*, pelanggan.nm_pelanggan, provinsi.*
			FROM pemesanan, pelanggan, provinsi
			WHERE pemesanan.kd_pelanggan=pelanggan.kd_pelanggan AND pemesanan.kd_provinsi=provinsi.kd_provinsi 	
			AND pemesanan.no_pemesanan ='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal query");
	$myData = mysql_fetch_array($myQry);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Pemesanan Detil Barang</title>
<link href="../style/styles_cetak.css" rel="stylesheet" type="text/css">
<link href="../style/button.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1>TRANSAKSI PEMESANAN </h1>
<table width="550" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td bgcolor="#CCCCCC"><strong>TRANSAKSI</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="31%"><b>No. Pemesanan</b></td>
    <td width="2%">:</td>
    <td width="67%"><?php echo $myData['no_pemesanan']; ?></td>
  </tr>
  <tr>
    <td><b>Tanggal</b></td>
    <td>:</td>
    <td><?php echo IndonesiaTgl($myData['tgl_pemesanan']); ?></td>
  </tr>
  <tr>
    <td><b>Kode Pelanggan</b></td>
    <td>:</td>
    <td><?php echo $myData['kd_pelanggan']; ?></td>
  </tr>
  <tr>
    <td><b>Nama Pelanggan</b></td>
    <td>:</td>
    <td><?php echo $myData['nm_pelanggan']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC"><strong>PENERIMA</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>Nama Penerima</b></td>
    <td>:</td>
    <td><?php echo $myData['nama_penerima']; ?></td>
  </tr>
  <tr>
    <td><b>Alamat Penerima</b></td>
    <td>:</td>
    <td><?php echo $myData['alamat_lengkap']; ?></td>
  </tr>
  <tr>
    <td><strong>Provinsi</strong></td>
    <td>:</td>
    <td><?php echo $myData['nm_provinsi'];  ?></td>
  </tr>
  <tr>
    <td><b>No. Telepon </b></td>
    <td>:</td>
    <td><?php echo $myData['no_telepon'];  ?></td>
  </tr>
  <tr>
    <td><b>Kode Unik Transfer </b></td>
    <td>:</td>
    <td><?php echo substr($myData['no_telepon'],-3); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFF99"><b>Status Pembayaran </b></td>
    <td>:</td>
    <td><?php echo $myData['status_bayar']; ?> * </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<h2>DAFTAR PESANAN BARANG</h2>
<table width="800" border="0" cellpadding="2" cellspacing="0" class="table-list">
  <tr>
    <td width="30" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="74" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="404" height="22" bgcolor="#CCCCCC"><b>Nama Barang </b></td>
    <td width="111" align="right" bgcolor="#CCCCCC"><b><b>Harga (Rp)</b></b></td>
    <td width="54" align="center" bgcolor="#CCCCCC"><b>Jumlah</b></td>
    <td width="103" align="right" bgcolor="#CCCCCC"><b>Total (Rp)</b></td>
  </tr>
  <?php 
	  
	  $subTotal		= 0;
	  $totalBarang 	= 0;
	  $totalBiayaKirim = 0;
	  $totalHarga 	= 0;
	  $totalBayar 	= 0;
	  $unik_transfer = 0;
	  
	
	$tampilSql = "SELECT barang.nm_barang, pemesanan_item.*
				FROM pemesanan, pemesanan_item
				LEFT JOIN barang ON pemesanan_item.kd_barang=barang.kd_barang
				WHERE pemesanan.no_pemesanan=pemesanan_item.no_pemesanan
				AND pemesanan.no_pemesanan='$Kode'
				ORDER BY pemesanan_item.kd_barang";
	$tampilQry = mysql_query($tampilSql, $koneksidb) or die ("Gagal SQL".mysql_error()); 
	$total = 0;
	$nomor = 0;
	while ($tampilData = mysql_fetch_array($tampilQry)) {
	  $nomor++;
	  
	  $subTotal		= $tampilData['harga'] * $tampilData['jumlah']; 
	  
	  
	  $totalHarga 	= $totalHarga + $subTotal;  
	  
	  
	  $totalBarang	= $totalBarang + $tampilData['jumlah']; 
  ?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $tampilData['kd_barang']; ?></td>
    <td><?php echo $tampilData['nm_barang']; ?></td>
    <td align="right">Rp. <?php echo $tampilData['harga']; ?></td>
    <td align="center"><?php echo $tampilData['jumlah']; ?></td>
    <td align="right">Rp.<?php echo format_angka($subTotal); ?></td>
  </tr>
  <?php
	}
  	
	$totalBiayaKirim = $myData['biaya_kirim'] * $totalBarang;
	
	
	$totalBayar = $totalHarga + $totalBiayaKirim;  
	
	
	$digitHp 	= substr($myData['no_telepon'],-3); 
	
	
	$unik_transfer = substr($totalBayar,0,-3).$digitHp;
	?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="right" bgcolor="#F5F5F5"><strong>Total Belanja (Rp) : </strong></td>
    <td align="right" bgcolor="#F5F5F5"><?php echo format_angka($totalHarga); ?></td>
  </tr>
  <tr>
    <td colspan="5" align="right"><strong>Total Biaya Kirim  (Rp) : </strong></td>
    <td align="right"><?php echo format_angka($totalBiayaKirim); ?></td>
  </tr>
  <tr>
    <td colspan="5" align="right" bgcolor="#F5F5F5"><strong>GRAND TOTAL  (Rp) : </strong></td>
    <td align="right" bgcolor="#F5F5F5"><?php echo format_angka($totalBayar); ?></td>
  </tr>
  <tr>
    <td colspan="6" align="right">Nominal yang harus dibayarkan adalah <b>Rp. <?php echo format_angka($unik_transfer); ?></b> </td>
  </tr>
  <tr>
    <td colspan="6" align="right">
	<?php if($myData['status_bayar']=="Pesan") { ?>
        <a href="index.php?open=Pemesanan-Bayar&Aksi=Lunas&Kode=<?php echo $myData['no_pemesanan']; ?>" class='button orange small'> <strong>Bayar</strong></a>
        <?php } else { ?>
        <a href="index.php?open=Pemesanan-Bayar&Aksi=Pesan&Kode=<?php echo $myData['no_pemesanan']; ?>" class='button red small'> <strong>Batalkan</strong></a>
    <?php } ?>    </td>
  </tr>
</table>
<?php
} 
else {
	// Kode tidak terbaca
	echo "<meta http-equiv='refresh' content='0; url=?open=Transaksi-Tampil'>";
}
?>
<p><b>* Keterangan Status Pembayaran :</b></p>
<ul>
  <li><b>Pesan :</b> Masih dalam pemesanan (bisa batal), atau <strong>Belum Dibayar</strong>.</li>
  <li><b>Lunas :</b> Pemesanan sudah dibayar Lunas, dan <strong>Dalam Proses Pengiriman</strong>.</li>
  <li><b>Batal :</b> Pemesanan batal.     </li>
</ul>
</body>
</html>
