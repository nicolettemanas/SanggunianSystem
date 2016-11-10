<?php
/* @var $this SangguniangbayanController */
/* @var $model Sangguniangbayan */

$this->breadcrumbs=array(
	'Sangguniangbayans'=>array('index'),
	$model->sb_id=>array('view','id'=>$model->sb_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Sangguniangbayan', 'url'=>array('index')),
	array('label'=>'Create Sangguniangbayan', 'url'=>array('create')),
	array('label'=>'View Sangguniangbayan', 'url'=>array('view', 'id'=>$model->sb_id)),
	array('label'=>'Manage Sangguniangbayan', 'url'=>array('admin')),
);
?>

<h1>Update Sangguniangbayan <?php echo $model->sb_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>