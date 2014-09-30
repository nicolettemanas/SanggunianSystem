<?php
/* @var $this LgusController */
/* @var $data Lgus */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lgu_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lgu_id), array('view', 'id'=>$data->lgu_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lgu_lgutype')); ?>:</b>
	<?php echo CHtml::encode($data->lgu_lgutype); ?>
	<br />


</div>