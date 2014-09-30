<?php
/* @var $this UsersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Users',
);

$curr_user = Users::model()->findByPk(Yii::app()->user->getState('id'));
$isAdmin = $curr_user->isAdministrator();

$this->menu=array(
	array('label'=>'Create User', 'url'=>array('create'), 'visible'=>$isAdmin),
	array('label'=>'Manage Users', 'url'=>array('admin'), 'visible'=>$isAdmin),
	array('label'=>'Assign Presiding Officer', 'url'=>array('presidingOfficer'), 'visible'=>$isAdmin),
	array('label'=>'Assign Chief Executive', 'url'=>array('chiefExecutive'), 'visible'=>$isAdmin),
);
?>

<h1>Users</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
