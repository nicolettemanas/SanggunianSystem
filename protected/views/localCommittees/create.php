<?php
/* @var $this LocalCommitteesController */
/* @var $model LocalCommittees */

$this->breadcrumbs=array(
	'Local Committees'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LocalCommittees', 'url'=>array('index')),
	array('label'=>'Manage LocalCommittees', 'url'=>array('admin')),
);
?>

<h1>Create LocalCommittees</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>