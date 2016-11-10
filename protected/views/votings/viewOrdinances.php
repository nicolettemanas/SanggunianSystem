<?php
/* @var $this OrdinancesController */
/* @var $model Ordinances */

$this->breadcrumbs=array(
	'Voters'=>array('index'),
	$model->getName(),
	$vote
);

$this->menu=array(
	array('label'=>'List Ordinances', 'url'=>array('index')),
	array('label'=>'Manage Ordinances', 'url'=>array('admin')),
);
?>

<?php 
	
	if($vote == '1')
		$name = 'Ordinances	voted up';
	else if($vote == '0')
		$name = 'Ordinances	voted down';
	else
		$name = 'Ordinances	voted abstain';
		
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>$name,
				'value'=>'',
			)
		)
	));
	
	$temp = $model->getOrdinances($vote);
	
	foreach($temp as $ordinance){	
		$this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				array(
					'name'=>'',
					'value'=>$ordinance['ord_title'],
				),
			)
		));
	}
?>
