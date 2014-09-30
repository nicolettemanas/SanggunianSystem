<?php
/* @var $this LocalcommitteeController */
/* @var $model Localcommittee */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'localcommittee-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'lc_id'); ?>
		<?php echo $form->textField($model,'lc_id',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'lc_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lc_lguposition'); ?>
		<?php echo $form->textField($model,'lc_lguposition'); ?>
		<?php echo $form->error($model,'lc_lguposition'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lc_committeename'); ?>
		<?php echo $form->textField($model,'lc_committeename',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'lc_committeename'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->