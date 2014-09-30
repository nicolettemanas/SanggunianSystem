<?php
/* @var $this OrdinancesController */
/* @var $model Ordinances */

$this->breadcrumbs=array(
	'Ordinances'=>array('index'),
	'Votings',
);

$this->menu=array(
	array('label'=>'List Ordinances', 'url'=>array('index')),
	array('label'=>'Manage Ordinances', 'url'=>array('admin')),
	array('label'=>'Ordinances for First Reading', 'url'=>array('viewFirstReading')),
);
?>

<h1>Voting</h1>

<p>No debate or amendment shall be allowed. Ordinance shall be read and the question upon its passage shall be immediately taken.</p>

<?php $this->renderPartial('_form_voting', array('model'=>$model, 'voting'=>$voting)); ?>