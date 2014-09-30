<?php
/* @var $this LgusController */
/* @var $model Lgus */

$this->breadcrumbs=array(
	'Lguses'=>array('index'),
	$model->lgu_id,
);

$this->menu=array(
	array('label'=>'List Lgus', 'url'=>array('index')),
	array('label'=>'Create Lgus', 'url'=>array('create')),
	array('label'=>'Update Lgus', 'url'=>array('update', 'id'=>$model->lgu_id)),
	array('label'=>'Delete Lgus', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->lgu_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Lgus', 'url'=>array('admin')),
);
?>

<h1>View Lgus #<?php echo $model->lgu_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'lgu_id',
		'lgu_lgutype',
	),
)); ?>
