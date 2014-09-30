<?php
/* @var $this LogsController */
/* @var $model Logs */

$this->breadcrumbs=array(
	'Logs'=>array('index'),
	$model->log_id=>array('view','id'=>$model->log_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Logs', 'url'=>array('index')),
	array('label'=>'Create Logs', 'url'=>array('create')),
	array('label'=>'View Logs', 'url'=>array('view', 'id'=>$model->log_id)),
	array('label'=>'Manage Logs', 'url'=>array('admin')),
);
?>

<h1>Update Logs <?php echo $model->log_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>