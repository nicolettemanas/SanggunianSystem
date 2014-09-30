<?php
/* @var $this CalendarController */
/* @var $model Calendar */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'cal_eventid'); ?>
		<?php echo $form->textField($model,'cal_eventid',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cal_eventtitle'); ?>
		<?php echo $form->textArea($model,'cal_eventtitle',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cal_ordid'); ?>
		<?php echo $form->textField($model,'cal_ordid',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cal_eventcreated'); ?>
		<?php echo $form->textField($model,'cal_eventcreated'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cal_eventdispdate'); ?>
		<?php echo $form->textField($model,'cal_eventdispdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cal_eventtype'); ?>
		<?php echo $form->textField($model,'cal_eventtype',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cal_eventcontent'); ?>
		<?php echo $form->textArea($model,'cal_eventcontent',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cal_eventdate'); ?>
		<?php echo $form->textField($model,'cal_eventdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cal_eventauthorid'); ?>
		<?php echo $form->textField($model,'cal_eventauthorid',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cal_eventtime_from'); ?>
		<?php echo $form->textField($model,'cal_eventtime_from'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cal_eventtime_to'); ?>
		<?php echo $form->textField($model,'cal_eventtime_to'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->