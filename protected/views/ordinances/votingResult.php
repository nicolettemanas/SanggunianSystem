<?php
/* @var $this OrdinancesController */
/* @var $model Ordinances */

$this->breadcrumbs=array(
	'Ordinances'=>array('index'),
	'Votings',
);

$this->menu=array(
	array('label'=>'List Ordinances', 'url'=>array('index')),
	array('label'=>'Manage Ordinances', 'url'=>array('admin')),
	array('label'=>'Ordinances for First Reading', 'url'=>array('viewFirstReading')),
);
?>

<h1>Voting Results</h1>

<p>Voting details:</p>

<div class="row">
	<h3><?php echo $model->ord_title; ?></h3>
</div>

<div class="row">
	<p><?php echo $model->ord_description; ?></p>
</div>

<p>Members can vote up to <?php $date = new DateTime($voting->vot_deadline); echo $date->format('M d, Y');  ?></p>
<?php 
	//$buttons = '{view}{schedule}{results}';
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'ordinances-grid',
		'dataProvider'=>$sb->search(),
		'filter'=>$sb,
		'columns'=>array(
			array(
				'name'=>'sb_id',
				'value'=>'$data->getUser($data->sb_id)'
			),
			'sb_lguposition',
			array(
				'class'=>'CDataColumn',
				'name'=>'hasVoted',
				'value'=>function($data,$row) use ($model){
					return $data->hasVoted($data->sb_id, $model->ord_voting_id);
				}
			)
		),
	)); 
?>

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

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<?php echo $form->dropDownList($model, 'ord_second_reading_action', 
			array(
				'Generate Results'=>'Generate results',
				'Extend deadline'=>'Extend deadline',
			), 
			array('id'=>'action')); ?>
		<?php echo $form->error($model,'ord_second_reading_action '); ?>
	</div>
	
	<div class="row" id="deadline">
		<h6>New deadline</h6>
		<?php echo $form->dateField($model, 'ord_reading_date_to', array('id'=>'date')); ?>
		<?php echo $form->error($model,'ord_reading_date_to '); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit', array('id'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
	function show(id){ 
		document.getElementById(id).style.display='block'; 
		return false;
	} 
	function hide(id){ 
		document.getElementById(id).style.display='none'; 
		return false;
	}
	hide('deadline');
	document.getElementById('action').onchange = function(){
		if($('#action').val() == "Generate results")
			hide('deadline')
		else if($('#action').val() == "Extend deadline")
			show('deadline')
	}
	document.onsubmit = function(){		
		if($('#action').val() == "Generate results")
			return confirm("Are you sure you want to generate the results? Those who did not vote will be considered as absent for this session.");
	}
</script>