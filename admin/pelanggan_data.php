<?php
include_once "../library/inc.sesadmin.php";
include_once "../library/inc.library.php";


$baris = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM pelanggan";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumlah	 = mysql_num_rows($pageQry);
$maksData= ceil($jumlah/$baris);


$dataCari	= isset($_POST['txtCari']) ? $_POST['txtCari'] : '';
?>
<table width="1070" border="5" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2" align="center"><h3>DATA PELANGGAN</h3></td>
  </tr>
  <tr>
  </tr>
  <tr>
    <td colspan="2" align="right">
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
      <b>Cari Nama :</b>
        <input name="txtCari" type="text" value="<?php echo $dataCari; ?>" size="40" maxlength="100" />
      <input name="btnCari" type="submit" value="Cari" />
      </form></td>
  </tr>
  <tr>
    <td colspan="2">
	<table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="25">No</th>
        <th width="66">Kode</th>
        <th width="301">Nama Pelanggan</th>
        <th width="60">Kelamin</th>
        <th width="143">No. Telepon</th>
        <th width="119">Username</th>
        <td align="center" bgcolor="#CCCCCC"><strong>Tools</strong><b></b></td>
        </tr>
      <?php
	
	if(isset($_POST['btnCari'])){
		$mySql = "SELECT * FROM pelanggan WHERE nm_pelanggan LIKE '%$dataCari%' ORDER BY kd_pelanggan DESC LIMIT $hal, $baris";
	}
	else {
		$mySql = "SELECT * FROM pelanggan ORDER BY kd_pelanggan DESC LIMIT $hal, $baris";
	} 
	
	
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_pelanggan'];
	?>
      <tr>
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_pelanggan']; ?></td>
        <td><?php echo $myData['nm_pelanggan']; ?></td>
        <td><?php echo $myData['kelamin']; ?></td>
        <td><?php echo $myData['no_telepon']; ?></td>
        <td><?php echo $myData['username']; ?></td>
        <td width="44" align="center"><a href="?open=Pelanggan-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PELANGGAN INI ... ?')">Delete</a></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr class="selKecil">
    <td><b>Jumlah Data :</b> <?php echo $jumlah; ?> </td>
    <td align="right"><b>Halaman ke :</b> 
	<?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Pelanggan-Data&hal=$list[$h]'>$h</a> ";
	}
	?>
	</td>
  </tr>
</table>
