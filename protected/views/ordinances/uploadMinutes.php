<?php
/* @var $this OrdinancesController */
/* @var $model Ordinances */

$this->breadcrumbs=array(
	'Ordinances'=>array('index'),
	'Minutes of the Meeting',
);

$this->menu=array(
	array('label'=>'List Ordinances', 'url'=>array('index')),
	array('label'=>'Manage Ordinances', 'url'=>array('admin')),
);
?>

<h1>Upload Minutes of the Meeting</h1>

<p>Please upload the associated minutes of the meeting to the public hearing.</p>

<?php $this->renderPartial('_form_uploadminutes', array('model'=>$model)); ?>