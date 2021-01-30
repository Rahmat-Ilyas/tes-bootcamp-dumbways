<?php 
cetakPola(3);

function cetakPola($n) {
	$len = 5;
	for ($i=1; $i <= $len; $i++) { 
		for ($l=0; $l < $n; $l++) { 
			for ($j=1; $j <= $len; $j++) { 
				if ($j == $i+2 || $j == $i-2) {
					echo "*";
				} else if (($j == 2 && $i == 2) || ($j == 4 && $i == 4)) {
					echo "*";
				}
				else {
					echo "&nbsp;&nbsp;";
				}
			}
		}
		echo "<br>";
	}
}
?>