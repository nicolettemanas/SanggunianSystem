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
		<?php echo $form->labelEx($model,'ord_committee_id'); ?>
		<?php $enum = ZHtml::modifiedList($model, $model->sql_getCommittees, 'lc_name', 'lc_id');
				echo $form->dropDownList($model, 'ord_committee_id', $enum);
		?>
		<?php echo $form->error($model,'ord_committee_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Assign'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->