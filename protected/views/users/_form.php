<?php
/* @var $this UsersController */
/* @var $user Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary(array($user)); ?>

	<div class="row">
		<?php echo $form->labelEx($user,'user_username'); ?>
		<?php echo $form->textField($user,'user_username',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($user,'user_username'); ?>
	</div>
	<?php 
		if($this->action->id != 'update'){ ?>
			<div class="row">
				<?php echo $form->labelEx($user,'user_password'); ?>
				<?php echo $form->passwordField($user,'user_password',array('size'=>60,'maxlength'=>64)); ?>
				<?php echo $form->error($user,'user_password'); ?>
			</div>
			<div class="row">
				<?php echo $form->label($user,'user_password_repeat'); ?>
				<?php echo $form->passwordField($user,'user_password_repeat',array('size'=>60,'maxlength'=>64)); ?>
				<?php echo $form->error($user,'user_password_repeat'); ?>
			</div>
		<?php }else{ echo CHtml::submitButton('Change password', array('name'=>'passwordChange')); } ?>

	<div class="row">
		<?php echo $form->labelEx($user,'user_email'); ?>
		<?php echo $form->textField($user,'user_email',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($user,'user_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($user,'user_lastname'); ?>
		<?php echo $form->textField($user,'user_lastname',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($user,'user_lastname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($user,'user_firstname'); ?>
		<?php echo $form->textField($user,'user_firstname',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($user,'user_firstname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($user,'user_middlename'); ?>
		<?php echo $form->textField($user,'user_middlename',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($user,'user_middlename'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($user,'user_usertype'); ?>
		<?php $enum = ZHtml::enumDropDownList($user, 'user_usertype', 'enum_range');
				if(Yii::app()->user->isGuest){
					unset($enum['Administrator']);
					unset($enum['LGU']);
				}
				echo $form->dropDownList($user, 'user_usertype', $enum);
		?>
		<?php echo $form->error($user,'user_usertype'); ?>
	</div>
	
	
	
	<div class="row" id="admin" name="toggable">
		admin options
	</div>
	
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($user->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
	(function(root){
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
		var divs = document.getElementsByName("toggable"),
			lgu_divs = document.getElementsByName("lgu_toggable"),
			type = document.getElementById("Users_user_usertype"),
			lgu_pos = document.getElementById("Lgus_lgu_lgutype");
		
		//hide all additional divs
		var hideAll = function(e){
			for(var i=0; i<e.length; i++)
				hide(e[i].id);	
		}
		
		hideAll(divs);
		type.onchange = function(){
			hideAll(divs);
			hideAll(lgu_divs);
			if(type.value=="LGU"){
				show("lgu");
				show("lgu_pos_sb");
				lgu_pos.onchange();
			}
			else if(type.value=="Administrator")
				show("admin");
		};

		lgu_pos.onchange = function(){
			hideAll(lgu_divs);
			if(lgu_pos.value == "Sangguniang Bayan")
				show("lgu_pos_sb");
			else if(lgu_pos.value == "Local Committee")
				show("lgu_pos_lc");
		}
		
		type.onchange();
	}(this));
</script>