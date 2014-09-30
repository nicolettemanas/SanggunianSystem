<?php
/* @var $this OrdinancesController */
/* @var $model Ordinances */

$this->breadcrumbs=array(
	'Ordinances'=>array('index'),
	'Third Reading',
);

$this->menu=array(
	array('label'=>'List Ordinances', 'url'=>array('index')),
	array('label'=>'Manage Ordinances', 'url'=>array('admin')),
);
?>

<h1>Third Reading</h1>
<p>The following list of ordinances have been through the first two readings and are ready for voting.</p>
<?php 
	$buttons = '{view}{schedule}';

	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'ordinances-grid',
		'dataProvider'=>$model->getOrdinancesForStatus("3rd Reading"),
		'filter'=>$model,
		'columns'=>array(
			'ord_title',
			array(
				'name'=>'ord_authors_id',
				'value'=>'$data->getAuthor($data->ord_id)',
				),
			'ord_creation_date',
			'ord_status',
			'ord_approval_status',
			'ord_ordtype',
			array(
				'class'=>'CButtonColumn',
				'template'=>$buttons,
				'buttons'=>array(
					'schedule' => array(
						'label'=>'Schedule a voting',     // text label of the button
						'url'=>'Yii::app()->createUrl("/ordinances/thirdReading", array("id" => $data->ord_id))',       // the PHP expression for generating the URL of the button
						'imageUrl'=>Yii::app()->baseUrl.'/images/list.png',  // image URL of the button. If not set or false, a text link is used
                    ),
				),
			),
		),
	)); 
?>