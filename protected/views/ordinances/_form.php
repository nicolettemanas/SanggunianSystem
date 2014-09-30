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
		<?php echo $form->labelEx($model,'ord_title'); ?>
		<?php echo $form->textField($model,'ord_title',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'ord_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_description'); ?>
		<?php echo $form->textArea($model,'ord_description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'ord_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_authors_id'); ?>
		<?php 
			$enum = ZHtml::modifiedList($model, (Users::model()->getLGUs), 'user_lastname', 'user_id');
			if($enum != null)
				echo $form->dropDownList($model, 'ord_authors_id', $enum);
			else
				echo 'No LGUs available.';
		?>
		<?php echo $form->error($model,'ord_authors_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_file_id'); ?>
		<?php echo $form->fileField($model,'ord_file_id',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'ord_file_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_creation_date'); ?>
		<?php echo $form->dateField($model,'ord_creation_date'); ?>
		<?php echo $form->error($model,'ord_creation_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_effectivity_date'); ?>
		<?php echo $form->dateField($model,'ord_effectivity_date'); ?>
		<?php echo $form->error($model,'ord_effectivity_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_approval_date'); ?>
		<?php echo $form->dateField($model,'ord_approval_date'); ?>
		<?php echo $form->error($model,'ord_approval_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_status'); ?>
		<?php //$enum = ZHtml::enumDropDownList($model, 'ord_status', 'enum_range');
				unset($enum);
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
		?><?php echo $form->error($model,'ord_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_approval_status'); ?>
		<?php 	unset($enum);
				$enum['Approved'] = 'Approved'; 
				$enum['Disproved'] = 'Disproved'; 
				$enum['Proposed'] = 'Proposed';
				echo $form->dropDownList($model, 'ord_approval_status', $enum);
		?>
		<?php echo $form->error($model,'ord_approval_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_committee_id'); ?>
		<?php 
			$enum = ZHtml::modifiedList($model, (Localcommittees::model()->getLocalCommittees), 'lc_name', 'lc_id');
			if($enum != null)
				echo $form->dropDownList($model, 'ord_committee_id', $enum);
			else
				echo 'No committees available.';
		?>
		<?php echo $form->error($model,'ord_committee_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_committee_report_file_id'); ?>
		<?php echo $form->fileField($model,'ord_committee_report_file_id',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'ord_committee_report_file_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_ordtype'); ?>
		<?php 
				unset($enum);
				$enum['General Ordinance'] = 'General Ordinance'; 
				$enum['Appropriation Ordinance'] = 'Appropriation Ordinance'; 
				$enum['Tax Ordinance'] = 'Tax Ordinance'; 
				$enum['Special Ordinance'] = 'Special Ordinance';
				echo $form->dropDownList($model, 'ord_ordtype', $enum);
		?><?php echo $form->error($model,'ord_ordtype'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->