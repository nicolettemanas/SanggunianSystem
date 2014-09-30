<?php
/* @var $this CalendarController */
/* @var $model Calendar */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'calendar-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cal_eventid'); ?>
		<?php echo $form->textField($model,'cal_eventid',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'cal_eventid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cal_eventtitle'); ?>
		<?php echo $form->textArea($model,'cal_eventtitle',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'cal_eventtitle'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cal_ordid'); ?>
		<?php echo $form->textField($model,'cal_ordid',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'cal_ordid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cal_eventcreated'); ?>
		<?php echo $form->textField($model,'cal_eventcreated'); ?>
		<?php echo $form->error($model,'cal_eventcreated'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cal_eventdispdate'); ?>
		<?php echo $form->textField($model,'cal_eventdispdate'); ?>
		<?php echo $form->error($model,'cal_eventdispdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cal_eventtype'); ?>
		<?php echo $form->textField($model,'cal_eventtype',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'cal_eventtype'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cal_eventcontent'); ?>
		<?php echo $form->textArea($model,'cal_eventcontent',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'cal_eventcontent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cal_eventdate'); ?>
		<?php echo $form->textField($model,'cal_eventdate'); ?>
		<?php echo $form->error($model,'cal_eventdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cal_eventauthorid'); ?>
		<?php echo $form->textField($model,'cal_eventauthorid',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'cal_eventauthorid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cal_eventtime_from'); ?>
		<?php echo $form->textField($model,'cal_eventtime_from'); ?>
		<?php echo $form->error($model,'cal_eventtime_from'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cal_eventtime_to'); ?>
		<?php echo $form->textField($model,'cal_eventtime_to'); ?>
		<?php echo $form->error($model,'cal_eventtime_to'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->