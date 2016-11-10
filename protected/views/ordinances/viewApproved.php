<?php
/* @var $this OrdinancesController */
/* @var $model Ordinances */

$this->breadcrumbs=array(
	'Ordinances'=>array('index'),
	'View Approved Ordinances',
);

$this->menu=array(
	array('label'=>'List Ordinances', 'url'=>array('index')),
	array('label'=>'Manage Ordinances', 'url'=>array('admin')),
);
?>

<h1>Approved Ordinances</h1>
<?php 
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'ordinances-grid',
		'dataProvider'=>$model->getApproved(),
		'filter'=>$model,
		'columns'=>array(
			'ord_title',
			array(
				'name'=>'ord_authors_id',
				'value'=>'$data->getAuthor($data->ord_id)',
				),
			'ord_ordtype',
			array(
				'class'=>'CLinkColumn',
				'header'=>'In Favor',
				'urlExpression'=>'Yii::app()->createUrl("/ordinances/viewVoters", array("id" => $data->ord_id, "vote" => 1))',
				'labelExpression'=> '$data->getVotes(1)',
			),
			array(
				'class'=>'CLinkColumn',
				'header'=>'Not in Favor',
				'urlExpression'=>'Yii::app()->createUrl("/ordinances/viewVoters", array("id" => $data->ord_id, "vote" => 0))',
				'labelExpression'=> '$data->getVotes(0)',
			),
			array(
				'class'=>'CLinkColumn',
				'header'=>'Abstain/Absent',
				'urlExpression'=>'Yii::app()->createUrl("/ordinances/viewVoters", array("id" => $data->ord_id, "vote" => 2))',
				'labelExpression'=> '$data->getVotes(2)',
			),
			array(
				'class'=>'CButtonColumn',
				'template'=>'{view}',
			),
		),
	)); 
?>