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

<h1>For approval of Chief Executive</h1>
<p>Chief executive may choose to approve the ordinance or to veto.</p>
<?php 

	$buttons = '{view}{veto}{approve}';

	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'ordinances-grid',
		'dataProvider'=>$model->getOrdinancesForStatus("Forwarded to Chief Executive"),
		'filter'=>$model,
		'columns'=>array(
			'ord_title',
			array(
				'name'=>'ord_authors_id',
				'value'=>'$data->getAuthor($data->ord_id)',
				),
			'ord_creation_date',
			'ord_ordtype',
			array(
				'class'=>'CButtonColumn',
				'template'=>$buttons,
				'buttons'=>array(
					'veto'=>array(
						'label'=>'Veto this ordinance',     // text label of the button
						'url'=>'Yii::app()->createUrl("/ordinances/veto", array("id" => $data->ord_id))',       // the PHP expression for generating the URL of the button
						'imageUrl'=>Yii::app()->baseUrl.'/images/cross.png',  // image URL of the button. If not set or false, a text link is used
                    ),
					'approve'=>array(
						'label'=>'Approve this ordinance',     // text label of the button
						'url'=>'Yii::app()->createUrl("/ordinances/approve", array("id" => $data->ord_id))', // the PHP expression for generating the URL of the button
						'imageUrl'=>Yii::app()->baseUrl.'/images/check.png',  // image URL of the button. If not set or false, a text link is used
                    ),
				),
			),
		),
	)); 
?>