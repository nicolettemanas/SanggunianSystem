<?php
/* @var $this UsersController */
/* @var $data Users */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->user_id), array('view', 'id'=>$data->user_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_username')); ?>:</b>
	<?php echo CHtml::encode($data->user_username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_email')); ?>:</b>
	<?php echo CHtml::encode($data->user_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_lastname')); ?>:</b>
	<?php echo CHtml::encode($data->user_lastname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_firstname')); ?>:</b>
	<?php echo CHtml::encode($data->user_firstname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_middlename')); ?>:</b>
	<?php echo CHtml::encode($data->user_middlename); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_usertype')); ?>:</b>
	<?php echo CHtml::encode($data->user_usertype); ?>
	<br />


</div>