<?php
/* @var $this OrdinancesController */
/* @var $model Ordinances */

$this->breadcrumbs=array(
	'Ordinances'=>array('index'),
	'Upload Committee Report',
);

$this->menu=array(
	array('label'=>'List Ordinances', 'url'=>array('index')),
	array('label'=>'Manage Ordinances', 'url'=>array('admin')),
	array('label'=>'Pending for Committee Report', 'url'=>array('pendingCommitteeReport')),
);
?>

<h1>Committee Report</h1>
<?php $this->renderPartial('_form_committeereport', array('model'=>$model)); ?>