<?php
/* @var $this CalendarController */
/* @var $model Calendar */

$this->breadcrumbs=array(
	'Calendars'=>array('index'),
	$model->cal_eventid,
);

$this->menu=array(
	array('label'=>'List Calendar', 'url'=>array('index')),
	array('label'=>'Create Calendar', 'url'=>array('create')),
	array('label'=>'Update Calendar', 'url'=>array('update', 'id'=>$model->cal_eventid)),
	array('label'=>'Delete Calendar', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->cal_eventid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Calendar', 'url'=>array('admin')),
);
?>

<h1>View Calendar #<?php echo $model->cal_eventid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'cal_eventid',
		'cal_eventtitle',
		'cal_ordid',
		'cal_eventcreated',
		'cal_eventdispdate',
		'cal_eventtype',
		'cal_eventcontent',
		'cal_eventdate',
		'cal_eventauthorid',
		'cal_eventtime_from',
		'cal_eventtime_to',
	),
)); ?>
