<?php
/* @var $this LgusController */
/* @var $model Lgus */

$this->breadcrumbs=array(
	'Lguses'=>array('index'),
	$model->lgu_id=>array('view','id'=>$model->lgu_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Lgus', 'url'=>array('index')),
	array('label'=>'Create Lgus', 'url'=>array('create')),
	array('label'=>'View Lgus', 'url'=>array('view', 'id'=>$model->lgu_id)),
	array('label'=>'Manage Lgus', 'url'=>array('admin')),
);
?>

<h1>Update Lgus <?php echo $model->lgu_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>