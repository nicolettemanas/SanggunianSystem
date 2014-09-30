<?php
/* @var $this PublicationsController */
/* @var $model Publications */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'publications-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'pub_title'); ?>
		<?php echo $form->textField($model,'pub_title',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'pub_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pub_fileid'); ?>
		<?php echo $form->textField($model,'pub_fileid',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'pub_fileid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pub_datecreated'); ?>
		<?php echo $form->dateField($model,'pub_datecreated'); ?>
		<?php echo $form->error($model,'pub_datecreated'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pub_dispositiondate'); ?>
		<?php echo $form->dateField($model,'pub_dispositiondate'); ?>
		<?php echo $form->error($model,'pub_dispositiondate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pub_pubtype'); ?>
		<?php //echo $form->textField($model,'pub_pubtype'); ?>
		<?php $enum = ZHtml::enumDropDownList($model, 'pub_pubtype');
				echo $form->dropDownList($model, 'pub_pubtype', $enum);
		?>
		<?php echo $form->error($model,'pub_pubtype'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->