<?php
/* @var $this OrdinancesController */
/* @var $model Ordinances */

$this->breadcrumbs=array(
	'Ordinances'=>array('index'),
	'Current Votings',
);

$this->menu=array(
	array('label'=>'List Ordinances', 'url'=>array('index')),
	array('label'=>'Manage Ordinances', 'url'=>array('admin')),
);
?>

<h1>Third Reading</h1>
<p>The following list of ordinances have been through the first two readings and are ready for voting.</p>
<?php

	if($user->isSbMember($user->user_id))
		$buttons = '{view}{vote}';
	else if($user->isPresidingOfficer($user->user_id))
		$buttons = '{view}{results}';

	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'ordinances-grid',
		'dataProvider'=>$model->getVotings(),
		'filter'=>$model,
		'columns'=>array(
			'ord_title',
			array(
				'name'=>'ord_authors_id',
				'value'=>'$data->getAuthor($data->ord_id)',
				),
			'ord_creation_date',
			'ord_status',
			'ord_ordtype',
			array(
				'name'=>'ord_reading_date_from',
				'value'=>'$data->getVotingStart()',
			),
			array(
				'name'=>'ord_reading_date_to',
				'value'=>'$data->getVotingDeadline()',
			),
			array(
				'class'=>'CButtonColumn',
				'template'=>$buttons,
				'buttons'=>array(
					'vote' => array(
						'label'=>'Vote',     // text label of the button
						'url'=>function ($data){
							if($data->ord_status == 'Voting (Veto)')
								return Yii::app()->createUrl("/ordinances/vetoVotings", array("id" => $data->ord_id));
							return Yii::app()->createUrl("/ordinances/votings", array("id" => $data->ord_id));
						},
						'imageUrl'=>Yii::app()->baseUrl.'/images/list.png',  // image URL of the button. If not set or false, a text link is used
                    ),
					'results' => array(
						'label'=>'Results',     // text label of the button
						'url'=>function($data){
							if($data->ord_status == 'Voting (Veto)')
								return Yii::app()->createUrl("/ordinances/votingVetoResult", array("id" => $data->ord_id));
							return Yii::app()->createUrl("/ordinances/votingResult", array("id" => $data->ord_id));
						},
						'imageUrl'=>Yii::app()->baseUrl.'/images/tally.png',  // image URL of the button. If not set or false, a text link is used
                    ),
				),
			),
		),
	));
?>