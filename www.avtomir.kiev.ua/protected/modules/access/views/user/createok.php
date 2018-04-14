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
	echo '<div class="flash-success">User successfully created.<br>You can go '
	.CHtml::link('login',['login'])
	.'</div>';
	Yii::app()->clientScript->registerMetaTag("5;url=".$this->createUrl('login'), null, 'refresh');
?>

</div><!-- form -->
