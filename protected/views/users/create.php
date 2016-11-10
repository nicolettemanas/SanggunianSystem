<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);

$curr_user = Users::model()->findByPk(Yii::app()->user->getState('id'));
$isAdmin = $curr_user->isAdministrator();

$this->menu=array(
	array('label'=>'List Users', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create'), 'visible'=>$isAdmin),
	array('label'=>'Manage Users', 'url'=>array('admin'), 'visible'=>$isAdmin),
	array('label'=>'Assign Presiding Officer', 'url'=>array('presidingOfficer'), 'visible'=>$isAdmin),
	array('label'=>'Assign Chief Executive', 'url'=>array('chiefExecutive'), 'visible'=>$isAdmin),);
?>
<h1>Create Users</h1>

<?php $this->renderPartial('_form', array('user'=>$user)); ?>