<?php
/* @var $this OrdinancesController */
/* @var $model Ordinances */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ordinances-ordinances-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_id'); ?>
		<?php echo $form->textField($model,'ord_id'); ?>
		<?php echo $form->error($model,'ord_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_ordtype'); ?>
		<?php echo $form->textField($model,'ord_ordtype'); ?>
		<?php echo $form->error($model,'ord_ordtype'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_ordstatus'); ?>
		<?php echo $form->textField($model,'ord_ordstatus'); ?>
		<?php echo $form->error($model,'ord_ordstatus'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_committee'); ?>
		<?php echo $form->textField($model,'ord_committee'); ?>
		<?php echo $form->error($model,'ord_committee'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_firstreadingapproval'); ?>
		<?php echo $form->textField($model,'ord_firstreadingapproval'); ?>
		<?php echo $form->error($model,'ord_firstreadingapproval'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_secondreadingapproval'); ?>
		<?php echo $form->textField($model,'ord_secondreadingapproval'); ?>
		<?php echo $form->error($model,'ord_secondreadingapproval'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_thirdreadingapproval'); ?>
		<?php echo $form->textField($model,'ord_thirdreadingapproval'); ?>
		<?php echo $form->error($model,'ord_thirdreadingapproval'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->