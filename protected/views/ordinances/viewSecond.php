<?php
/* @var $this OrdinancesController */
/* @var $model Ordinances */

$this->breadcrumbs=array(
	'Ordinances'=>array('index'),
	'Second Reading',
);

$this->menu=array(
	array('label'=>'List Ordinances', 'url'=>array('index')),
	array('label'=>'Manage Ordinances', 'url'=>array('admin')),
);
?>

<h1>Second Reading</h1>
<p>The following Ordinances are already evaluated by their respective committees and are ready for the Second Reading.</p>
<?php 
	$buttons = '{view}{assign}';

	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'ordinances-grid',
		'dataProvider'=>$model->getOrdinancesForStatus("2nd Reading"),
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
					'assign' => array(
						'label'=>'Assign for first reading',     // text label of the button
						'url'=>'Yii::app()->createUrl("/ordinances/secondreading", array("id" => $data->ord_id))',       // the PHP expression for generating the URL of the button
						'imageUrl'=>Yii::app()->baseUrl.'/images/list.png',  // image URL of the button. If not set or false, a text link is used
                    ),
				),
			),
		),
	)); 
?>