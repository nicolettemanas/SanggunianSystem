<?php
/* @var $this LogsController */
/* @var $model Logs */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'logs-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'log_id'); ?>
		<?php echo $form->textField($model,'log_id',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'log_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'log_userid'); ?>
		<?php echo $form->textField($model,'log_userid',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'log_userid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'log_username'); ?>
		<?php echo $form->textField($model,'log_username',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'log_username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'log_activity'); ?>
		<?php echo $form->textArea($model,'log_activity',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'log_activity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'log_date'); ?>
		<?php echo $form->textField($model,'log_date'); ?>
		<?php echo $form->error($model,'log_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->