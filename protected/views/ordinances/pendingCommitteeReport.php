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

<h1>Committee Report</h1>
<p>The following Ordinances are are already assigned to the respective Local Committees and are pending for reports.</p>
<?php 
	$buttons = '{view}{upload}';

	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'ordinances-grid',
		'dataProvider'=>$model->getOrdinancesForStatus("1st Reading"),
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
					'upload' => array(
						'label'=>'Upload a report',     // text label of the button
						'url'=>'Yii::app()->createUrl("/ordinances/uploadCommitteeReport", array("id" => $data->ord_id))',       // the PHP expression for generating the URL of the button
						'imageUrl'=>Yii::app()->baseUrl.'/images/list.png',  // image URL of the button. If not set or false, a text link is used
                    ),
				),
			),
		),
	)); 
?>