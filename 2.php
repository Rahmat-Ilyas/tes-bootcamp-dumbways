<?php 
$kalimat = "Saya mau makan sate bersama teman saya setelah lulus dari sekolah dasar";
$huruf = "a";
hitung_huruf($huruf,  $kalimat);

function hitung_huruf($huruf,  $string) {
	$exist = 0;
	for ($i=0; $i < strlen($string); $i++) { 
		if ($huruf == substr($string, $i, 1)) {
			$exist = $exist + 1;
		}
	}
	
	echo 'Hasil hitungn huruf <b>"'.$huruf.'"</b> muncul sebanyak <b>'.$exist.' Kali</b>';
}
?>