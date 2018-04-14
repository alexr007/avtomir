<?php
/* @var $this SiteController */

//$this->pageTitle=Yii::app()->name;
$this->pageTitle='Avtomir';
?>

<h2>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h2>

<p>Hello</p>


<?php
if (Yii::app()->user->isGuest) {
?>
<p>You must login to access the features</p>
<?php
}
?>


