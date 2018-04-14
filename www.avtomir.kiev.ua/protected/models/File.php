<?php

class File extends CActiveRecord
{
	const T_XLS = 1;
	const T_IMG = 2;
    const T_TXT = 3;

	const ROOT_FOLDER_ALIAS = 'webroot.data.files';
	
	private $_root_folder_alias;
	private $_type;
	
	public $image;
	
	public function tableName()
	{
		return 'files';
	}

	public function rules()
	{
		return [
//			['image', 'file', 'types'=>'jpg, gif, png', 'maxSize' => 1000000, 'allowEmpty'=>false],
			//['fi_id, fi_original_name, fi_given_name, fi_ext, fi_path_alias, fi_description, fi_owner, fi_perm, fi_flag', 'safe'],
		];
	}

	public function attributeLabels()
	{
		return array(
		'fi_id'=>'id', 
		'fi_original_name'=>'Original File Name',
		'fi_given_name'=>'Given File Name', 
		'fi_ext'=>'File Extension', 
		'fi_path_alias'=>'path alias', 
		'fi_description'=>'File Description', 
		'fi_owner'=>'File Owner', // for future
		'fi_perm'=>'File Permission', // for future
		'fi_flag'=>'Flag', // for future
		'fi_category'=>'Category',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('fi_id',$this->fi_id);
		$criteria->compare('lower(fi_original_name)',mb_strtolower($this->fi_original_name),true);
		$criteria->compare('lower(fi_given_name)',mb_strtolower($this->fi_given_name),true);
		$criteria->compare('lower(fi_ext)',mb_strtolower($this->fi_ext),true);
		$criteria->compare('lower(fi_path_alias)',mb_strtolower($this->fi_path_alias),true);
		$criteria->compare('lower(fi_description)',mb_strtolower($this->fi_description),true);
		$criteria->compare('fi_owner',$this->fi_owner);
		$criteria->compare('fi_perm',$this->fi_perm);
		$criteria->compare('fi_flag',$this->fi_flag);
		$criteria->compare('fi_category',$this->fi_category);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function scopes()
    {
		return [
            'xls'=>[
				'condition'=>"fi_category=".self::T_XLS,
				],
            'img'=>[
				'condition'=>"fi_category=".self::T_IMG,
				],
        ];
    }
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function findByType($type)
	{
		return static::model()->findAllByAttributes( ['fi_category'=>(int)$type] );
	}
	
	public static function findXls()
	{
		return static::findByType(self::T_XLS);
	}

	public static function findImg()
	{
		return static::findByType(self::T_IMG);
	}
	
	public function aliasToPath($alias)
	{
		return Yii::getPathOfAlias($alias).DIRECTORY_SEPARATOR;
	}
	
	protected function beforeSave()
    {
        if (parent::beforeSave()) {
			$this->fi_date = new DbCurrentTimestamp();
			return true;
		}
		return false;
    }
	
	public function getDateS()
	{
		return (new DateFormatted($this->fi_date))->date();
	}	
	
	public function getRandomName()
	{
		return 
			//md5(uniqid(rand(),true));
			md5(microtime() . rand(0, 9999));
	}

    public function getRandomFileName($path='', $extension='')
    {
        $extension = $extension ? '.'.$extension : '';
        $path = $path ? $path.DIRECTORY_SEPARATOR : '';
 
        do {
            $name = $this->getRandomName();
            $file = $path . $name . $extension;
        } while (file_exists($file));
 
        return $name;
    }

	public function getRootFolderAlias()
	{
		return self::ROOT_FOLDER_ALIAS;
	}

	// чтобы файлы складывались в другую папку
	// надо в новом классе переопредилить только эту функцию
	public function getFolderAlias()
	{
		return "";
	}
	
	public function getFullFolderAlias()
	{
		return  $this->getFolderAlias() ? $this->getRootFolderAlias().'.'.$this->getFolderAlias()
										: $this->getRootFolderAlias();
	}
	
	// getFullFolderPath - полный путь к файлу на сервере
	public function getFullFolderPath()
	{
		return $this->aliasToPath($this->getFullFolderAlias());
	}
	
	/*	загружаем файл на сервер
        $file=new File;
		$file->attributes=$_POST['File'];
		$file->image = CUploadedFile::getInstance($file,'image');
		$file->upload();
	*/
	public function uploadFile()
	{
		// PHP.INI -- upload_max_filesize = 2M !!!

		if (!$this->image) return false;
		
		$info = new SplFileInfo($this->image->getName());
		$ext = $info->getExtension();
		$name = $info->getBasename('.'.$ext);

		$random = $this->getRandomFileName($this->getFullFolderPath());
		
		$this->fi_original_name = $name;
		$this->fi_ext = $ext;
		$this->fi_path_alias = $this->getFullFolderAlias();
		$this->fi_given_name = $random;
		$this->fi_category = $this->getType();
		
		if ($this->validate()){
			$full_file_name = $this->getFullFolderPath().$random.'.'.$ext;
			$this->image->saveAs($full_file_name);
			return $this->save();
		} 
		return false;
	}
	
	// downloadFileName - имя файла, как мы хотим, чтоб он назывался при загрузке
	public function getDownloadFileName() 
	{
		return 
			//$this->fi_given_name
			$this->fi_original_name
			.'.'.$this->fi_ext;
	}
	
	// полный путь к файлу на сервере на основании инвормации в БД.
	public function getFullFilePath()
	{
		$alias = $this->fi_path_alias;
		$path = $this->aliasToPath( $alias );
		return $path.$this->fi_given_name.'.'.$this->fi_ext;
	}
	
	// загружаем файл на ЛОКАЛЬНУЮ машину
	public function downloadFile()
	{
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-Disposition: attachment; filename=" . $this->getDownloadFileName());
		header("Content-Transfer-Encoding: binary ");  

		readfile($this->getFullFilePath());
	}
	
	public function deleteFile()
	{
		$path = $this->getFullFilePath();
		
		if (file_exists($path)) unlink($path);
		$this->delete();
	}
	
}
