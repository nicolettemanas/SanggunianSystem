<?php
/* @var $this VotingsController */
/* @var $data Votings */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('vot_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->vot_id), array('view', 'id'=>$data->vot_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vot_title')); ?>:</b>
	<?php echo CHtml::encode($data->vot_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vot_description')); ?>:</b>
	<?php echo CHtml::encode($data->vot_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vot_votstatus')); ?>:</b>
	<?php echo CHtml::encode($data->vot_votstatus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vot_start')); ?>:</b>
	<?php echo CHtml::encode($data->vot_start); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vot_deadline')); ?>:</b>
	<?php echo CHtml::encode($data->vot_deadline); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vot_ord_id')); ?>:</b>
	<?php echo CHtml::encode($data->vot_ord_id); ?>
	<br />


</div>