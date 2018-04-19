<table width="100%"   cellpadding="2" cellspacing="0">
<?php
if (! isset($_SESSION['SES_PELANGGAN'])) {

?>
  <form name="frmLogin" method="post" action="?open=Login-Validasi">
    <tr>
     <td class="w"> <b><center>LOGIN </b></center>
 <br> 
      <b>Username : </b><br />
        <input name="txtUsername" type="text"  size="20" maxlength="30"> 
    <br> 
      <b>Password :</b> <br />
      <input name="txtPassword" type="password" size="20" maxlength="30">
   <br>
      <input type="submit" name="btnLogin" value="Login" />
    <br> 
      <b><img src="images/ikon.png" width="9" height="9">
		<a href="?open=Pelanggan-Baru" target="_self">Pendaftaran Baru </a></b>
    </td></tr>
   
  </form>
<?php 
}
else { 

?>
      <td class="w" height="22"class="head" colspan="3"><b><center>TRANSAKSI</b></center>
      
  <br>
  
		<img src="images/ikon.png" > <a href="?open=Keranjang-Belanja" target="_self">Keranjang Belanja</a> 
	<br>	<img src="images/ikon.png" > <a href="?open=Transaksi-Tampil" target="_self">Transaksi</a> 
  
  <br>
   <img src="images/ikon.png"> <a href="login_out.php" target="_self">Logout</a></b></td>
  </td></tr>
<?php } ?>
</table>
