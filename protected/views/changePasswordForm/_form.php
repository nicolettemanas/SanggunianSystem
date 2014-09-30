<?php
/* @var $this ChangePasswordFormController */
/* @var $model ChangePasswordForm */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'change-password-form-ChangePasswordForm-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'currPassword'); ?>
		<?php echo $form->textField($model,'currPassword'); ?>
		<?php echo $form->error($model,'currPassword'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'newPassword'); ?>
		<?php echo $form->textField($model,'newPassword'); ?>
		<?php echo $form->error($model,'newPassword'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'repeatNewPassword'); ?>
		<?php echo $form->textField($model,'repeatNewPassword'); ?>
		<?php echo $form->error($model,'repeatNewPassword'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Save'); ?>
		<?php echo CHtml::submitButton('Cancel'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->