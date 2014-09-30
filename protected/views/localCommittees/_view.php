<?php
/* @var $this LocalCommitteesController */
/* @var $data LocalCommittees */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lc_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lc_id), array('view', 'id'=>$data->lc_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lc_name')); ?>:</b>
	<?php echo CHtml::encode($data->lc_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lc_chariman_id')); ?>:</b>
	<?php echo CHtml::encode($data->getUser($data->lc_chariman_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lc_secretary_id')); ?>:</b>
	<?php echo CHtml::encode($data->getUser($data->lc_secretary_id)); ?>
	<br />
	
</div>