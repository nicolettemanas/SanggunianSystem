<?php
/* @var $this LocalCommitteesController */
/* @var $model LocalCommittees */

$this->breadcrumbs=array(
	'Local Committees'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List LocalCommittees', 'url'=>array('index')),
	array('label'=>'Create LocalCommittees', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#local-committees-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Local Committees</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'local-committees-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'lc_name',
		array(
			'name'=>'lc_chariman_id',
			'value'=>'$data->getUser($data->lc_chariman_id)',
		),
		array(
			'name'=>'lc_secretary_id',
			'value'=>'$data->getUser($data->lc_secretary_id)',
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
