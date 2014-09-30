<?php
/* @var $this OrdinancesController */
/* @var $data Ordinances */


$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerCssFile($baseUrl.'/css/details.css');

?>

<div class="view">
	<h3><?php echo CHtml::encode($data->ord_title); ?></h3>
	<?php echo CHtml::encode($data->ord_description); ?>
	<br />
	<br />
	<?php echo "Author: ".CHtml::encode($data->getAuthor($data->ord_id)); ?>
	<br />
	<br />
	<?php echo CHtml::link(CHtml::encode("View Ordinance"), array('view', 'id'=>$data->ord_id), array('class'=>'detail')); ?>
</div>
