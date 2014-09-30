<?php
/* @var $this LgusController */
/* @var $model Lgus */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lgus-lgus-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'lgu_id'); ?>
		<?php echo $form->textField($model,'lgu_id'); ?>
		<?php echo $form->error($model,'lgu_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lgu_lgutype'); ?>
		<?php echo $form->textField($model,'lgu_lgutype'); ?>
		<?php echo $form->error($model,'lgu_lgutype'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->