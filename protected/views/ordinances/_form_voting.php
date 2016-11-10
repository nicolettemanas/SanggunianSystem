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

	<div class="row">
		<p>Please consider your vote final. You can vote until <?php echo $voting->vot_deadline; ?></p>
	</div>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<h3><?php echo $model->ord_title; ?></h3>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ord_vote'); ?>
		<?php echo $form->radioButtonList($model, 'ord_vote', array(
			'Not in favor'=>'Not in favor', 
			'In favor'=>'In favor', 
		),
		array('template'=>'{input}{label}', 'labelOptions'=>array('style'=>'display:inline'))
		); ?>
		<?php echo $form->error($model,'ord_vote'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit vote', array('id'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
	document.onsubmit = function(){		
		return confirm("Are you sure you want to submit this vote? Your vote will be considered as final and fixed.");
	}
</script>