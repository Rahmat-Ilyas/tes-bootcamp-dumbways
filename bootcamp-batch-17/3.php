<?php 
	cetak_gambar(10);

	function cetak_gambar($n)
	{
		if ($n < 2 || $n%2 != 0) {
			echo "Nilai parameter harus bilangan genap dan harus lebih dari 2";
		} else {
			for ($i=0; $i < $n; $i++) { 
				for ($j=1; $j < $n+1; $j++) {
					if ($i == 0 || $i == $n-1 || $j%3 == 0) {
						echo "&nbsp+&nbsp;";
					} else {
						echo "&nbsp;=&nbsp;";
					}
				}
				echo "<br>";
			}
		}
	}
?>