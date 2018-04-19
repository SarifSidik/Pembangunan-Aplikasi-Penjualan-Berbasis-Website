<?php
$my['host']	= "localhost";
$my['user']	= "root";
$my['pass']	= "";
$my['dbs']	= "mppl";

$koneksidb	= mysql_connect($my['host'], $my['user'], $my['pass']);
if (! $koneksidb) {
  echo "Failed Connection !";
}

mysql_select_db($my['dbs'])
	 or die ("Database not Found, please contact administrator system!");
?>