<?php
/* @var $this AnnouncementsController */
/* @var $model Announcements */

$this->breadcrumbs=array(
	'Announcements'=>array('index'),
	$model->ann_id=>array('view','id'=>$model->ann_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Announcements', 'url'=>array('index')),
	array('label'=>'Create Announcements', 'url'=>array('create')),
	array('label'=>'View Announcements', 'url'=>array('view', 'id'=>$model->ann_id)),
	array('label'=>'Manage Announcements', 'url'=>array('admin')),
);
?>

<h1>Update Announcement: <?php echo $model->ann_title; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>