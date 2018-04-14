<?php

class UserController extends AccessController
{
	public $layout='/layouts/column2access_user';
	
	public function accessRules()
	{
		return [
			['allow', 'users'=>['*'], ],
		];
	}

	public function actionCreate()
	{
		$model = new FormUserCreate;

		if(isset($_POST['ajax']) && $_POST['ajax']==='form-u-create')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['FormUserCreate']))
		{
			$model->attributes=$_POST['FormUserCreate'];
			if ($model->validate() && $model->usercreate())
				$this->redirect(['createOk']);
			 else
				$this->redirect(['createErr']);
		} 
		
		$this->render('create',[
			'model'=>$model,
		]);
		
	}

	public function actionCreateOk()
	{
		$this->render('createok',[]);
	}
	
	public function actionCreateErr()
	{
		$this->render('createerr',[]);
	}
	
	public function actionLogin()
	{
        ob_start();

        $model = new FormUserLogin;

		if(isset($_POST['ajax']) && $_POST['ajax']==='form-u-login')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['FormUserLogin']))
		{
			$model->attributes=$_POST['FormUserLogin'];

			if($model->validate() && $model->userlogin())
				$this->redirect(['loginOk']);
			
			$model->unsetAttributes();
		}
		
		// если даных нет - рисуем форму
		$this->render('login',[
			'model'=>$model,
		]);
		
	}
	// ===============================================================

	public function actionLoginOk()
	{
		Yii::app()->user->setFlash('success', "User successfully logged in");
		
		$_ident = new UserIdentity('','');
		$_ident->setId(Yii::app()->user->id);
		
		if ($_ident->isStage1register() ) {
			Yii::app()->user->setFlash('notice', "This is first time login.<br>You must fill profile ".CHtml::link('here',['profile']) );
			//UserTags::createInitialTags();
		}
		
		$this->render('loginok',[]);
	}
	// ===============================================================
	
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->render('logout');
	}

	public function actionProfile()
	{
		if (Yii::app()->user->isGuest) $this->redirect(['login']);
		UserProfile::createCleanProfile(Yii::app()->user->id);
		
		$model = new FormUserProfile;
		$model->setAttributes( $model->getIdentity()->getAttributes() );
		
		// если AJAX валидация
		if(isset($_POST['ajax']) && $_POST['ajax']==='form-u-profile')	{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// проверяем есть ли данные
		if(isset($_POST['FormUserProfile'])) {
			$model->attributes=$_POST['FormUserProfile'];

			if (!$model->validate()) 
				Yii::app()->user->setFlash('error', "Fillind details validate error");
			
			elseif (!$model->usersave()) 
				Yii::app()->user->setFlash('error', "Error while update user's profile");
				
			else 	
				Yii::app()->user->setFlash('success', "User successfully filled profile details");
		} 
		
		$this->render('profile',[
			'model'=>$model,
		]);
	}

	public function actionRestore()
	{
		//Yii::app()->user->clearFlashes();
		$model = new FormUserRestore;

		// если AJAX валидация
		if(isset($_POST['ajax']) && $_POST['ajax']==='form-u-restore')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// проверяем есть ли данные
		if(isset($_POST['FormUserRestore']))
		{
			// есть данные - ищем пользователя.
			$model->attributes=$_POST['FormUserRestore'];
			
			if ($model->seekuser()) {
				$e = $model->restorepassword();
				Yii::app()->user->setFlash('success', "User found. e-mail with instructions how to restore the password sent to ".$e);
			} else Yii::app()->user->setFlash('error', "User not found. e-mail not sent");
		}
		
		// даных нет - рисуем форму
		$this->render('restore',[
			'model'=>$model,
		]);
		
	}
	
}