<?php
/* @var $this OrdinancesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ordinances',
);

$userId = Yii::app()->user->getState('id');
$model = Users::model()->findByPk($userId);

$role = Yii::app()->user->getState('role');
$isSbSec = Users::model()->isSbSec($userId);
$isSbMember = Users::model()->isSbMember($userId);
$isPOfficer = Users::model()->isPresidingOfficer($userId);
$isCommitteeSec = Users::model()->isCommitteeSec($userId);
$isChiefExecutive = Users::model()->isChiefExecutive($userId);
$act =  $role == "Administrator"?"Create":"Propose";



$this->menu=array(
array('label'=>$act.' Ordinances', 'url'=>array($act), 'visible'=> (!Yii::app()->user->isGuest)),
	array('label'=>'List Ordinances', 'url'=>array('index')),
	array('label'=>'View all Ordinances', 'url'=>array('admin')),
	array('label'=>'Approved Ordinances', 'url'=>array('viewApproved')),
	array('label'=>'Disproved Ordinances', 'url'=>array('viewDisproved')),
	
	array('label'=>'First Reading', 'url'=>array('viewFirst'), 'visible'=>$isPOfficer),
	array('label'=>'Second Reading', 'url'=>array('viewSecond'), 'visible'=>$isSbSec),
	array('label'=>'Third Reading', 'url'=>array('viewThird'), 'visible'=>$isSbSec),
	array('label'=>'Pending for Committee Report', 'url'=>array('pendingCommitteeReport'), 'visible'=>$isCommitteeSec),
	array('label'=>'Hearing: Minutes of the Meeting', 'url'=>array('viewPendingMinutes'), 'visible'=>$isSbSec),
	array('label'=>'Oridinances for Amendments', 'url'=>array('viewAmendments'), 'visible'=>$isCommitteeSec),
	array('label'=>'Current Votings', 'url'=>array('viewVotings'), 'visible'=>( $isSbMember || $isPOfficer )),
	array('label'=>'Tied Votes', 'url'=>array('viewTiedVotes'), 'visible'=>$isPOfficer),
	array('label'=>'Ordinances for final approval', 'url'=>array('viewVeto'), 'visible'=>$isChiefExecutive));
?>

<h1>Ordinances</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
