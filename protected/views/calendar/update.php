<?php
/* @var $this CalendarController */
/* @var $model Calendar */

$this->breadcrumbs=array(
	'Calendars'=>array('index'),
	$model->cal_eventid=>array('view','id'=>$model->cal_eventid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Calendar', 'url'=>array('index')),
	array('label'=>'Create Calendar', 'url'=>array('create')),
	array('label'=>'View Calendar', 'url'=>array('view', 'id'=>$model->cal_eventid)),
	array('label'=>'Manage Calendar', 'url'=>array('admin')),
);
?>

<h1>Update Calendar <?php echo $model->cal_eventid; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>