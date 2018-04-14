<?php

class FileModel extends DActiveRecord 
{
    public $id_image;
	public $root_folder;
	
	const ROOT_FOLDER = 'webroot.data.files';
	
	public function init()
    {
		$this->root_folder = self::$ROOT_FOLDER;
		return parent::init();
    }
	
	public function getRootFolder()
	{
		return $this->$root_folder;
	}
	
    public function rules(){
        return [
            ['id_image', 'DImageValidator', 'allowEmpty' => true],
        ];
    }

	public function relations()
	{
		return [
			'image' => [self::BELONGS_TO, 'DImage', 'id_image'],
		];
	}

	public function beforeSave()
	{
		foreach ($this->attributes as $key => $attribute) 
			if ($attribute instanceof CUploadedFile)
			{
				//$unique = DFileHelper::getRandomFileName;
				//if ($attribute->saveAs(Yii::getPathOfAlias($this->rootFolder) . '/' .  $unique))
				//	$this->$key = $unique;

				$modFile = DFile::upload($attribute);	// Загрузку отдали DFile
				$this->$key = $modFile->id;
			}
		return parent::beforeSave();
	}
}