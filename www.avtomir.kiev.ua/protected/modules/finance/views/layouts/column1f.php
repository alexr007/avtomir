<?php 
	/* @var $this Controller */
	$this->beginContent('//layouts/main'); // это то что мы подгружаем как основной шаблон
	$this->renderPartial('/layouts/menu');
?>

<div id="content">
	<?php echo $content; ?>
</div><!-- content -->

<?php $this->endContent(); ?>