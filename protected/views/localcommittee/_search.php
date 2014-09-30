<?php
/* @var $this LocalcommitteeController */
/* @var $model Localcommittee */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'lc_id'); ?>
		<?php echo $form->textField($model,'lc_id',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lc_lguposition'); ?>
		<?php echo $form->textField($model,'lc_lguposition'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lc_committeename'); ?>
		<?php echo $form->textField($model,'lc_committeename',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->