

<?php  
	
	$this->load->model("Lnd_model", "lnd");

	$items = "";
	$total = 0;
	$no = 0;
	foreach ($pjd as $vpjd) {

		$no++;

		$qty_jadi 	= $vpjd->qty - $vpjd->qty_retur;
		$pot 		= ($qty_jadi * round($vpjd->harga)) * $vpjd->disc_produk / 100;
		$subtotal 	= ($qty_jadi * round($vpjd->harga) ) - $pot;

		if ($vpjd->retur == "Y") {
			if ($qty_jadi == 0) {
				$line 	= "text-decoration:line-through;";
				$total = $total + 0;
			}
			else{
				$line 	= "";
				$total = $total + $subtotal;
			}
			$min 	= "<span> - ".$vpjd->qty_retur."</span>";
		}
		else{
			$produk = $vpjd->nama_produk;
			$line = "";
			$total = $total + $subtotal;
			$min = "";
		}

		$items.="

			<tr style='".$line."'>
				<td align='center'>".$no."</td>
				<td>".$vpjd->nama_produk."</td>
				<td align='right'>".$vpjd->qty." ".$min."</td>
				<td align='center'>".$vpjd->nama_satuan."</td>
				<td align='right'>".number_format($vpjd->harga, 0, ",", ".")."</td>
				<td align='right'>".$vpjd->disc_produk."%</td>
				<td align='right'>".number_format($subtotal, 0, ",", ".")."</td>
			</tr>
		";

	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Print</title>
	<meta content="width=device-width, initial-scale=1" name="viewport"/>

	<style type="text/css">
		body{
			font-size: 13px;
			font-family: verdana;
		}
	</style>

</head>
<body>

	<center>
		<h2 style="font-size: 20px;">FAKTUR PENJUALAN</h2>
	</center>
	<table width="100%">
		<tr>
			<td width="50%">
				<span style="font-size: 18px;font-weight: bold">APOTEK ONDANG</span><br>
				Jl. Ahmad Yani No. 10<br>
				Subang Jawa Barat<br>
			</td>
			<td valign="top">
				<table width="100%" border="0">
					<tr>
						<td width="">Tanggal</td>
						<td width="5%" align="center">:</td>
						<td><?php echo date("d/m/Y H:i:s", strtotime($pj["created_on"])) ?></td>
					</tr>
					<tr>
						<td width="">No Transaksi</td>
						<td width="5%" align="center">:</td>
						<td><?php echo $pj['no_trans'] ?></td>
					</tr>
					
					<tr>
						<td width="15%">Pelanggan</td>
						<td width="5%" align="center">:</td>
						<td><?php echo $pj["nama_pelanggan"] ?> / <?php echo $pj["no_hp"] ?></td>
					</tr>
					<tr>
						<td width="15%">Alamat</td>
						<td width="5%" align="center">:</td>
						<td><?php echo $pj["alamat"] ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br>
	<br>
	<table border="1" width="100%" style="border-collapse: collapse;">
		<tr style="text-align: center;font-weight: bold;">
			<td style="padding: 5px" width="5%">No</td>
			<td>Nama Produk</td>
			<td width="10%">Qty</td>
			<td width="10%">Satuan</td>
			<td width="15%">Harga</td>
			<td width="5%">Diskon</td>
			<td width="15%">Subtotal</td>
		</tr>

		<?php echo $items ?>

	</table>

	<br>

	<table width="100%">
		<tr>
			<td valign="top">
				<table width="100%">
					<td align="center">
						Hormat Kami<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						(..................................)
					</td>
					<td align="center">
						Penerima<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						(..................................)
					</td>
				</table>
			</td>
			<td width="30%" valign="top">
				<table width="100%" style="border-collapse: collapse;font-weight: bold;" border="1">
					<tr>
						<td align="center">TOTAL</td>
						<td align="right"><?php echo number_format($total, 0, ",", ".") ?></td>
					</tr>
					<tr>
						<td align="center">BAYAR</td>
						<td align="right"><?php echo number_format($pj['bayar'], 0, ",", ".") ?></td>
					</tr>
					<tr>
						<td align="center">KEMBALIAN</td>
						<td align="right"><?php echo number_format($pj['bayar'] - $total, 0, ",", ".") ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<br>
	<br>
	<table width="50%" border="1" style="border-collapse: collapse;">
		<td height="50" style="padding: 10px">
			<i>* Note : Batas Pengembalian Barang 1 Hari dari Penjualan dan wajib menyertakan Faktur ini.</i>
		</td>
	</table>





</body>
</html>