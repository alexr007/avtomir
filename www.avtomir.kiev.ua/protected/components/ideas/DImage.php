<?php

class DImage extends DFile
{
	public $assetsPath; // Путь к папке с ресурсами
	public $assetsUrl;	// URL папки с ресурсами
	public $thumbs = [
		'min' => ['width' => 150, 'height' => 150],
		'mid' => ['width' => 250],
		'big' => ['width' => 600],
		'real' => [],
	];

	public function init()
	{
		$this->assetsUrl = Yii::app()->assetManager->baseUrl . '/files';
		$this->assetsPath = Yii::app()->assetManager->basePath . '/files';

		if (!is_dir($this->assetsPath)) mkdir($this->assetsPath);
	}

	// Все миниатюры должны находиться в $this->assetsPath
	public function getIsPublished()
	{
		foreach ($this->thumbs as $kThumb => $vThumb)
			if (!is_file($this->assetsPath . '/' . $this->source . '_' . $kThumb)) return false;
		return true;
	}

	// Публикация миниатюр
	public function publish()
	{
		if (!$this->isPublished)
			foreach ($this->thumbs as $kThumb => $vThumb)
				$this->createThumb($this->uploadPath . '/' . $this->source, 
									$this->assetsPath . '/' . $this->source . '_' . $kThumb, 
									$kThumb);			

		return 	$this->assetsUrl . '/' . $this->source;
	}

	// Создание миниатюр
	function createThumb($strSrcFile, $strDstFile, $strThumb)
	{
		// Создает миниатюру картинки $strSrcFile, сохраняет в $strDstFile
	}
	
	public function image($strThumb = 'min', $htmlOptions = [])
	{
		return CHtml::image($this->publish() . '_' . $strThumb, $this->name, $htmlOptions);
	}	
}