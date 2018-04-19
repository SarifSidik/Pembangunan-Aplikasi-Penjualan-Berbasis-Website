<?php
include_once "../library/inc.sesadmin.php";
?>
<table width="925" border="5" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2" align="center"><h3>DATA ADMIN</h3></td>
  </tr>
  <tr>
  </tr>
  <tr>
    <td colspan="2" align="right"><a href="?open=Admin-Add&Kode=<?php echo $Kode; ?>" target="_self"><img src="../images/btn_add_data.png" border="0" /></a></td>
  </tr>
  
  <tr>
    <td colspan="2">
	<table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="383" align="center" bgcolor="#CCCCCC">username</th>
        <th width="472" bgcolor="#CCCCCC">Password</th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
      </tr>
	<?php
	$mySql = "SELECT * FROM admin ORDER BY username ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['id'];
	?>
      <tr>
        <td align="center"><?php echo $myData['username']; ?></td>
        <td><?php echo $myData['password']; ?></td>
        
   
        <td width="55" align="center"><a href="?open=Admin-Delete&Kode=<?php echo $Kode; ?>"target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN INGIN MENGHAPUS DATA KATEGORI INI ... ?')">Delete</a></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
</table>
