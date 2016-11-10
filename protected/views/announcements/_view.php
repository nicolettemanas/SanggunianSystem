<?php
/* @var $this AnnouncementsController */
/* @var $data Announcements */

$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerCssFile($baseUrl.'/css/details.css');

$model = new Announcements();

?>

<div class="view">

	<h3><?php echo CHtml::encode($data->ann_title); ?></h3>
	<?php echo CHtml::encode($data->ann_body); ?>
	<br />
	<br />

</div>