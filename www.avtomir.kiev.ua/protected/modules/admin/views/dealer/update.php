<?php
/* @var $this DealerController */
/* @var $model DbDealer */

$this->breadcrumbs=array(
	'Db Dealers'=>array('index'),
	$model->dl_id=>array('view','id'=>$model->dl_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DbDealer', 'url'=>array('index')),
	array('label'=>'Create DbDealer', 'url'=>array('create')),
	array('label'=>'View DbDealer', 'url'=>array('view', 'id'=>$model->dl_id)),
	array('label'=>'Manage DbDealer', 'url'=>array('admin')),
);
?>

    <h2>Edit the Dealer: <b><?php echo $model->dl_name; ?></b></h2>

<?php
    $this->renderPartial('_form',
        ['model'=>$model,
         'country'=>$country,
        ]);
?>