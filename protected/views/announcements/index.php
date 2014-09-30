<?php
/* @var $this AnnouncementsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Announcements',
);

$this->menu=array(
	array('label'=>'Create Announcements', 'url'=>array('create')),
	array('label'=>'Manage Announcements', 'url'=>array('admin')),
);
?>

<h1>Announcements</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
