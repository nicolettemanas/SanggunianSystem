<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-Users-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_username'); ?>
		<?php echo $form->textField($model,'user_username'); ?>
		<?php echo $form->error($model,'user_username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_password'); ?>
		<?php echo $form->textField($model,'user_password'); ?>
		<?php echo $form->error($model,'user_password'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'password_repeat'); ?>
		<?php echo $form->textField($model,'password_repeat'); ?>
		<?php echo $form->error($model,'password_repeat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_email'); ?>
		<?php echo $form->textField($model,'user_email'); ?>
		<?php echo $form->error($model,'user_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_lastname'); ?>
		<?php echo $form->textField($model,'user_lastname'); ?>
		<?php echo $form->error($model,'user_lastname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_firstname'); ?>
		<?php echo $form->textField($model,'user_firstname'); ?>
		<?php echo $form->error($model,'user_firstname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_middlename'); ?>
		<?php echo $form->textField($model,'user_middlename'); ?>
		<?php echo $form->error($model,'user_middlename'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_usertype'); ?>
		<?php //echo ZHtml::enumDropDownList($model, 'user_type');?>
		<?php //echo $form->textField($model,'user_usertype'); ?>
		<?php echo $form->error($model,'user_usertype'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->