<?php
/* @var $this VotingsController */
/* @var $model Votings */

$this->breadcrumbs=array(
	'Votings'=>array('index'),
	$model->vot_id=>array('view','id'=>$model->vot_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Votings', 'url'=>array('index')),
	array('label'=>'Create Votings', 'url'=>array('create')),
	array('label'=>'View Votings', 'url'=>array('view', 'id'=>$model->vot_id)),
	array('label'=>'Manage Votings', 'url'=>array('admin')),
);
?>

<h1>Update Votings <?php echo $model->vot_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>