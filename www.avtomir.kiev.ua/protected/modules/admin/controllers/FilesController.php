<?php

class FilesController extends AdminController
{
	public function actionIndex()
	{
		$class = 'FilePrice'; // какого типа файлы загружаем
		
		$file = new $class;
		
		if(isset($_POST[$class]))
			if (($image = CUploadedFile::getInstance($file,'image')) !=null) {
				$file->image = $image;
				if ($file->uploadFile())
					$this->redirect(['index']);
				else {
					VarDumper::dump($file->getErrors());
					$file = new $class;
				}
			}
		
		$this->render('index',[
			'model'=>$file,
		]);
	}

	public function loadModel($id)
	{
		$model = File::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionDelete($id)
	{
		$file = $this->loadModel($id);
		$file->deleteFile();
	}
	
	public function actionDownload($id)
	{
		$file = $this->loadModel($id);
		$file->downloadFile();
	}
	
}
