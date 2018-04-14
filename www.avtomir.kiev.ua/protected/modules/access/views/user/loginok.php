<?php
/* @var $this UserController */
/* @var $form CActiveForm  */
/* @var $model UserLoginForm */

$this->pageTitle=Yii::app()->name . ' - Login User';

$this->breadcrumbs=array(
	'User'=>array('/access/user/admin'),
	'Login',
);
?>
<h2>Login User</h2>

<?php
	$redir1 = false;
    $redir2 = true;
	foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
		if ($key=="success") $redir1 = true; // login OK
		if ($key=="notice") $redir2 = false; // need fill profile
    }
	
	if ($redir1)
		Yii::app()->clientScript->registerMetaTag("3;url=".$this->createUrl($redir2 ? '/'.Yii::app()->defaultController/*'/site'*/ : 'profile'), null, 'refresh');
?>

</div><!-- form -->
