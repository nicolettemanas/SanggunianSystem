<?php
/* @var $this LgusController */
/* @var $model Lgus */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lgus-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); 
?>
<?php //var_dump($user); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'lgu_lgutype'); ?>
		<?php //echo $form->textField($model,'lgu_lgutype'); 
			$enum = ZHtml::enumDropDownList($model, 'lgu_lgutype');
			echo $form->dropDownList($model, 'lgu_lgutype', $enum);
		?>
		<?php echo $form->error($model,'lgu_lgutype'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		<?php echo CHtml::submitButton('Cancel'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->