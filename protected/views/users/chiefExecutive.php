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
<h1>Assign as Chief Executive</h1>

<?php
/* @var $this UsersController */
/* @var $user Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary(array($user)); ?>

	<div class="row">
		<?php echo $form->labelEx($user,'user_id'); ?>
		<?php $enum = ZHtml::modifiedList($user, $user->getLGUs, 'user_lastname', 'user_id');
				echo $form->dropDownList($user, 'user_id', $enum);
		?>
		<?php echo $form->error($user,'user_id'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Assign'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
