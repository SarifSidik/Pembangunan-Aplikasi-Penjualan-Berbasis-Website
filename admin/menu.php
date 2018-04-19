<?php
if(isset($_SESSION['SES_ADMIN'])){
?>
	<ul>
	<li><a href='?open' title='Halaman Utama'>Home</a></li>
	<li><a href='?open=Data-Admin' title='Data Admin'>Data Admin</a></li>
	
	<li><a href='?open=Kategori-Data' title='Kategori' target="_self">Data Kategori</a></li>
	<li><a href='?open=Barang-Data' title='Barang' target="_self">Data Barang</a></li>
	<li><a href='?open=Provinsi-Data' title='Kota' target="_self">Data Kota</a></li>
	<li><a href='?open=Pelanggan-Data' title='Pelanggan' target="_self">Data Pelanggan</a></li>
	<li><a href='?open=Pemesanan-Barang' title='Pemesanan Barang' target="_self">Pemesanan Barang</a></li>
	<li><a href='?open=Konfirmasi-Transfer' title='Konfirmasi Transfer' target="_self">Konfirmasi Transfer</a></li>
	<li><a href='?open=Laporan-Lunas' title='Laporan' target="_self">Laporan Transaksi</a></li>
	
	<li><a href='?open=Logout' title='Logout (Exit)'>Logout</a></li>
	</ul>
<?php
} 
else {
?>
	<ul>
	<li><a href='?open=Login' title='Login' target="_self">Login Admin</a></li>
	</ul>
<?php } ?>
