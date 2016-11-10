<?php
/* @var $this LocalCommitteesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Local Committees',
);

$this->menu=array(
	array('label'=>'Create LocalCommittees', 'url'=>array('create')),
	array('label'=>'Manage LocalCommittees', 'url'=>array('admin')),
);
?>

<h1>Local Committees</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
