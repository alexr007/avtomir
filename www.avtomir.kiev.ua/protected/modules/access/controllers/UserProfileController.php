<?php

class UserProfileController extends AccessController
{

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model=new UserProfile;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['UserProfile']))
		{
			$model->attributes=$_POST['UserProfile'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->up_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['UserProfile']))
		{
			$model->attributes=$_POST['UserProfile'];
			if($model->save())
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['admin']);
			// admin/UserProfile[up_user]/80
		}

		$users = DbUser::listData(['realonly'=>true]);
		$user_profile_fields = UserProfileFields::listData();
		/*
		$countries = Countries::listData(['show_all'=>false, 'show_empty'=>true]);
		$destinations = Destinations::listData(['show_all'=>false, 'show_empty'=>true]);
		$operators = Operators::listData(['show_all'=>false, 'show_empty'=>true]);
		$shippingmethods = Shippingmethods::listData(['show_all'=>false, 'show_empty'=>true]);
		$companies = Company::listData(['show_all'=>false, 'show_empty'=>true]);
		*/
		
		$this->render('update',array(
			'model' => $model,
			'users' => $users,
			'user_profile_fields' => $user_profile_fields,
			/*
			'countries' => $countries,
			'destinations' => $destinations,
			'operators' => $operators,
			'shippingmethods'=> $shippingmethods,
			'companies'=> $companies,
			*/
		));
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('UserProfile');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model=new UserProfile('search');
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['UserProfile'])){
			$model->attributes=$_GET['UserProfile'];
			//CAttribute::save($model, 'attributes');
		} else
			;//$model->attributes = CAttribute::load($model);

		//$model = $model->enabled();
		
		$user_profile_fields = UserProfileFields::listData();
		$users = DbUser::listData(['realonly'=>true]);

		$this->render('admin',array(
			'controller'=>$this,
			'model'=>$model,
			'user_profile_fields'=>$user_profile_fields,
			'users'=>$users,
		));
	}

	public function actionSubmitChanges()
	{
		$post = new PostData($_POST, 'UserProfile', new PostFields(['up_value']), false);
        $post->updateDataset(UserProfile::model()->findAllByAttributes(['up_id'=>$post->keysToArray()]));
		$this->redirect(['admin']);
	}

	public function loadModel($id)
	{
		$model=UserProfile::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-profile-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}
