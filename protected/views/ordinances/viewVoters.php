<?php
/* @var $this OrdinancesController */
/* @var $model Ordinances */

$this->breadcrumbs=array(
	'Ordinances'=>array('index'),
	'View Approved Ordinances',
	$model->ord_title,
	'Voters',
	'In favor'
);

$this->menu=array(
	array('label'=>'List Ordinances', 'url'=>array('index')),
	array('label'=>'Manage Ordinances', 'url'=>array('admin')),
);
?>

<?php 
	
	if($vote == '1')
		$name = 'Sangguniang Bayan Members (In favor)';
	else if($vote == '0')
		$name = 'Sangguniang Bayan Members (Not in favor)';
	else
		$name = 'Sangguniang Bayan Members (Abstain/Absent)';
	
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>$name,
				'value'=>'',
			)
		)
	));
	
	$temp = $model->getVoters($vote);
	if($temp != null){
		foreach($temp as $voter){	
			$this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'attributes'=>array(
					array(
						'name'=>'',
						'value'=>$voter['user_name'],
					),
				)
			));
		}
	}
?>
