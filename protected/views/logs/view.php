<?php
/* @var $this LogsController */
/* @var $model Logs */

$this->breadcrumbs=array(
	'Logs'=>array('index'),
	$model->log_id,
);

$this->menu=array(
	array('label'=>'List Logs', 'url'=>array('index')),
	array('label'=>'Create Logs', 'url'=>array('create')),
	array('label'=>'Update Logs', 'url'=>array('update', 'id'=>$model->log_id)),
	array('label'=>'Delete Logs', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->log_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Logs', 'url'=>array('admin')),
);
?>

<h1>View Logs #<?php echo $model->log_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'log_id',
		'log_userid',
		'log_username',
		'log_activity',
		'log_date',
	),
)); ?>
