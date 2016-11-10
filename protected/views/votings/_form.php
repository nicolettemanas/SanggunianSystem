<?php
/* @var $this VotingsController */
/* @var $model Votings */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'votings-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'vot_id'); ?>
		<?php echo $form->textField($model,'vot_id',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'vot_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vot_title'); ?>
		<?php echo $form->textField($model,'vot_title',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'vot_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vot_description'); ?>
		<?php echo $form->textArea($model,'vot_description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'vot_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vot_votstatus'); ?>
		<?php echo $form->textField($model,'vot_votstatus'); ?>
		<?php echo $form->error($model,'vot_votstatus'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vot_start'); ?>
		<?php echo $form->textField($model,'vot_start'); ?>
		<?php echo $form->error($model,'vot_start'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vot_deadline'); ?>
		<?php echo $form->textField($model,'vot_deadline'); ?>
		<?php echo $form->error($model,'vot_deadline'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vot_ord_id'); ?>
		<?php echo $form->textField($model,'vot_ord_id',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'vot_ord_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->