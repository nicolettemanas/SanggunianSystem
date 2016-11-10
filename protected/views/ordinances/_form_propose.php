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
		<?php echo $form->labelEx($model,'ord_title'); ?>
		<?php echo $form->textField($model,'ord_title',array('size'=>60,'maxlength'=>265)); ?>
		<?php echo $form->error($model,'ord_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_description'); ?>
		<?php echo $form->textArea($model,'ord_description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'ord_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_file_id'); ?>
		<?php echo $form->fileField($model,'ord_file_id',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'ord_file_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_ordtype'); ?>
		<?php 	unset($enum);
				$enum['General Ordinance'] = 'General Ordinance'; 
				$enum['Appropriation Ordinance'] = 'Appropriation Ordinance'; 
				$enum['Tax Ordinance'] = 'Tax Ordinance'; 
				$enum['Special Ordinance'] = 'Special Ordinance';
				
				echo $form->dropDownList($model, 'ord_ordtype', $enum);
		?>
		<?php echo $form->error($model,'ord_ordtype'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Propose' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->