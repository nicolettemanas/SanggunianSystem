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

	
	<div class="row" id="passwordChange">
		
		<div class="row">
			<?php echo $form->hiddenField($user, 'password_change', array('id'=>'password_change_id')); ?>
			<?php 			
				$curruser = Users::model()->findByPk(Yii::app()->user->getState('id'));
				if(!$curruser->isAdministrator()){?>
				<?php echo $form->labelEx($user,'curr_password'); ?>
				<?php echo $form->passwordField($user,'curr_password',array('size'=>60,'maxlength'=>64)); ?>
				<?php echo $form->error($user,'curr_password'); 
			}?>
		</div>
		<div class="row">
			<?php echo $form->label($user,'new_password'); ?>
			<?php echo $form->passwordField($user,'new_password',array('size'=>60,'maxlength'=>64)); ?>
			<?php echo $form->error($user,'new_password'); ?>
		</div>
		<div class="row">
			<?php echo $form->label($user,'user_password_repeat'); ?>
			<?php echo $form->passwordField($user,'user_password_repeat',array('size'=>60,'maxlength'=>64)); ?>
			<?php echo $form->error($user,'user_password_repeat'); ?>
		</div>
	</div>

	<?php echo CHtml::button('Change password', array('id'=>'passwordChangeId')); ?>
	<?php echo CHtml::button('Cancel', array('id'=>'cancelPasswordChange')); ?>

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
				echo $form->dropDownList($user, 'user_usertype', $enum);
		?>
		<?php echo $form->error($user,'user_usertype'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($user->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
	(function(root){
		 function show(id){ 
				document.getElementById(id).style.display='block'; 
			return false;
		} 
		function hide(id){ 
				document.getElementById(id).style.display='none'; 
			return false;
		}
		
		hide('passwordChange');
		hide('cancelPasswordChange');
		
		document.getElementById('passwordChangeId').onclick = function(){
			show('passwordChange');
			hide('passwordChangeId');
			show('cancelPasswordChange');
			document.getElementById('password_change_id').value = true;
			console.log(document.getElementById('password_change_id').value);
		}
		document.getElementById('cancelPasswordChange').onclick = function(){
			hide('passwordChange');
			show('passwordChangeId');
			hide('cancelPasswordChange');
			document.getElementById('password_change_id').value = false;
			 console.log(document.getElementById('password_change_id').value);
		}
	}(this));
</script>