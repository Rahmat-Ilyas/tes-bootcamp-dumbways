<?php 
	$dataKey = ['out', 'stand', 'king', 'and', 'lol', 'ding'];
	$word = 'outstandingking';

	check($dataKey, $word);

	function check($data, $string)
	{
		foreach ($data as $val) {
			$cek = strpos($string, $val);
			if ($cek == null && $cek < -1) {
				echo $val." = false<br>";
			} else {
				echo $val." = true<br>";
			}
		}
	}
?>