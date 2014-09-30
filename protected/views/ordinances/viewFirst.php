<?php
/* @var $this OrdinancesController */
/* @var $model Ordinances */

$this->breadcrumbs=array(
	'Ordinances'=>array('index'),
	'First Reading',
);

$this->menu=array(
	array('label'=>'List Ordinances', 'url'=>array('index')),
	array('label'=>'Manage Ordinances', 'url'=>array('admin')),
);
?>

<h1>First Reading</h1>
<p>The following Ordinances are proposed to the Sangguniang Bayan an are ready for First Reading.</p>
<?php 
	$buttons = '{view}{assign}';

	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'ordinances-grid',
		'dataProvider'=>$model->getOrdinancesForStatus("Proposed to Sangguniang Bayan"),
		'filter'=>$model,
		'columns'=>array( 
			array(
				'name'=>'ord_title',
				'filter'=>false,
			),
			array(
				'name'=>'ord_auth_last',
				'value'=>'$data->getAuthorName("last")',
				'filter'=>false,
			),
			array(
				'name'=>'ord_auth_first',
				'value'=>'$data->getAuthorName("first")',
				'filter'=>false,
			),
			array(
				'name'=>'ord_auth_middle',
				'value'=>'$data->getAuthorName("middle")',
				'filter'=>false,
			),
			array(
				'name' => 'ord_creation_date',
				'filter'=>false,
			),
			array(
				'name'=>'ord_ordtype',
				'filter'=>false,
			),
			array(
				'class'=>'CButtonColumn',
				'template'=>$buttons,
				'buttons'=>array(
					'assign' => array(
						'label'=>'Assign for first reading',     // text label of the button
						'url'=>'Yii::app()->createUrl("/ordinances/firstreading", array("id" => $data->ord_id))',       // the PHP expression for generating the URL of the button
						'imageUrl'=>Yii::app()->baseUrl.'/images/list.png',  // image URL of the button. If not set or false, a text link is used
                    ),
				),
			),
		),
	)); 
?>