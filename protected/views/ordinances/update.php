<?php
/* @var $this OrdinancesController */
/* @var $model Ordinances */

$this->breadcrumbs=array(
	'Ordinances'=>array('index'),
	$model->ord_id=>array('view','id'=>$model->ord_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Ordinances', 'url'=>array('index')),
	array('label'=>'Create Ordinances', 'url'=>array('create')),
	array('label'=>'View Ordinances', 'url'=>array('view', 'id'=>$model->ord_id)),
	array('label'=>'Manage Ordinances', 'url'=>array('admin')),
);
?>

<h1>Update Ordinances <?php echo $model->ord_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>