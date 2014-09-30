<?php
/* @var $this CalendarController */
/* @var $data Calendar */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('cal_eventid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->cal_eventid), array('view', 'id'=>$data->cal_eventid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cal_eventtitle')); ?>:</b>
	<?php echo CHtml::encode($data->cal_eventtitle); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cal_ordid')); ?>:</b>
	<?php echo CHtml::encode($data->cal_ordid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cal_eventcreated')); ?>:</b>
	<?php echo CHtml::encode($data->cal_eventcreated); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cal_eventdispdate')); ?>:</b>
	<?php echo CHtml::encode($data->cal_eventdispdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cal_eventtype')); ?>:</b>
	<?php echo CHtml::encode($data->cal_eventtype); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cal_eventcontent')); ?>:</b>
	<?php echo CHtml::encode($data->cal_eventcontent); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('cal_eventdate')); ?>:</b>
	<?php echo CHtml::encode($data->cal_eventdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cal_eventauthorid')); ?>:</b>
	<?php echo CHtml::encode($data->cal_eventauthorid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cal_eventtime_from')); ?>:</b>
	<?php echo CHtml::encode($data->cal_eventtime_from); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cal_eventtime_to')); ?>:</b>
	<?php echo CHtml::encode($data->cal_eventtime_to); ?>
	<br />

	*/ ?>

</div>