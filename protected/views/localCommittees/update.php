<?php
/* @var $this LocalCommitteesController */
/* @var $model LocalCommittees */

$this->breadcrumbs=array(
	'Local Committees'=>array('index'),
	$model->lc_id=>array('view','id'=>$model->lc_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LocalCommittees', 'url'=>array('index')),
	array('label'=>'Create LocalCommittees', 'url'=>array('create')),
	array('label'=>'View LocalCommittees', 'url'=>array('view', 'id'=>$model->lc_id)),
	array('label'=>'Manage LocalCommittees', 'url'=>array('admin')),
);
?>

<h1>Update LocalCommittees <?php echo $model->lc_id; ?></h1>

<?php $this->renderPartial('_form_update', array('model'=>$model)); ?>