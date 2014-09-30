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

	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'ordinances-grid',
		'dataProvider'=>$model->getTiedVotings(),
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
				'template'=>'{vote}',
				'buttons'=>array(
					'vote' => array(
						'label'=>'Break tie',     // text label of the button
						'url'=>'Yii::app()->createUrl("/ordinances/breakTie", array("id" => $data->ord_id))',       // the PHP expression for generating the URL of the button
						'imageUrl'=>Yii::app()->baseUrl.'/images/tally.png',  // image URL of the button. If not set or false, a text link is used
                    ),
				),
			),
		),
	)); 
?>