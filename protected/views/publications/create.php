<?php
/* @var $this PublicationsController */
/* @var $model Publications */

$this->breadcrumbs=array(
	'Publications'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Publications', 'url'=>array('index')),
	array('label'=>'Manage Publications', 'url'=>array('admin')),
);
?>

<h1>Create Publications</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>