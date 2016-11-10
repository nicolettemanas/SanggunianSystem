<?php
/* @var $this VotingsController */
/* @var $model Votings */

$this->breadcrumbs=array(
	'Votings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Votings', 'url'=>array('index')),
	array('label'=>'Manage Votings', 'url'=>array('admin')),
);
?>

<h1>Create Votings</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>