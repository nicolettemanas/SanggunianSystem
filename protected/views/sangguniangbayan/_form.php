<?php
/* @var $this SangguniangbayanController */
/* @var $model Sangguniangbayan */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sangguniangbayan-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'sb_id'); ?>
		<?php 
			if($this->action->id == 'update')
				$sql = $model->sql_update;
			else $sql = $model->sql;
			
			$enum = ZHtml::modifiedList($model, $sql, 'user_lastname', 'user_id');
			if($enum != null){
				echo $form->dropDownList($model, 'sb_id', $enum);
			}
			else
				echo 'No LGUs available or all LGUs are already part of a local committee.';
		?>
		<?php echo $form->error($model,'sb_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sb_lguposition'); ?>
		<?php $enum = ZHtml::enumDropDownList($model, 'sb_lguposition', 'enum_range');
				unset($enum['Chairman']);
				echo $form->dropDownList($model, 'sb_lguposition', $enum);
		?>
		<?php echo $form->error($model,'sb_lguposition'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->