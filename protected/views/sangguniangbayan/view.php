<?php
/* @var $this SangguniangbayanController */
/* @var $model Sangguniangbayan */

$this->breadcrumbs=array(
	'Sangguniangbayans'=>array('index'),
	$model->sb_id,
);

$this->menu=array(
	array('label'=>'List Sangguniangbayan', 'url'=>array('index')),
	array('label'=>'Create Sangguniangbayan', 'url'=>array('create')),
	array('label'=>'Update Sangguniangbayan', 'url'=>array('update', 'id'=>$model->sb_id)),
	array('label'=>'Delete Sangguniangbayan', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->sb_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Sangguniangbayan', 'url'=>array('admin')),
);
?>

<h1>View Sangguniangbayan #<?php echo $model->sb_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'sb_id',
			'value'=>$model->getUser($model->sb_id),
		),
		'sb_lguposition',
	),
)); ?>
