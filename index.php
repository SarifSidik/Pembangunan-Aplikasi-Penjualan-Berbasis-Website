<?php
session_start();
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
?>
<html>
<head>

<link rel="shortcut icon" href="images/header.jpg"/>
<title>TOKO HANDMADE - Toko Handmade</title>
<link href="style/styles_user.css" rel="stylesheet" type="text/css">
<link href="style/button.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js.popupWindow.js"></script>
<link href="style/menu.css" rel="stylesheet" type="text/css" />
</head> 

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="10" bgcolor="cyan">
  <tr class="header"> <td width="15%" align="center"><img src="images/iki.png" width="100%"></td>
	  
	<form action="?open=Barang-Pencarian" method="post" name="form1">
	<td>
	
	<input class="search" name="txtKeyword" type="text" placeholder="Cari Barang" size="30" maxlength="100">
	<input class="btn" type="submit" value="Cari" name="btnCari"  >
	</form></td>
<td >
  <a class="btni" href="?open=Profil" target="_self"><font color="white"><b>PROFIL </font> </a>
   <a class="btni" href="?open=Barang" target="_self"><font color="white">BARANG   </font></a>
    <a class="btn" href="?open=Panduan" target="_self"><font color="white">PANDUAN </font></a>
    <a class="btn" href="?open=Konfirmasi" target="_self"><font color="white">KONFIRMASI </font></a></td>
    
    <td align="right"><?php include "inc.login_status.php"; ?></td>
   </tr>
	</table><table width="75%" align="center">

  <tr> 
    <td width="250" align="center" >&nbsp;</td>
  </tr>
  <tr> 
    <td align="center" valign="top" bgcolor="#FFFFFF"  class="utama">
	<table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        
      </tr>
    </table> <?php include "login.php"; ?>
	<table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td align="center" valign="top" bgcolor="#FFFFFF"></td>
      </tr>
      <tr align="center"><hr>
        <td width="121" height="22"class="head"><b>KATEGORI</b></td>
      </tr>
      <tr>
        <td height="18" align="center" valign="top" bgcolor="#FFFFFF">
		<table width="98%" border="0" align="center" cellpadding="4" cellspacing="0">
         <?php
		  $mySql = "SELECT * FROM kategori ORDER BY nm_kategori";
		  $myQry = mysql_query($mySql, $koneksidb) or die ("Query salah : ".mysql_error());
		  while($myData = mysql_fetch_array($myQry)) {
		  	$Kode = $myData['kd_kategori'];
		  ?>
            <tr>
              <td width="8%"><img src="images/ikon.png" width="9" height="9"></td>
              <td width="92%"><b> <?php echo "<a href=?open=Barang-Kategori&Kode=$Kode>$myData[nm_kategori]</a>"; ?> </b></td>
            </tr>
            <?php
		  }
		  ?>
        </table>
     
        <td height="18" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>

    </table>
    <td>&nbsp;</td>
    <td align="center" valign="top" bgcolor="#FFFFFF" class="utama">
	<?php include "buka_file.php"; ?></td>
  </tr>
  <tr> 
    <td height="4">&nbsp;</td>
    <td height="4">&nbsp;</td>
    <td height="4">&nbsp;</td>
  </tr>
  <tr> </table><table width="100%" >
    <td class="FOOT" align="center" bgcolor="cyan">
	<p>Copyright &copy; 2018<br>
    TOKO HANDMADE - Toko HANDMADE<br>
    UNIVERSITAS KOMPUTER INDONESIA</p></font></td>
  </tr>
</table>
</body>
</html>
