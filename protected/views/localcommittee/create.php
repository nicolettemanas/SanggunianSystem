<?php
/* @var $this LocalcommitteeController */
/* @var $model Localcommittee */

$this->breadcrumbs=array(
	'Localcommittees'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Localcommittee', 'url'=>array('index')),
	array('label'=>'Manage Localcommittee', 'url'=>array('admin')),
);
?>

<h1>Create Localcommittee</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>