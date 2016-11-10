<?php
/* @var $this LocalcommitteeController */
/* @var $data Localcommittee */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lc_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lc_id), array('view', 'id'=>$data->lc_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lc_lguposition')); ?>:</b>
	<?php echo CHtml::encode($data->lc_lguposition); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lc_committeename')); ?>:</b>
	<?php echo CHtml::encode($data->lc_committeename); ?>
	<br />


</div>