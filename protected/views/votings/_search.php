<?php
/* @var $this VotingsController */
/* @var $model Votings */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'vot_id'); ?>
		<?php echo $form->textField($model,'vot_id',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vot_title'); ?>
		<?php echo $form->textField($model,'vot_title',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vot_description'); ?>
		<?php echo $form->textArea($model,'vot_description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vot_votstatus'); ?>
		<?php echo $form->textField($model,'vot_votstatus'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vot_start'); ?>
		<?php echo $form->textField($model,'vot_start'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vot_deadline'); ?>
		<?php echo $form->textField($model,'vot_deadline'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vot_ord_id'); ?>
		<?php echo $form->textField($model,'vot_ord_id',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->