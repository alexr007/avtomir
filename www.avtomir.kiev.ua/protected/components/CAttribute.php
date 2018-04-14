<?php

class CAttribute {
	
	const PATH = 'tmp/filter-';
	const VALID_SECONDS = 3600;
	const CHECK_VALID = true;
	const DELETE_IF_INVALID = true;
	
public static function filename($var)
{
	$user_id = Yii::app()->user->id;
	$file = new File;
	return $file->getFullFolderAlias().self::PATH.$user_id.'-'.get_class($var);
}
	

// save serialized object to file	
public static function save($class, $prop = null)
{
	$fname = self::filename($class);
	
	$what = $prop ? $class->$prop : $class;
	file_put_contents($fname, serialize($what));
}

// load serialized object from file	
public static function load($class)
{
	$fname = self::filename($class);
	$valid = true;
	
	if (file_exists($fname)) {
		
		if (self::CHECK_VALID)
			$valid = $valid && (microtime (true) - filemtime ($fname) < self::VALID_SECONDS);
	
		$result = $valid ? unserialize(file_get_contents($fname)) : null;

		if (!$valid && self::DELETE_IF_INVALID)
			unlink ($fname);
		
	}	else $result = null;
	
	return $result;
}

}
?>