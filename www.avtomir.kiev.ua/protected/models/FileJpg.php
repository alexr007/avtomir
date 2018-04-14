<?php

class FileJpg extends File
{
	public function getType()
	{
		return self::T_IMG;
	}
	
	public function getFolderAlias()
	{
		return 'jpg';
	}
}