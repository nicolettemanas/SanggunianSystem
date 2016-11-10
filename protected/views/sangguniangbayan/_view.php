<?php
/* @var $this SangguniangbayanController */
/* @var $data Sangguniangbayan */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('sb_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->getUser($data->sb_id)), array('view', 'id'=>$data->sb_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sb_lguposition')); ?>:</b>
	<?php echo CHtml::encode($data->sb_lguposition); ?>
	<br />


</div>