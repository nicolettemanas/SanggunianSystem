<?php
/* @var $this OrdinancesController */
/* @var $model Ordinances */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ord_title'); ?>
		<?php echo $form->textField($model,'ord_title',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ord_description'); ?>
		<?php echo $form->textArea($model,'ord_description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ord_auth_last'); ?>
		<?php echo $form->textField($model,'ord_auth_last',array('size'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ord_auth_first'); ?>
		<?php echo $form->textField($model,'ord_auth_first',array('size'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ord_auth_middle'); ?>
		<?php echo $form->textField($model,'ord_auth_middle',array('size'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ord_creation_date'); ?>
		<?php echo $form->dateField($model,'ord_creation_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ord_approval_date'); ?>
		<?php echo $form->dateField($model,'ord_approval_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ord_status'); ?>
		<?php 
				unset($enum);
				$enum[''] = ''; 
				$enum['Proposed to Sangguniang Bayan'] = 'Proposed to Sangguniang Bayan'; 
				$enum['1st Reading'] = '1st Reading'; 
				$enum['2nd Reading'] = '2nd Reading'; 
				$enum['3rd Reading'] = '3rd Reading'; 
				$enum['Vetoed by Executive Officer'] = 'Vetoed by Executive Officer'; 
				$enum['Voting (Final voting)'] = 'Voting (Final voting)'; 
				$enum['Approved; Not yet published'] = 'Approved; Not yet published'; 
				$enum['Approved and Published'] = 'Approved and Published'; 
				$enum['Disproved'] = 'Disproved'; 
				$enum['Scheduled for hearing'] = 'Scheduled for hearing'; 
				$enum['Waiting for Committee Amendments'] = 'Waiting for Committee Amendments'; 
				$enum['Voting (Veto)'] = 'Voting (Veto)'; 
				$enum['Forwarded to Chief Executive'] = 'Forwarded to Chief Executive'; 
				
				echo $form->dropDownList($model, 'ord_status', $enum);
				
		//echo $form->textField($model,'ord_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ord_approval_status'); ?>
		<?php 
				unset($enum);
				$enum[''] = ''; 
				$enum['Approved'] = 'Approved'; 
				$enum['Disproved'] = 'Disproved'; 
				$enum['Proposed'] = 'Proposed';
				echo $form->dropDownList($model, 'ord_approval_status', $enum);
		//echo $form->textField($model,'ord_approval_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ord_ordtype'); ?>
		<?php 
				unset($enum);
				$enum[''] = ''; 
				$enum['General Ordinance'] = 'General Ordinance'; 
				$enum['Appropriation Ordinance'] = 'Appropriation Ordinance'; 
				$enum['Tax Ordinance'] = 'Tax Ordinance'; 
				$enum['Special Ordinance'] = 'Special Ordinance';
				echo $form->dropDownList($model, 'ord_ordtype', $enum);
		//echo $form->textField($model,'ord_ordtype'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->