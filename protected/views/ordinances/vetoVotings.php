<?php
/* @var $this OrdinancesController */
/* @var $model Ordinances */

$this->breadcrumbs=array(
	'Ordinances'=>array('index'),
	'Votings (Veto)',
);

$this->menu=array(
	array('label'=>'List Ordinances', 'url'=>array('index')),
	array('label'=>'Manage Ordinances', 'url'=>array('admin')),
	array('label'=>'Ordinances for First Reading', 'url'=>array('viewFirstReading')),
);
?>

<h1>Voting</h1>

<p>Members of the sanggunian may override the veto of the Chief Executive.</p>

<?php $this->renderPartial('_form_vetovoting', array('model'=>$model, 'voting'=>$voting)); ?>