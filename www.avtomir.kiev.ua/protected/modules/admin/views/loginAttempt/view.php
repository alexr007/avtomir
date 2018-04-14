<?php
/* @var $this LoginAttemptController */
/* @var $model DbUserLoginAttempt */

$this->breadcrumbs=array(
	'Db User Login Attempts'=>array('index'),
	$model->ul_id,
);

$this->menu=[];
?>

<h1>View DbUserLoginAttempt #<?php echo $model->ul_id; ?></h1>

<?php
	$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'ul_id',
		//'ul_userid',
		'date',
		'ul_successful',
		'ul_session',
		'ip',
		'ul_useragent',
		'ul_login',
	),
));
