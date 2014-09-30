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
	array('label'=>'Ordinances for Second Reading', 'url'=>array('viewSecondReading')),
);
?>

<h1>Second Reading</h1>

<p>Upon recommendations of the Local Committee, please assign the proper parliamentary motions.</p>

<?php $this->renderPartial('_form_secondreading', array('model'=>$model)); ?>