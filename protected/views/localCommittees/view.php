<?php
/* @var $this LocalCommitteesController */
/* @var $model LocalCommittees */

$this->breadcrumbs=array(
	'Local Committees'=>array('index'),
	$model->lc_id,
);

$this->menu=array(
	array('label'=>'List LocalCommittees', 'url'=>array('index')),
	array('label'=>'Create LocalCommittees', 'url'=>array('create')),
	array('label'=>'Update LocalCommittees', 'url'=>array('update', 'id'=>$model->lc_id)),
	array('label'=>'Delete LocalCommittees', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->lc_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LocalCommittees', 'url'=>array('admin')),
);
?>
<h1>View LocalCommittee:<?php echo $model->lc_name; ?></h1>


<?php 
	$attribs = array();
	
	if($members[0]['chairman_name'] != null)
		array_push($attribs, array('label'=>'Chairman', 'value'=>$members[0]['chairman_name']));
	if($members[1]['secretary_name'] != null)
		array_push($attribs, array('label'=>'Secretary', 'value'=>$members[1]['secretary_name']));
	
	//var_dump($model->getMembers($model->lc_id));
	$members = $model->getMembers($model->lc_id);
	
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'lc_id',
			'lc_name',
			$attribs[0],
			$attribs[1],
			array('name'=>'lc_members', 'value'=>''),			
		),
	)); 

	foreach($members as $member){
		$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			$member,
		)));
	}
?>
