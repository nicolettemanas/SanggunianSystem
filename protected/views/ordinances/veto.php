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
	<h3>Veto voting schedule</h3>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $model->ord_title; ?>
	</div>

	<?php echo "Schedule voting (veto):" ?><br/>
	<div class="row">
		<p>FROM</p>
		<?php echo $form->dateField($model, 'ord_reading_date_from')?>
		<?php echo $form->error($model,'ord_new_file_id'); ?>
		<p>TO</p>
		<?php echo $form->dateField($model, 'ord_reading_date_to')?>
		<?php echo $form->error($model,'ord_reading_date_to'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Schedule'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->