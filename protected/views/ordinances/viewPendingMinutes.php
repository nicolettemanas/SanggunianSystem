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

<h1>Pending for 3rd Reading</h1>
<p>The following list of ordinances have been evaluated in a public hearing. Please upload the associated Minutes of the Meeting to approve the ordinance for 3rd reading.</p>
<?php 
	$buttons = '{view}{assign}';

	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'ordinances-grid',
		'dataProvider'=>$model->getAvailableForHearing(),
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
						'label'=>'Upload Minutes of the Meeting',     // text label of the button
						'url'=>'Yii::app()->createUrl("/ordinances/uploadMinutes", array("id" => $data->ord_id))',       // the PHP expression for generating the URL of the button
						'imageUrl'=>Yii::app()->baseUrl.'/images/list.png',  // image URL of the button. If not set or false, a text link is used
                    ),
				),
			),
		),
	)); 
?>