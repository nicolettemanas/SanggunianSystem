<?php
/* @var $this SangguniangbayanController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sangguniangbayans',
);

$this->menu=array(
	array('label'=>'Add Sangguniang Bayan', 'url'=>array('create')),
	array('label'=>'Manage Sangguniang Bayan', 'url'=>array('admin')),
);
?>

<h1>Members of the Sangguniang Bayan</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
