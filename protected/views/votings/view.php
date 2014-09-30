<?php
/* @var $this VotingsController */
/* @var $model Votings */

$this->breadcrumbs=array(
	'Votings'=>array('index'),
	$model->vot_id,
);

$this->menu=array(
	array('label'=>'List Votings', 'url'=>array('index')),
	array('label'=>'Create Votings', 'url'=>array('create')),
	array('label'=>'Update Votings', 'url'=>array('update', 'id'=>$model->vot_id)),
	array('label'=>'Delete Votings', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->vot_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Votings', 'url'=>array('admin')),
);
?>

<h1>View Votings #<?php echo $model->vot_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'vot_id',
		'vot_title',
		'vot_description',
		'vot_votstatus',
		'vot_start',
		'vot_deadline',
		'vot_ord_id',
	),
)); ?>
