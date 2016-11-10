<?php
/* @var $this SangguniangbayanController */
/* @var $model Sangguniangbayan */

$this->breadcrumbs=array(
	'Sangguniangbayans'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Sangguniang Bayan', 'url'=>array('index')),
	array('label'=>'Manage Sangguniang Bayan', 'url'=>array('admin')),
);
?>

<h1>Add Sangguniang Bayan</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>