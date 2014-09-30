<?php
/* @var $this AnnouncementsController */
/* @var $model Announcements */

$this->breadcrumbs=array(
	'Announcements'=>array('index'),
	$model->ann_id,
);

$this->menu=array(
	array('label'=>'List Announcements', 'url'=>array('index')),
	array('label'=>'Create Announcements', 'url'=>array('create')),
	array('label'=>'Update Announcements', 'url'=>array('update', 'id'=>$model->ann_id)),
	array('label'=>'Delete Announcements', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ann_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Announcements', 'url'=>array('admin')),
);
?>

<h1>View Announcement: <?php echo $model->ann_title; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array('label'=>'Title', 'value'=>$model->ann_title),
		array('label'=>'Author', 'value'=>$model->getAuthor($model->ann_id)),
		array('label'=>'Date created', 'value'=>$model->ann_creation_date),
		array('label'=>'Body', 'value'=>$model->ann_body),
	),
)); ?>
