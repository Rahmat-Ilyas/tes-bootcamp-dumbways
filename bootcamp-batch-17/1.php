<?php 
	$produk = [
		['id' => '1', 'nama' => 'sepeda satu'],
		['id' => '2', 'nama' => 'sepeda gunung'],
		['id' => '3', 'nama' => 'sepeda sport'],
	];

	foreach ($produk as $data) {
		$code = generate($data['id'],$data['nama']);
		echo $code."<br>";
	}


	function generate($id, $nama_produk)
	{
		$getData = md5($id.$nama_produk);
		$code = substr($getData, 0, 8);
		$str1 = substr($code, 0, 4);
		$str2 = substr($code, 4, 8);
		$uniqueCode = $str1."-".$str2;
		return $uniqueCode;
	}
?>