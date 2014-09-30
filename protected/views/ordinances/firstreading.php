<?php
/* @var $this OrdinancesController */
/* @var $model Ordinances */

$this->breadcrumbs=array(
	'Ordinances'=>array('index'),
	'First Reading',
);

$this->menu=array(
	array('label'=>'List Ordinances', 'url'=>array('index')),
	array('label'=>'Manage Ordinances', 'url'=>array('admin')),
	array('label'=>'Ordinances for First Reading', 'url'=>array('viewFirstReading')),
);
?>

<h1>First Reading</h1>

<p>Please assign the following ordinance to its respective committee.</p>

<?php $this->renderPartial('_form_firstReading', array('model'=>$model)); ?>