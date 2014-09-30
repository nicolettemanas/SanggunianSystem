<?php
/* @var $this VotingsController */
/* @var $model Votings*/

$this->breadcrumbs=array(
	'Voters'=>array('index'),
);

?>

<h1>Members of the Sangguniang Bayan</h1>
<?php 
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'ordinances-grid',
		'dataProvider'=>$model->getSangguniangBayan(),
		'filter'=>$model,
		'columns'=>array(
			array(
				'name'=>'user_lastname',
				'value'=>'$data->getName()',
				),
			array(
				'class'=>'CLinkColumn',
				'header'=>'In Favor',
				'urlExpression'=>'Yii::app()->createUrl("/votings/viewOrdinances", array("id" => $data->user_id, "vote" => 1))',
				'labelExpression'=> '$data->getVotings(1)',
			),
			array(
				'class'=>'CLinkColumn',
				'header'=>'Not in Favor',
				'urlExpression'=>'Yii::app()->createUrl("/votings/viewOrdinances", array("id" => $data->user_id, "vote" => 0))',
				'labelExpression'=> '$data->getVotings(0)',
			),
			array(
				'class'=>'CLinkColumn',
				'header'=>'Abstain/Absent',
				'urlExpression'=>'Yii::app()->createUrl("/votings/viewOrdinances", array("id" => $data->user_id, "vote" => 2))',
				'labelExpression'=> '$data->getVotings(2)',
			),
		),
	)); 
?>