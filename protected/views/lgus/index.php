<?php
/* @var $this LgusController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'LGUs',
);

$this->menu=array(
	array('label'=>'Create Lgus', 'url'=>array('create')),
	array('label'=>'Manage Lgus', 'url'=>array('admin')),
);
?>

<h1>LGUs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
