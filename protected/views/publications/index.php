<?php
/* @var $this PublicationsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Publications',
);

$this->menu=array(
	array('label'=>'Create Publications', 'url'=>array('create')),
	array('label'=>'Manage Publications', 'url'=>array('admin')),
);
?>

<h1>Publications</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
