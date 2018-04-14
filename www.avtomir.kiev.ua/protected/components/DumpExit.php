<?php

class DumpExit {
	
	public function __construct ($var,$exit = true)
	{
		echo "<br>dump:<br>====<br>";
		CVarDumper::dump($var,10,true);
		echo "<br>====<br>";
		if ($exit)
			Yii::app()->end();
    }
}