<?php
/* @var $this AnnouncementsController */
/* @var $model Announcements */

$this->breadcrumbs=array(
	'Announcements'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Announcements', 'url'=>array('index')),
	array('label'=>'Manage Announcements', 'url'=>array('admin')),
);
?>

<h1>Create Announcements</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>