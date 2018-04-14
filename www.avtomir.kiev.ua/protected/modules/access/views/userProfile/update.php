<?php
/* @var $this UserProfileController */
/* @var $model UserProfile */

$this->breadcrumbs=array(
	'User Profiles'=>array('index'),
	$model->up_id=>array('view','id'=>$model->up_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UserProfile', 'url'=>array('index')),
	array('label'=>'Create UserProfile', 'url'=>array('create')),
	array('label'=>'View UserProfile', 'url'=>array('view', 'id'=>$model->up_id)),
	array('label'=>'Manage UserProfile', 'url'=>array('admin')),
);
?>

<h2>Edit profile for user <b><?php echo $users[$model->up_user]; ?></b></h2>

<?php
//	VarDumper::dump($users);
	$this->renderPartial('_form', [
			'model'=>$model,
			'users'=>$users,
			'user_profile_fields' => $user_profile_fields,
			/*
			'countries' => $countries,
			'destinations' => $destinations,
			'operators' => $operators,
			'shippingmethods'=> $shippingmethods,
			'companies'=> $companies,
			*/
		]);
?>