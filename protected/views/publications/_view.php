<?php
/* @var $this PublicationsController */
/* @var $data Publications */
?>

<div class="view">

	<b><?php //echo CHtml::encode($data->getAttributeLabel('pub_id')); ?>:</b>
	<?php //echo CHtml::link(CHtml::encode($data->pub_id), array('view', 'id'=>$data->pub_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pub_title')); ?>:</b>
	<?php echo CHtml::encode($data->pub_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pub_fileid')); ?>:</b>
	<?php echo CHtml::encode($data->pub_fileid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pub_datecreated')); ?>:</b>
	<?php echo CHtml::encode($data->pub_datecreated); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pub_dispositiondate')); ?>:</b>
	<?php echo CHtml::encode($data->pub_dispositiondate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pub_pubtype')); ?>:</b>
	<?php echo CHtml::encode($data->pub_pubtype); ?>
	<br />


</div>