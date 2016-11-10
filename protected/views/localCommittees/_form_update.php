<?php
/* @var $this LocalCommitteesController */
/* @var $model LocalCommittees */
/* @var $form CActiveForm */

$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerCssFile($baseUrl.'/css/lc.css');

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'local-committees-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'lc_name'); ?>
		<?php echo $form->textField($model,'lc_name',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'lc_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lc_chariman_id'); ?>
		<?php 
			$enum = ZHtml::modifiedList($model, $model->sql, 'user_lastname', 'user_id');
			if($enum != null)
				echo $form->dropDownList($model, 'lc_chariman_id', $enum);
			else
				echo 'No LGUs available or all LGUs are taken as a committee chairman.';
		?>
		<?php echo $form->error($model,'lc_chariman_id'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'lc_secretary_id'); ?>
		<?php 
			$enum = ZHtml::modifiedList($model, $model->sql, 'user_lastname', 'user_id');
			if($enum != null)
				echo $form->dropDownList($model, 'lc_secretary_id', $enum);
			else
				echo 'No LGUs available or all LGUs are taken as a committee secretaries.';
		?>
		<?php echo $form->error($model,'lc_secretary_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lc_members'); ?>
		<?php $enum = ZHtml::modifiedList($model, $model->sql, 'user_lastname', 'user_id'); ?>
		<?php 
			//print_r($model->loadMembers($model));
			
			if($enum != null)
				echo $form->checkBoxList($model, 'lc_members', $enum, array('template'=>'{input}{label}', 'labelOptions'=>array('style'=>'display:inline')));
			else
				echo 'No LGUs available or all LGUs are members of other local committees.';
		?>
		<?php echo $form->error($model,'lc_members'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
	(function(root){
		function disable(id){
			document.getElementById(id).checked=false;
			document.getElementById(id).disabled=true;
		}
		
		function undisable(id){
			document.getElementById(id).disabled=false;
		}
		
		var chairman = document.getElementById('LocalCommittees_lc_chariman_id'),
			secretary = document.getElementById('LocalCommittees_lc_secretary_id');
		
		
		function disableSelected(){
			var checkboxes = document.getElementsByName('LocalCommittees[lc_members][]');
			for(i=0; i<checkboxes.length; i++){
				if(checkboxes[i].value == chairman.value ||
					checkboxes[i].value == secretary.value)
					disable(checkboxes[i].id);
			}
		}
		
		function enableAll(){
			var checkboxes = document.getElementsByName('LocalCommittees[lc_members][]');
			for(i=0; i<checkboxes.length; i++){
				undisable(checkboxes[i].id);
			}
		}
		
		enableAll();
		disableSelected();
		chairman.onchange = function(){
			enableAll();
			disableSelected();
		}
		secretary.onchange = function(){
			enableAll();
			disableSelected();
		}
	}(this));
</script>