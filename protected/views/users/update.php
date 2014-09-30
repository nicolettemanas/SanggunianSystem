<?php
/* @var $this UsersController */
/* @var $user Users */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$user->user_id=>array('view','id'=>$user->user_id),
	'Update',
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

<h1>Update Users <?php echo $user->user_id; ?></h1>

<?php $this->renderPartial('_form_update', array('user'=>$user)); ?>