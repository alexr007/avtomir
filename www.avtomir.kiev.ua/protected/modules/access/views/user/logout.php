<?php
/* @var $this UserController */
/* @var $form CActiveForm  */
/* @var $model UserLogoutForm */

$this->pageTitle=Yii::app()->name . ' - Logout User';

$this->breadcrumbs=array(
	'User'=>array('/users/user'),
	'Logout',
);
?>
<h2>Logout User</h2>
<?php
	echo '<div class="flash-success">User successfully logged out</div>';

	Yii::app()->clientScript->registerMetaTag("5;url=".$this->createUrl('login'), null, 'refresh');
?>
