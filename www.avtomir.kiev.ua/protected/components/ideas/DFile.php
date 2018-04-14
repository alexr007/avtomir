<?php

class DFile extends DActiveRecord
{
	public $uploadPath; // Путь к папке загрузки


	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('application.data.files');
	}

	public static function upload($objFile)
	{
		$modFile = new DFile;
		$modFile->name = $objFile->name;
		$modFile->source = uniqid();

		if ($objFile->saveAs($modFile->uploadPath . '/' .  $modFile->source))
			if ($modFile->save()) 
				return $modFile;

		return null;
	}
	
	public function downloadLink($htmlOptions = array())
	{
		return CHtml::link($this->name, array('/files/file/download', 'id' => $this->id), $htmlOptions);
	}
	
}