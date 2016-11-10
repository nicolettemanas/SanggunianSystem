<?php
/* @var $this OrdinancesController */
/* @var $model Ordinances */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ordinances-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $model->ord_title; ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_committee_report_file_id'); ?>
		<?php echo $form->fileField($model,'ord_committee_report_file_id',array('size'=>60,'maxlength'=>64, 'id'=>'file_report_id')); ?>
		<?php echo $form->error($model,'ord_committee_report_file_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Upload'); ?>
		<?php echo CHtml::submitButton('Approve without report'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->