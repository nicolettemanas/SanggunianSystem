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
	<h3>Set Effectivity Date</h3>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $model->ord_title; ?>
	</div>
	<div class="row">
		<?php echo $form->dateField($model, 'ord_effectivity_date')?>
		<?php echo $form->error($model,'ord_effectivity_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Approve'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->