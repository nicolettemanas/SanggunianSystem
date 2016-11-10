<?php
/* @var $this OrdinancesController */
/* @var $model Ordinances */

$this->breadcrumbs=array(
	'Ordinances'=>array('index'),
	'Propose',
);

$this->menu=array(
	array('label'=>'List Ordinances', 'url'=>array('index')),
	array('label'=>'Manage Ordinances', 'url'=>array('admin')),
);
?>

<h1>Propose an ordinance</h1>

<p>Proposed ordinances will be forwarded to the Sangguniang Barangay for Committee Assignment</p>

<?php $this->renderPartial('_form_propose', array('model'=>$model, 'lc_list'=>$lc_list)); ?>