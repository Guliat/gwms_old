<?php
	include ('num2bgmoney-f.php');

	$num = (float)preg_replace("/[^0-9\.]/","",@$_GET["translate"]);
	$invoiceid = $_GET["invoiceid"];

	if (!$num)
		$num = 0.001;

	if ($num) {
		$translated = number2lv($num);
		
	#	print "Текст: <b>".number2lv($num)."</b><br><br>";
	}

	$num = number_format($num,2,".","");
	header('Location: translated?invoiceid='.$invoiceid.'&sl='.$translated);

?>