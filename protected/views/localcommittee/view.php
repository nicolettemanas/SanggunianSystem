<?php
/* @var $this LocalcommitteeController */
/* @var $model Localcommittee */

$this->breadcrumbs=array(
	'Localcommittees'=>array('index'),
	$model->lc_id,
);

$this->menu=array(
	array('label'=>'List Localcommittee', 'url'=>array('index')),
	array('label'=>'Create Localcommittee', 'url'=>array('create')),
	array('label'=>'Update Localcommittee', 'url'=>array('update', 'id'=>$model->lc_id)),
	array('label'=>'Delete Localcommittee', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->lc_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Localcommittee', 'url'=>array('admin')),
);
?>

<h1>View Localcommittee #<?php echo $model->lc_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'lc_id',
		'lc_lguposition',
		'lc_committeename',
	),
)); ?>
