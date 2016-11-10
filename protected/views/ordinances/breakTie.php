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
	'Tied Ordinances',
	'Break Tie',
);

$act =  $role == "Administrator"?"Create":"Propose";

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
?>

<h1>Voting</h1>

<p>No debate or amendment shall be allowed. Ordinance shall be read and the question upon its passage shall be immediately taken.</p>

<?php $this->renderPartial('_form_voting', array('model'=>$model, 'voting'=>$voting)); ?>