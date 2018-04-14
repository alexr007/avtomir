<?php
/* @var $this UserController */
/* @var $form CActiveForm  */
/* @var $model UserCreateForm */

$this->pageTitle=Yii::app()->name . ' - Create User';

$this->breadcrumbs=array(
	'User'=>array('/access/user/admin'),
	'Create',
);
?>
<h2>Create User</h2>

<?php
	echo '<div class="flash-error">User create error</div>';
	Yii::app()->clientScript->registerMetaTag("5;url=".$this->createUrl('create'), null, 'refresh');
?>

</div>
