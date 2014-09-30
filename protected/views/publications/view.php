<?php
/* @var $this PublicationsController */
/* @var $model Publications */

$this->breadcrumbs=array(
	'Publications'=>array('index'),
	$model->pub_id,
);

$this->menu=array(
	array('label'=>'List Publications', 'url'=>array('index')),
	array('label'=>'Create Publications', 'url'=>array('create')),
	array('label'=>'Update Publications', 'url'=>array('update', 'id'=>$model->pub_id)),
	array('label'=>'Delete Publications', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->pub_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Publications', 'url'=>array('admin')),
);
?>

<h1>View Publications #<?php echo $model->pub_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'pub_id',
		'pub_title',
		'pub_fileid',
		'pub_datecreated',
		'pub_dispositiondate',
		'pub_pubtype',
	),
)); ?>
