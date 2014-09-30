<?php
/* @var $this LgusController */
/* @var $model Lgus */

$this->breadcrumbs=array(
	'Lguses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Lgus', 'url'=>array('index')),
	array('label'=>'Manage Lgus', 'url'=>array('admin')),
);
?>

<h1>Create Lgus</h1>

<?php $this->renderPartial('/lgus/_form', array('model'=>$model)); ?>