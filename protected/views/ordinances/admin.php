<?php
/* @var $this OrdinancesController */
/* @var $model Ordinances */

$role = Yii::app()->user->getState('role');
$userId = Yii::app()->user->getState('id');
$isSbSec = Users::model()->isSbSec($userId);
$isPOfficer = Users::model()->isPresidingOfficer($userId);
$isCommitteeSec = Users::model()->isCommitteeSec($userId);

$this->breadcrumbs=array(
	'Ordinances'=>array('index'),
	'All Ordinances',
);

$act = $role=="Administrator"?"Create":"Propose";

$this->menu=array(
	array('label'=>$act.' Ordinances', 'url'=>array($act), 'visible'=> (!Yii::app()->user->isGuest)),
	array('label'=>'List Ordinances', 'url'=>array('index'),),
	array('label'=>'View all Ordinances', 'url'=>array('admin')),
	array('label'=>'Approved Ordinances', 'url'=>array('viewApproved')),
	array('label'=>'Disproved Ordinances', 'url'=>array('viewDisproved')),

	//array('label'=>'First Reading', 'url'=>array('viewFirst'), 'visible'=>$model->isSbSec($userId)),
	array('label'=>'First Reading', 'url'=>array('viewFirst'), 'visible'=>$isPOfficer),
	array('label'=>'Second Reading', 'url'=>array('viewSecond'), 'visible'=>$isSbSec),
	array('label'=>'Third Reading', 'url'=>array('viewThird'), 'visible'=>$isSbSec),
	array('label'=>'Pending for Committee Report', 'url'=>array('pendingCommitteeReport'), 'visible'=>$isCommitteeSec),
	array('label'=>'Hearing: Minutes of the Meeting', 'url'=>array('viewPendingMinutes'), 'visible'=>$isSbSec),
	array('label'=>'Oridinances for Amendments', 'url'=>array('viewAmendments'), 'visible'=>$isCommitteeSec),
	array('label'=>'Current Votings', 'url'=>array('viewVotings'), 'visible'=>( Users::model()->isSbMember($userId) || $isPOfficer )),
	array('label'=>'Tied Votes', 'url'=>array('viewTiedVotes'), 'visible'=>$isPOfficer),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ordinances-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>View all Ordinances</h1>

<p>
You may use the advanced search option to search for other details.
</p>
<br />
<p>
Searchable attributes includes title, description, author's name, date of creation, date of approval, status in the proposal process, status in the approval process, and the type of the ordinance.
</p>
<br />
<p>
Click the following link to use advanced search.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php
	$buttons = '{view}';

	if($role == "Administrator") $buttons.='{update}{delete}';

	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'ordinances-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'columns'=>array(
			'ord_title',
			array(
				'name'=>'ord_auth_last',
				'value'=>'$data->getAuthorName("last")',
			),
			array(
				'name' => 'ord_creation_date',
				'filter'=>CHtml::datefield('Ordinances[ord_creation_date]', date('Y-m-d H:m:s')),
				'value'=>function($data){
					$date = new dateTime($data->ord_creation_date);
					return $date->format('m/d/Y');
				}
			),
			array(
				'name' => 'ord_approval_date',
				'filter'=>CHtml::datefield('Ordinances[ord_approval_date]'),
				'value'=>function($data){
					$date = new dateTime($data->ord_approval_date);
					return $date->format('m/d/Y');
				}
			),
			array(
				'name'=>'ord_approval_status',
				'filter'=>CHtml::dropDownList('Ordinances[ord_approval_status]', '', array(
					'',
					'Approved'=>'Approved',
					'Disproved'=>'Disproved',
					'Proposed'=>'Proposed',
				))
			),
			array(
				'name' => 'ord_status',
				'filter'=>CHtml::dropDownList('Ordinances[ord_status]', '', array(
					'',
					'Proposed to Sangguniang Bayan'=>'Proposed to Sangguniang Bayan',
					'1st Reading'=>'1st Reading',
					'2nd Reading'=>'2nd Reading',
					'3rd Reading'=>'3rd Reading',
					'Vetoed by Executive Officer'=>'Vetoed by Executive Officer',
					'Voting (Final voting)'=>'Voting (Final voting)',
					'Approved and Published'=>'Approved and Published',
					'Disproved'=>'Disproved',
					'Scheduled for hearing'=>'Scheduled for hearing',
					'Waiting for Committee Amendments'=>'Waiting for Committee Amendments',
					'Voting (Veto)'=>'Voting (Veto)',
					'Forwarded to Chief Executive'=>'Forwarded to Chief Executive'
				)),
			),
			array(
				'name'=>'comm_id',
				'value'=>'$data->getCommittee($data->ord_committee_id)',
			),
			array(
				'name'=>'ord_ordtype',
				'filter'=>CHtml::dropDownList('Ordinances[ord_ordtype]', '', array(
					'',
					'General Ordinance'=>'General Ordinance',
					'Appropriation Ordinance'=>'Appropriation Ordinance',
					'Tax Ordinance'=>'Tax Ordinance',
					'Special Ordinance'=>'Special Ordinance',
				))
			),
			array(
				'class'=>'CButtonColumn',
				'template'=>$buttons,
			),
		),
	));
?>
