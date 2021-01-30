<!DOCTYPE html>
<html>
<head>
	<title>Hitung Kredit Rumah</title>
	<style type="text/css">
		body {
			background: #FFFFFF;
			font-family: 'Noto Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;
			color: #797979;
		}

		.form-control {
			background-color: #FFFFFF;
			border: 1px solid #E3E3E3;
			border-radius: 4px;
			color: #565656;
			padding: 7px 12px;
			height: 38px;
			width: 200px;
		}

		.btn {
			padding: 6px 12px;
			font-size: 14px;
			font-weight: 400;
			line-height: 1.5;
			text-align: center;
			cursor: pointer;
			border: 1px solid transparent;
			border-radius: 4px;
			background-color: #5d9cec ;
			color: #FFFFFF;
		}

		.item {
			margin-bottom: 5px;
		}

		table {
			border: 1px solid #dee2e6;
		}

		table td, table th {
			padding: 10px;
			border: 1px solid #dee2e6;
			text-align: inherit;
		}
	</style>
</head>
<body>
	<h2>Menghitung Kredit Cicilan Rumah</h2>
	<hr>
	<form method="POST">
		<label><b>Tipe Rumah</b></label><br>
		<select name="tipe" class="form-control" required="">
			<option value="">--Pilih Tipe--</option>
			<option value="Rose">Rose</option>
			<option value="Gold">Gold</option>
			<option value="Platinum">Platinum</option>
		</select>
		<br><br>
		<label><b>Lama Cicilan</b></label><br>
		<select name="lama" class="form-control" required="">
			<option value="">--Lama Cicilan--</option>
			<option value="12">12 Bulan</option>
			<option value="18">18 Bulan</option>
			<option value="24">24 Bulan</option>
		</select>
		<br><br>
		<button type="submit" name="submit" class="btn">Tampilkan Rincian</button>
	</form>
	<br>
	<hr>

	<?php 
	if (isset($_POST['submit'])) {
		$tipe = $_POST['tipe'];
		$lama = $_POST['lama'];

		if ($tipe == 'Rose') $harga = 120000000;
		else if ($tipe == 'Gold') $harga = 300000000;
		else if ($tipe == 'Platinum') $harga = 360000000; 

		$uang_muka = 20/100*$harga;
		$sisa_bayar = $harga - $uang_muka;
		$angsuran = $sisa_bayar/$lama;
		?>
		<h4><u>Rincian Pembayaran:</u></h4>
		<div class="item">
			<b>Tipe Rumah: </b>
			<span><?= $tipe ?></span>
		</div>
		<div class="item">
			<b>Harga Rumah: </b>
			<span>Rp. <?= number_format($harga) ?></span>
		</div>
		<div class="item">
			<b>Uang Muka: </b>
			<span>Rp. <?= number_format($uang_muka) ?></span>
		</div>
		<div class="item">
			<b>Sisa Pembayaran: </b>
			<span>Rp. <?= number_format($sisa_bayar) ?></span>
		</div>
		<div class="item">
			<b>Lama Kredit: </b>
			<span><?= $lama ?> Bulan</span>
		</div>
		<div class="item">
			<b>Anggsuran: </b>
			<span>Rp. <?= number_format($angsuran) ?></span>
		</div>
		<br>
		<b>Table Angsran:</b>
		<table border="1">
			<thead>
				<tr>
					<th width="100">Bulan Ke</th>
					<th width="200">Angsuran</th>
					<th width="200">Sisa Pembayaran</th>
				</tr>
			</thead>
			<tbody>
				<?php for ($i=1; $i <= $lama ; $i++) { ?>
					<tr>
						<td>Bulan Ke <?= $i ?></td>
						<td>Rp. <?= number_format($angsuran) ?></td>
						<td>Rp. <?= number_format($sisa_bayar-($angsuran*$i)) ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } ?>
</body>
</html>