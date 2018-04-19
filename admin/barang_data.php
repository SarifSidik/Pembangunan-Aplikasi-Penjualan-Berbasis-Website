<?php
include_once "../library/inc.sesadmin.php";   
include_once "../library/inc.connection.php"; 
include_once "../library/inc.library.php";    

$baris = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM barang";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumlah	 = mysql_num_rows($pageQry);
$maksData= ceil($jumlah/$baris);

$dataCari	= isset($_POST['txtCari']) ? $_POST['txtCari'] : '';
?>
<style type="text/css">
.table-common tr td h2 b {
	font-family: "Times New Roman", Times, serif;
}
</style>

<table width="1060" border="5" cellpadding="2" cellspacing="1" class="table-common">
  <tr>
    <td height="30" colspan="2" align="center"><H2 align=center><b>DATA BARANG </b></h2></td>
  </tr>
   <td colspan="2" align="right">
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
      <b>Cari Nama :</b>
        <input name="txtCari" type="text" value="<?php echo $dataCari; ?>" size="40" maxlength="100" />
      <input name="btnCari" type="submit" value="Cari" />
      </form>
      </td>
  <tr>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><a href="?open=Barang-Add" target="_self"><img src="../images/btn_add_data.png" height="30" border="0" /></a></td>
  </tr>
  <tr>
    <td colspan="2">
	<table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="32" align="center" bgcolor="#CCCCCC"><strong>No</strong></th>
        <th width="108" align="center" bgcolor="#CCCCCC"><strong>Kode</strong></th>
        <th width="476" bgcolor="#CCCCCC"><strong>Nama Barang </strong></th>
        <th width="67" bgcolor="#CCCCCC"><strong> Stok</strong></th>
        <th width="159" bgcolor="#CCCCCC"><strong> Harga (Rp) </strong></th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
        </tr>
      <?php	if(isset($_POST['btnCari'])){
		$mySql = "SELECT * FROM barang WHERE nm_barang LIKE '%$dataCari%' ORDER BY kd_barang DESC LIMIT $hal, $baris";
	}else {
	$mySql = "SELECT * FROM barang ORDER BY kd_barang ASC LIMIT $hal, $baris";
	}
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_barang'];
	?>
      <tr>
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_barang']; ?></td>
        <td><?php echo $myData['nm_barang']; ?></td>
        <td align="center"><?php echo $myData['stok']; ?></td>
        <td align="right"><?php echo format_angka($myData['harga_jual']); ?></td>
        <td width="39" align="center"><a href="?open=Barang-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Edit</a></td>
        <td width="56" align="center"><a href="?open=Barang-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA BARANG INI ... ?')">Delete</a></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr class="selKecil">
    <td width="407"><b>Jumlah Data :</b> <?php echo $jumlah; ?> </td>
    <td width="384" align="right"><b>Halaman ke :</b>
      <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Barang-Data&hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
</table>
