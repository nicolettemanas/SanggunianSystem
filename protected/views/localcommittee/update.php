<?php
/* @var $this LocalcommitteeController */
/* @var $model Localcommittee */

$this->breadcrumbs=array(
	'Localcommittees'=>array('index'),
	$model->lc_id=>array('view','id'=>$model->lc_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Localcommittee', 'url'=>array('index')),
	array('label'=>'Create Localcommittee', 'url'=>array('create')),
	array('label'=>'View Localcommittee', 'url'=>array('view', 'id'=>$model->lc_id)),
	array('label'=>'Manage Localcommittee', 'url'=>array('admin')),
);
?>

<h1>Update Localcommittee <?php echo $model->lc_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>