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
					return $data->hasVetoVoted($data->sb_id, $model->ord_voting_id);
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

	<div class="row buttons">
		<?php echo CHtml::submitButton('Generate Results'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->