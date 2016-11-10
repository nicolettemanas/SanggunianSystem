<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage',
);

$curr_user = Users::model()->findByPk(Yii::app()->user->getState('id'));
$isAdmin = $curr_user->isAdministrator();

$this->menu=array(
	array('label'=>'List Users', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create'), 'visible'=>$isAdmin),
	array('label'=>'Manage Users', 'url'=>array('admin'), 'visible'=>$isAdmin),
	array('label'=>'Assign Presiding Officer', 'url'=>array('presidingOfficer'), 'visible'=>$isAdmin),
	array('label'=>'Assign Chief Executive', 'url'=>array('chiefExecutive'), 'visible'=>$isAdmin));

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#users-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Users</h1>

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
	'id'=>'users-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'user_id',
		'user_username',
		'user_email',
		'user_lastname',
		'user_firstname',
		'user_middlename',
		'user_usertype',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
