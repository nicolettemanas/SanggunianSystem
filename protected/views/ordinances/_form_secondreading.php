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
		<h2><?php echo $model->ord_title; ?></h2>
	</div>

	<div class="row">
		<p><?php echo $model->ord_description; ?></p>
	</div>
	<div class="row">
		<h3>2nd reading action</h3>
		<?php echo $form->dropDownList($model, 'ord_second_reading_action', 
			array(
				'Disprove'=>'Disprove',
				'Schedule a public hearing'=>'Schedule a public hearing',
				'Upload revision'=>'Upload revision',
			), 
			array('id'=>'action')); ?>
		<?php echo $form->error($model,'ord_second_reading_action '); ?>
	</div>

	<div class="row" id="hearing_date" class="toggable">
		<h6>Hearing date</h6>
		<?php echo $form->dateField($model, 'ord_date', array('id'=>'date')); ?>
		<?php echo $form->error($model,'ord_date '); ?>
	</div>
	
	<div class="row" id="hearing_venue" class="toggable">
		<h6>Hearing venue</h6>
		<?php echo $form->textField($model, 'ord_hearing_venue', array('id'=>'venue')); ?>
		<?php echo $form->error($model,'ord_hearing_venue'); ?>
	</div>
	<div class="row" id="hearing_time" class="toggable">
		<h6>Hearing time</h6>
		<p>from </p>
		<?php echo $form->timeField($model, 'ord_hearing_time_from', array('id'=>'time')); ?>
		<?php echo $form->error($model,'ord_hearing_time_from'); ?>
		<p>to </p>
		<?php echo $form->timeField($model, 'ord_hearing_time_to', array('id'=>'time')); ?>
		<?php echo $form->error($model,'ord_hearing_time_to'); ?>
	</div>
	
	<div class="row" id="upload" class="toggable">
		<h6>Upload revised</h6>
		<?php echo $form->fileField($model, 'ord_new_file_id', array('id'=>'new_file_id')); ?>
		<?php echo $form->error($model,'ord_new_file_id'); ?>
	</div>
	
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Subject action'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	function show(id){ 
		//if(document.getElementById(id).style.display=='none') { 
			document.getElementById(id).style.display='block'; 
		//} 
		return false;
	} 
	function hide(id){ 
		//if(document.getElementById(id).style.display=='block') { 
			document.getElementById(id).style.display='none'; 
		//} 
		return false;
	}
	hide('hearing_date');
	hide('upload');
	hide('hearing_venue');
	hide('hearing_time');
	document.getElementById('action').onchange = function ()
	{
		switch(this.value){
			case 'Schedule a public hearing':
				show('hearing_date');
				show('hearing_venue');
				show('hearing_time');
				hide('upload');
			break;
			case 'Upload revision':
				show('upload');
				hide('hearing_date');
				hide('hearing_time');
				hide('hearing_venue');
			break;
			case 'Disprove':
				hide('upload');
				hide('hearing_time');
				hide('hearing_date');
				hide('hearing_venue');
			break;
		}
	}
	document.onsubmit = function(){		
		switch(document.getElementById('action').value){
			case 'Schedule a public hearing':
				return confirm("The ordinance will be publicly published and an announcement regarding a public hearing will be posted. Amendments will then be considered. Proceed with the process?");
			break;
			case 'Upload revision':
				show('upload');
				hide('hearing_date');
			break;
			case 'Disprove':
				return confirm("Are you sure you want to disprove this ordinance?");
			break;
		}
	}
</script>