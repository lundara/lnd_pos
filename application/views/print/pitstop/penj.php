
<?php  
	
	$item = "";
	$tl = 0;
	$dc = 0;
	foreach ($d as $v) {
		$sb 	= ($v->harga * $v->qty) - (($v->harga * $v->qty) * $v->disc/100);
		$pot 	= ($v->harga * $v->qty) * $v->disc/100;

		if ($v->merk!="") {
			$merk = "(".$v->merk.")";
		}
		else{
			$merk = "";
		}

		$item .="
			<tr>
				<td>".$v->nama_produk." ".$merk."</td>
				<td align='right'>".$v->qty."</td>
				<td align='right'>".number_format($v->harga, 0, ',','.')."</td>
				<td align='right'>".$v->disc."%</td>
				<td align='right'>".number_format($sb, 0, ',', '.')."</td>
			</tr>
		";

		$tl = $tl + $sb;
		$dc = $dc + $pot;



	}

?>


<style type="text/css">
	body{
		font-family: verdana;
		font-size: 10px;

	}
	.tb-head tr td{
		font-size: 5px !important;
	}
	.tb-item {
	    border-collapse: collapse;
	}
	.tb-item td, .tb-item th {
	    border: 1px solid black;
	    padding: 5px;
	}
</style>

<table border="0" width="100%">
    <tr>
        <td width="5%"><img src="<?php echo base_url() ?>assets/img/pit_stop.png" height="50" width="60"></td>
        <td width="20%"><strong>The Pit Stop</strong><br>Jl. Raya Cilameri Subang<br></td>
        <td width="35%"></td>
        <td width="30%" align="right"><br><br><H1 style="font-size:18px">INVOICE</H1></td>
    </tr>
</table>
<hr>

<table border="0" width="100%" id="tb-head">
	<tr style="	font-size: 12px;">
		<td width="10%"><strong>Nama</strong></td>
		<td width="50%"><?php echo $h["nama_pelanggan"] ?></td>
		<td width="10%"><strong>No. Invoice</strong></td>
		<td><?php echo $h["no_trans"] ?></td>
	</tr>
	<tr style="	font-size: 12px;">
		<td><strong>No. Telp</strong></td>
		<td><?php echo $h["no_hp"] ?></td>
		<td width="10%"><strong>Tanggal</strong></td>
		<td><?php echo date("d/m/Y", strtotime($h["created_on"])) ?></td>
	</tr>
	<tr style="	font-size: 12px;">
		<td><strong>Tipe Mobil</strong></td>
		<td><?php echo $h["plat"]." (".$h['kendaraan'].")" ?></td>
		<td width="10%"><strong>Pembayaran</strong></td>
		<td><?php echo $h["pembayaran"] ?></td>
	</tr>
</table>
<br>
<table border="1" width="100%" class="tb-item" style="	font-size: 12px;"> 
	<tr style="height: 30px;">
		<th>Nama Produk</th>
		<th width="10%">Qty</th>
		<th width="15%">Harga Satuan</th>
		<th width="10%">Diskon</th>
		<th width="15%">Total</th>
	</tr>

	<?php echo $item; ?>


	<tr>
		<td style="border-color: white"></td>
		<td align="right" style="border-bottom:1px hidden !important;"></td>
		<td align="center" colspan="2" style="border-color:black">Sub Total</td>
		<td align="right"><?php echo number_format($tl, 0, ",", "."); ?></td>
	</tr>

	<tr>
		<td style="border-color: white"></td>
		<td align="right" style="border-bottom:1px hidden !important;"></td>
		<td align="center" colspan="2" style="border-color:black">Total Jasa</td>
		<td align="right"><?php echo number_format($h['jasa'], 0, ",", "."); ?></td>
	</tr>
	<tr>
		<td style="border-color: white"></td>
		<td align="right" style="border-bottom:1px hidden !important;"></td>
		<td align="center" colspan="2" style="border-color:black"><strong>GRAND TOTAL</strong></td>
		<td align="right"><strong><?php echo number_format( $tl+$h['jasa']  , 0, ",", "."); ?></strong></td>
	</tr>
</table>
	<br>
	<br>
	<br>
<table border="0" width="100%" style="	font-size: 12px;">
	<tr>
		<td align="center">
			Penerima / Pembeli
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			
			<hr style="border-color:black;width: 30%; ">
		</td>
		<td align="center" width="50%">
			The Pit Stop
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<strong ><?php echo $h["nama"] ?>	</strong>
			<hr style="border-color:black;width: 30%; ">
		</td>
	</tr>
</table>

























