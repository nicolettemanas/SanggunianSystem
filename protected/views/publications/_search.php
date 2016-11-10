<?php
/* @var $this PublicationsController */
/* @var $model Publications */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'pub_title'); ?>
		<?php echo $form->textField($model,'pub_title',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pub_datecreated'); ?>
		<?php echo $form->textField($model,'pub_datecreated'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pub_dispositiondate'); ?>
		<?php echo $form->textField($model,'pub_dispositiondate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pub_pubtype'); ?>
		<?php echo $form->textField($model,'pub_pubtype'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->