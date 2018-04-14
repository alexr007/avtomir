<?php

class FileXls extends File
{
	public function rules()
	{
		return [
			['image', 'file', 'types'=>'xls, xlsx', 'allowEmpty'=>false], //, 'maxSize' => 1000000
		];
	}
	
	public function getType()
	{
		return self::T_XLS;
	}
	
	public function getFolderAlias()
	{
		return 'xls';
	}

}