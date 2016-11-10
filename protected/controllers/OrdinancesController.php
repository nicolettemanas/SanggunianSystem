<?php

class OrdinancesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		$role=Yii::app()->user->getState('role');
		if($role == "Administrator")
			$actions=array('create','admin','update','index','delete','view','comment');
		else if($role == "LGU")
			$actions=array('admin', 'propose','index','view','comment', 'viewFirst', 'firstReading', 'pendingCommitteeReport', 'uploadCommitteeReport', 'viewSecond', 'secondReading', 'viewPendingMinutes', 'uploadMinutes', 'viewAmendments', 'uploadAmendments', 'viewThird', 'thirdReading', 'viewVotings', 'votings', 'votingResult', 'viewVoters', 'viewTiedVotes', 'breakTie', 'veto', 'vetoVotings', 'votingVetoResult', 'viewVeto', 'approve');
		else
			$actions=array('admin', 'index','view','comment');

		array_push($actions, 'viewApproved', 'viewApprovedResults','viewDisproved', 'viewDisprovedResults');

		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>$actions,
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('admin', 'index','view', 'viewApproved', 'viewApprovedResults','viewDisproved', 'viewDisprovedResults', 'viewVoters'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{

		$model = $this->loadModel($id);

		$this->render('view',array(
			'model'=>$model,
		));
	}

	public function actionUploadCommitteeReport($id)
	{
		$model=$this->loadModel($id);

		$path = Yii::app()->basePath . '/../uploads';
        if (!is_dir($path)) {
            mkdir($path);
        }
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ordinances']))
		{
			if(isset($_POST['yt0'])){
				if(!empty($_FILES['Ordinances']['name']['ord_committee_report_file_id'])){
					$model->ord_committee_report_file_id = CUploadedFile::getInstance($model, 'ord_committee_report_file_id');

					$newid = '/' . time() . '_' . $model->ord_committee_report_file_id . '.pdf';
					$model->ord_committee_report_file_id->saveAs($path . $newid);
					$model->ord_committee_report_file_id = $newid;

					//check if valid ordinance
					if($model->checkProcess($model->ord_id, '1st Reading')){
						if($model->assignCommitteeReport($newid, $model->ord_id))
							$this->redirect(array('view','id'=>$model->ord_id));
						else
							throw new CHttpException(403,'This ordinance is not pending for a committee report.');
					}
				}
				else{
					$model->addError($model->ord_committee_report_file_id, "Must upload a report or approve without report.");
				}
			}
			elseif(isset($_POST['yt1'])){
				if($model->checkProcess($model->ord_id, '1st Reading')){
					if($model->assignCommitteeReport($_POST['yt1'], $model->ord_id)){
						$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
					
						$log = new Logs();
						$log->setAttributes(array(
							'log_id' => uniqid('ss_', true),
							'log_userid' => $user->user_id,
							'log_username' => $user->user_username,
							'log_activity' => 'Uploaded a Committee Report for'.$model->ord_title,
							'log_date' => date('Y-m-d H:m:s')
						));
						
						$log->save();
						
						$this->redirect(array('view','id'=>$model->ord_id));
						
					}
					else
						throw new CHttpException(403,'This ordinance is not pending for a committee report.');
				}
			}
		}

		if($model->isAllowed(Yii::app()->user->getState('id'), "CommitteeReport")){
			if($model->correctCommittee(Yii::app()->user->getState('id'), $model->ord_committee_id)){
				$this->render('uploadCommitteeReport',array(
					'model'=>$model,
				));
			}
			else
				throw new CHttpException(403,'You do not belong to the local committee assigned to the ordinance.');
		}
		else
			throw new CHttpException(403,'You are not authorized to perform this action.');
	}

	public function actionSecondReading($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ordinances']))
		{
			if($model->checkProcess($model->ord_id, '2nd Reading')){
				$temp = $_POST['Ordinances'];
				switch($temp['ord_second_reading_action']){
					case 'Disprove':
						$model->disproveOrdinance();
						
						$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
					
						$log = new Logs();
						$log->setAttributes(array(
							'log_id' => uniqid('ss_', true),
							'log_userid' => $user->user_id,
							'log_username' => $user->user_username,
							'log_activity' => 'Disproved ordinance '.$model->ord_title,
							'log_date' => date('Y-m-d H:m:s')
						));
						
						$log->save();
						
						$this->redirect(array('view','id'=>$model->ord_id));
						break;
					case 'Schedule a public hearing':
						if(empty($_POST['Ordinances']['ord_hearing_venue']))
							$model->addError('ord_hearing_venue', "Venue is required.");
						if(empty($_POST['Ordinances']['ord_date']))
							$model->addError('ord_date', "Date is required.");
						if(empty($_POST['Ordinances']['ord_hearing_time_from']))
							$model->addError('ord_hearing_time_from', "This field is required.");
						if(empty($_POST['Ordinances']['ord_hearing_time_to']))
							$model->addError('ord_hearing_time_to', "This field is required.");
						if(date('Y-m-d', strtotime(date('Y-m-d'). ' + 10 days')) > $_POST['Ordinances']['ord_date'])
							$model->addError('ord_date', "Hearing date must start 10 days from now.");
						if($_POST['Ordinances']['ord_hearing_time_from'] > $_POST['Ordinances']['ord_hearing_time_to'])
							$model->addError('ord_hearing_time_from', "Not a valid time interval.");
						if(!$model->hasErrors()){
							if($model->scheduleHearing($_POST['Ordinances'])){
								
								$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
					
								$log = new Logs();
								$log->setAttributes(array(
									'log_id' => uniqid('ss_', true),
									'log_userid' => $user->user_id,
									'log_username' => $user->user_username,
									'log_activity' => 'Scheduled hearing for '.$model->ord_title,
									'log_date' => date('Y-m-d H:m:s')
								));
								
								$log->save();
								
								$this->redirect(array('view','id'=>$model->ord_id));
							}
						}
						break;
					case 'Upload revision':
						if(!empty($_FILES['Ordinances']['name']['ord_new_file_id'])){
							$path = Yii::app()->basePath . '/../uploads';
							if (!is_dir($path)) {
								mkdir($path);
							}

							//var_dump($model);
							$model->setAttribute('ord_new_file_id', $_POST['Ordinances']['ord_new_file_id']);
							$model->ord_new_file_id = CUploadedFile::getInstance($model, 'ord_new_file_id');

							$newid = '/' . time() . '_' . $model->ord_new_file_id . '.pdf';
							$model->ord_new_file_id->saveAs($path . $newid);
							$model->ord_new_file_id = $newid;

							$model->revise($model->ord_new_file_id);
							
							$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
					
							$log = new Logs();
							$log->setAttributes(array(
								'log_id' => uniqid('ss_', true),
								'log_userid' => $user->user_id,
								'log_username' => $user->user_username,
								'log_activity' => 'Uploaded revision for '.$model->ord_title,
								'log_date' => date('Y-m-d H:m:s')
							));
							
							$log->save();

							$this->redirect(array('view','id'=>$model->ord_id));
						}
						else
							$model->addError('ord_new_file_id', "Please upload the new version.");
						break;
				}
			}
			else{
				throw new CHttpException(403,'This ordinance is not for Second Reading.');
			}

		}

		if($model->isAllowed(Yii::app()->user->getState('id'), "SecondReading")){
			$this->render('secondreading',array(
				'model'=>$model,
			));
		}
		else
			throw new CHttpException(403,'You are not authorized to perform this action.');
	}

	public function actionVotings($id)
	{

		$model=$this->loadModel($id);
		$voting = new Votings();
		$voting = Votings::model()->findbypk($model->ord_voting_id);

			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

		if(isset($_POST['Ordinances']))
		{
			//check if valid ordinance
			if( ($model->checkProcess($model->ord_id, 'Voting (Veto)') ||
				$model->checkProcess($model->ord_id, 'Voting (Final voting)'))
				){
					if(empty($_POST['Ordinances']['ord_vote']))
						$model->addError('ord_vote', "Not a valid vote.");
					if(!$model->hasErrors()){
						$model->registerVote($_POST['Ordinances']['ord_vote']);
						$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
					
						$log = new Logs();
						$log->setAttributes(array(
							'log_id' => uniqid('ss_', true),
							'log_userid' => $user->user_id,
							'log_username' => $user->user_username,
							'log_activity' => 'Registered a vote for '.$model->ord_title,
							'log_date' => date('Y-m-d H:m:s')
						));
						
						$log->save();
						$this->redirect(array('view','id'=>$model->ord_id));
					}
				}
			else
				throw new CHttpException(403,'This ordinance is not for Voting.');
		}

		if($model->isAllowed(Yii::app()->user->getState('id'), "Votings")){
			if(!$model->isReadyForVoting())
				throw new CHttpException(403,'This ordinance is not yet ready for voting or the voting period have already passed.');
			if($model->alreadyVoted())
				throw new CHttpException(403,'You have already voted. All votes are considered as final.');

			$this->render('votings',array(
				'model'=>$model,
				'voting'=>$voting
			));
		}
		else
			throw new CHttpException(403,'You are not authorized to perform this action.');
	}

	public function actionVetoVotings($id)
	{

		$model=$this->loadModel($id);
		$voting = new Votings();
		$voting = Votings::model()->findbypk($model->ord_voting_id);

			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

		if(isset($_POST['Ordinances']))
		{
			//check if valid ordinance
			if( ($model->checkProcess($model->ord_id, 'Voting (Veto)') ||
				$model->checkProcess($model->ord_id, 'Voting (Final voting)'))
				){
					if(empty($_POST['Ordinances']['ord_vote']))
						$model->addError('ord_vote', "Not a valid vote.");
					if(!$model->hasErrors()){
						$model->registerVetoVote($_POST['Ordinances']['ord_vote']);
						
						$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
						
						$log = new Logs();
						$log->setAttributes(array(
							'log_id' => uniqid('ss_', true),
							'log_userid' => $user->user_id,
							'log_username' => $user->user_username,
							'log_activity' => 'Registered vote (veto) for '.$model->ord_title,
							'log_date' => date('Y-m-d H:m:s')
						));
						
						$log->save();
						
						$this->redirect(array('view','id'=>$model->ord_id));
					}
				}
			else
				throw new CHttpException(403,'This ordinance is not for Voting.');
		}

		if($model->isAllowed(Yii::app()->user->getState('id'), "Votings")){
			if(!$model->isReadyForVoting())
				throw new CHttpException(403,'This ordinance is not yet ready for voting or the voting period have already passed.');
			if($model->alreadyVoted())
				throw new CHttpException(403,'You have already voted. All votes are considered as final.');

			$this->render('vetovotings',array(
				'model'=>$model,
				'voting'=>$voting
			));
		}
		else
			throw new CHttpException(403,'You are not authorized to perform this action.');
	}

	public function actionBreakTie($id)
	{

		$model=$this->loadModel($id);
		$voting = new Votings();
		$voting = Votings::model()->findbypk($model->ord_voting_id);

			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

		if(isset($_POST['Ordinances']))
		{
			//check if valid ordinance
			if( ($model->checkProcess($model->ord_id, 'Voting (Veto)') ||
				$model->checkProcess($model->ord_id, 'Voting (Final voting)'))
				){
					if(empty($_POST['Ordinances']['ord_vote']))
						$model->addError('ord_vote', "Not a valid vote.");
					if(!$model->hasErrors()){
						$model->registerVote($_POST['Ordinances']['ord_vote']);
						$model->generateResults();
						
						$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
					
						$log = new Logs();
						$log->setAttributes(array(
							'log_id' => uniqid('ss_', true),
							'log_userid' => $user->user_id,
							'log_username' => $user->user_username,
							'log_activity' => 'Broke a tie '.$model->ord_title,
							'log_date' => date('Y-m-d H:m:s')
						));
						
						$log->save();
						
						$this->redirect(array('view','id'=>$model->ord_id));
					}
				}
			else
				throw new CHttpException(403,'This ordinance is not for Voting.');
		}

		if($model->isAllowed(Yii::app()->user->getState('id'), "Votings")){
			if($model->alreadyVoted())
				throw new CHttpException(403,'You have already voted. All votes are considered as final.');

			$this->render('votings',array(
				'model'=>$model,
				'voting'=>$voting
			));
		}
		else
			throw new CHttpException(403,'You are not authorized to perform this action.');
	}

	public function actionFirstReading($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ordinances']))
		{
			//check if valid ordinance
			if($model->checkProcess($model->ord_id, 'Proposed to Sangguniang Bayan')){
				if($model->assignCommittee($_POST['Ordinances']['ord_committee_id'], $model->ord_id)){
					
					$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
					
					$log = new Logs();
					$log->setAttributes(array(
						'log_id' => uniqid('ss_', true),
						'log_userid' => $user->user_id,
						'log_username' => $user->user_username,
						'log_activity' => 'Assigned '.$model->ord_title.' to a Local Committee',
						'log_date' => date('Y-m-d H:m:s')
					));
					
					$log->save();
					
					$this->redirect(array('view','id'=>$model->ord_id));
				}
			}
			else
				throw new CHttpException(403,'This ordinance is not for First Reading.');
		}

		$currUser = Users::model()->findByPk(Yii::app()->user->getState('id'));
		if($currUser->isPresidingOfficer()){
			$this->render('firstreading',array(
				'model'=>$model,
			));
		}
		else
			throw new CHttpException(403,'You are not authorized to perform this action.');
	}


	public function actionThirdReading($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ordinances']))
		{
			//check if valid ordinance
			if($model->checkProcess($model->ord_id, '3rd Reading')){
				if(empty($_POST['Ordinances']['ord_reading_date_from']))
					$model->addError('ord_reading_date_from', "All fields are required.");
				if(empty($_POST['Ordinances']['ord_reading_date_to']))
					$model->addError('ord_reading_date_to', "All fields are required.");
				if($_POST['Ordinances']['ord_reading_date_to'] < $_POST['Ordinances']['ord_reading_date_from'])
					$model->addError('ord_reading_date_from', "Not a valid date interval.");
				if($_POST['Ordinances']['ord_reading_date_from'] < date('Y-m-d'))
					$model->addError('ord_reading_date_from', "Must be scheduled in the future.");
				if(!$model->hasErrors()){
					if($model->scheduleVoting($_POST['Ordinances']['ord_reading_date_from'], $_POST['Ordinances']['ord_reading_date_to'], $model->ord_id)){
						
						$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
					
						$log = new Logs();
						$log->setAttributes(array(
							'log_id' => uniqid('ss_', true),
							'log_userid' => $user->user_id,
							'log_username' => $user->user_username,
							'log_activity' => 'Scheduled 3rd reading for '.$model->ord_title,
							'log_date' => date('Y-m-d H:m:s')
						));
						
						$log->save();
						
						$this->redirect(array('view','id'=>$model->ord_id));
					}
				}
			}
			else
				throw new CHttpException(403,'This ordinance is not for Third Reading.');
		}

		if($model->isAllowed(Yii::app()->user->getState('id'), "FirstReading")){
			$this->render('thirdreading',array(
				'model'=>$model,
			));
		}
		else
			throw new CHttpException(403,'You are not authorized to perform this action.');
	}


	public function actionVotingResult($id)
	{
		$model=$this->loadModel($id);
		$sb = new Sangguniangbayan();
		$voting = new Votings();
		$voting = Votings::model()->findByPk($model->ord_voting_id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		//var_dump($_POST);
		if(isset($_POST['Ordinances']))
		{
			//check if valid ordinance
			if($model->checkProcess($model->ord_id, 'Voting (Final voting)')
			|| $model->checkProcess($model->ord_id, 'Voting (Veto)')
			){
				if($_POST['Ordinances']['ord_second_reading_action'] == "Generate Results"){
					if($model->generateResults()){
						$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
					
						$log = new Logs();
						$log->setAttributes(array(
							'log_id' => uniqid('ss_', true),
							'log_userid' => $user->user_id,
							'log_username' => $user->user_username,
							'log_activity' => 'Generated votes for '.$model->ord_title,
							'log_date' => date('Y-m-d H:m:s')
						));
						
						$log->save();
						$this->redirect(array('view','id'=>$model->ord_id));;
					}
					else
						throw new CHttpException(403,'Number of voters did not reach quorum. Please wait for other voters or extend the deadline.');
				}
				else if($_POST['Ordinances']['ord_second_reading_action'] == "Extend deadline"){
					if(empty($_POST['Ordinances']['ord_reading_date_to']))
						$model->addError('ord_reading_date_to', 'Please set a deadline.');
					if($_POST['Ordinances']['ord_reading_date_to'] <= date('Y-m-d'))
						$model->addError('ord_reading_date_to', 'Not a valid deadline.');
					if(!$model->hasErrors()){
						
						$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
					
						$log = new Logs();
						$log->setAttributes(array(
							'log_id' => uniqid('ss_', true),
							'log_userid' => $user->user_id,
							'log_username' => $user->user_username,
							'log_activity' => 'Extended deadline for voting for '.$model->ord_title,
							'log_date' => date('Y-m-d H:m:s')
						));
						
						$log->save();
						
						$model->reschedule($_POST['Ordinances']['ord_reading_date_to']);
					
					
					}
				}
			}
			else
				throw new CHttpException(403,'This ordinance is not for Voting Results.');
		}

		if($model->isAllowed(Yii::app()->user->getState('id'), "VotingResult")){
			$this->render('votingResult',array(
				'model'=>$model,
				'sb'=>$sb,
				'voting' => $voting
			));
		}
		else
			throw new CHttpException(403,'You are not authorized to perform this action.');
	}

	public function actionVotingVetoResult($id)
	{
		$model=$this->loadModel($id);
		$sb = new Sangguniangbayan();
		$voting = new Votings();
		$voting = Votings::model()->findByPk($model->ord_voting_id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		//var_dump($_POST);
		if(isset($_POST['yt0']))
		{
			//check if valid ordinance
			if($model->checkProcess($model->ord_id, 'Voting (Final voting)')
			|| $model->checkProcess($model->ord_id, 'Voting (Veto)')
			){
				if($model->generateVetoResults()){
					$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
					
					$log = new Logs();
					$log->setAttributes(array(
						'log_id' => uniqid('ss_', true),
						'log_userid' => $user->user_id,
						'log_username' => $user->user_username,
						'log_activity' => 'Generated voting results (veto) for'.$model->ord_title,
						'log_date' => date('Y-m-d H:m:s')
					));
					
					$log->save();
					$this->redirect(array('view','id'=>$model->ord_id));;
				}
				else
					throw new CHttpException(403,'Number of voters did not reach quorum. Please wait for other voters.');
			}
			else
				throw new CHttpException(403,'This ordinance is not for Voting Results.');
		}

		$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
		if($user->isPresidingOfficer($user->user_id)){
			$this->render('votingVetoResult',array(
				'model'=>$model,
				'sb'=>$sb,
				'voting' => $voting
			));
		}
		else
			throw new CHttpException(403,'You are not authorized to perform this action.');
	}


	public function actionUploadMinutes($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ordinances']))
		{
			//check if valid ordinance
			if($model->checkProcess($model->ord_id, 'Scheduled for hearing')){
				if(!empty($_FILES['Ordinances']['name']['ord_new_file_id'])){
					$path = Yii::app()->basePath . '/../uploads';
					if (!is_dir($path)) {
						mkdir($path);
					}

					//var_dump($model);
					$model->setAttribute('ord_new_file_id', $_POST['Ordinances']['ord_new_file_id']);
					$model->ord_new_file_id = CUploadedFile::getInstance($model, 'ord_new_file_id');

					$newid = '/' . time() . '_' . $model->ord_new_file_id;
					$model->ord_new_file_id->saveAs($path . $newid);
					$model->ord_new_file_id = $newid;

					$model->saveMinutes($model->ord_new_file_id);
					
					$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
					
					$log = new Logs();
					$log->setAttributes(array(
						'log_id' => uniqid('ss_', true),
						'log_userid' => $user->user_id,
						'log_username' => $user->user_username,
						'log_activity' => 'Uploaded minutes of the meeting for '.$model->ord_title,
						'log_date' => date('Y-m-d H:m:s')
					));
					
					$log->save();

					$this->redirect(array('view','id'=>$model->ord_id));
				}
				else
					$model->addError('ord_new_file_id', "Please upload a file.");

			}
			else
				throw new CHttpException(403,'This ordinance is not for Uploading Minutes of the Meeting.');
		}

		if($model->isAllowed(Yii::app()->user->getState('id'), "viewPendingMinutes")){
			$this->render('uploadMinutes',array(
				'model'=>$model,
			));
		}
		else
			throw new CHttpException(403,'You are not authorized to perform this action.');
	}

	public function actionApprove($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ordinances']))
		{
			//check if valid ordinance
			if(empty($_POST['Ordinances']['ord_effectivity_date']))
				$model->addError('ord_effectivity_date', "All fields are required.");
			if($_POST['Ordinances']['ord_effectivity_date'] < date('Y-m-d', strtotime(date('Y-m-d'). ' + 10 days')) )
				$model->addError('ord_effectivity_date', "Must be scheduled in the future. Ten (10) days after approval.");
			if(!$model->hasErrors()){
				if($model->approve($_POST['Ordinances']['ord_effectivity_date'], $model->ord_id)){
					
					$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
					
					$log = new Logs();
					$log->setAttributes(array(
						'log_id' => uniqid('ss_', true),
						'log_userid' => $user->user_id,
						'log_username' => $user->user_username,
						'log_activity' => 'Approved ordinance '.$model->ord_title
						,
						'log_date' => date('Y-m-d H:m:s')
					));
					
					$log->save();
					
					$this->redirect(array('view','id'=>$model->ord_id));
				}
			}
		}
		
		$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
		
		if($user->isChiefExecutive($user->user_id)){
			$this->render('approve',array(
				'model'=>$model,
			));
		}
		else
			throw new CHttpException(403,'You are not authorized to perform this action.');
	}

	public function actionVeto($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ordinances']))
		{
			//check if valid ordinance
			if(empty($_POST['Ordinances']['ord_reading_date_from']))
				$model->addError('ord_reading_date_from', "All fields are required.");
			if(empty($_POST['Ordinances']['ord_reading_date_to']))
				$model->addError('ord_reading_date_to', "All fields are required.");
			if($_POST['Ordinances']['ord_reading_date_to'] < $_POST['Ordinances']['ord_reading_date_from'])
				$model->addError('ord_reading_date_from', "Not a valid date interval.");
			if($_POST['Ordinances']['ord_reading_date_from'] < date('Y-m-d'))
				$model->addError('ord_reading_date_from', "Must be scheduled in the future.");
			if(!$model->hasErrors()){
				if($model->scheduleVetoVoting($_POST['Ordinances']['ord_reading_date_from'], $_POST['Ordinances']['ord_reading_date_to'], $model->ord_id)){
					$this->redirect(array('view','id'=>$model->ord_id));
				
					$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
					
					$log = new Logs();
					$log->setAttributes(array(
						'log_id' => uniqid('ss_', true),
						'log_userid' => $user->user_id,
						'log_username' => $user->user_username,
						'log_activity' => 'Vetoed ordinance '.$model->ord_title,
						'log_date' => date('Y-m-d H:m:s')
					));
					
					$log->save();
				}
			}
		}
		$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
		if($user->isChiefExecutive($user->user_id)){
			$this->render('veto',array(
				'model'=>$model,
			));
		}
		else
			throw new CHttpException(403,'You are not authorized to perform this action.');
	}

	public function actionUploadAmendments($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ordinances']))
		{
			//check if valid ordinance
			if($model->checkProcess($model->ord_id, 'Waiting for Committee Amendments')){
				if(isset($_POST['yt0'])){
					if(!empty($_FILES['Ordinances']['name']['ord_new_file_id'])){
						$path = Yii::app()->basePath . '/../uploads';
						if (!is_dir($path)) {
							mkdir($path);
						}

						//var_dump($model);
						$model->setAttribute('ord_new_file_id', $_POST['Ordinances']['ord_new_file_id']);
						$model->ord_new_file_id = CUploadedFile::getInstance($model, 'ord_new_file_id');

						$newid = '/' . time() . '_' . $model->ord_new_file_id;
						$model->ord_new_file_id->saveAs($path . $newid);
						$model->ord_new_file_id = $newid;

						$model->revise($model->ord_new_file_id);
						
						$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
					
						$log = new Logs();
						$log->setAttributes(array(
							'log_id' => uniqid('ss_', true),
							'log_userid' => $user->user_id,
							'log_username' => $user->user_username,
							'log_activity' => 'Uploaded amendments for '.$model->ord_title,
							'log_date' => date('Y-m-d H:m:s')
						));
						
						$log->save();

						$this->redirect(array('view','id'=>$model->ord_id));
					}
					else
						$model->addError('ord_new_file_id', "Please upload a file.");
				}
				else if(isset($_POST['yt1'])){
						$model->disproveOrdinance();
						$this->redirect(array('view','id'=>$model->ord_id));
				}
			}
			else
				throw new CHttpException(403,'This ordinance is not ready for Committee Amendments.');
		}

		if($model->isAllowed(Yii::app()->user->getState('id'), "viewAmendments")){
			$this->render('uploadAmendments',array(
				'model'=>$model,
			));
		}
		else
			throw new CHttpException(403,'You are not authorized to perform this action.');
	}


	public function actionViewSecond()
	{
		$model=new Ordinances('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ordinances']))
			$model->attributes=$_GET['Ordinances'];

		if($model->isAllowed(Yii::app()->user->getState('id'), "SecondReading")){
			$this->render('viewSecond',array(
				'model'=>$model,
			));
		}
		else
			throw new CHttpException(403,'You are not authorized to perform this action.');
	}

	public function actionViewThird()
	{
		$model=new Ordinances('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ordinances']))
			$model->attributes=$_GET['Ordinances'];

		if($model->isAllowed(Yii::app()->user->getState('id'), "SecondReading")){
			$this->render('viewThird',array(
				'model'=>$model,
			));
		}
		else
			throw new CHttpException(403,'You are not authorized to perform this action.');
	}

	public function actionViewPendingMinutes()
	{
		$model=new Ordinances('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ordinances']))
			$model->attributes=$_GET['Ordinances'];

		if($model->isAllowed(Yii::app()->user->getState('id'), "viewPendingMinutes")){
			$this->render('viewPendingMinutes',array(
				'model'=>$model,
			));
		}
		else
			throw new CHttpException(403,'You are not authorized to perform this action.');
	}
	public function actionViewAmendments()
	{
		$model=new Ordinances('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ordinances']))
			$model->attributes=$_GET['Ordinances'];

		if($model->isAllowed(Yii::app()->user->getState('id'), "viewAmendments")){
			$this->render('viewAmendments',array(
				'model'=>$model,
			));
		}
		else
			throw new CHttpException(403,'You are not authorized to perform this action.');
	}
	public function actionViewVotings()
	{
		$model=new Ordinances('search');
		$user = Users::model()->findByPk(Yii::app()->user->getState('id'));

		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ordinances']))
			$model->attributes=$_GET['Ordinances'];

		if($model->isAllowed(Yii::app()->user->getState('id'), "Votings")){
			$this->render('viewVotings',array(
				'model'=>$model,
				'user'=>$user
			));
		}
		else
			throw new CHttpException(403,'You are not authorized to perform this action.');
	}

	public function actionViewDisproved()
	{
		$model=new Ordinances('search');
		$model->search('Disproved');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Ordinances']))
			$model->attributes=$_GET['Ordinances'];

		$this->render('viewDisproved',array(
			'model'=>$model,
		));
	}


	public function actionViewApproved()
	{
		$model=new Ordinances('search');
		$model->search('Approved');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Ordinances']))
			$model->attributes=$_GET['Ordinances'];

		$this->render('viewApproved',array(
			'model'=>$model,
		));
	}


	public function actionViewVoters($id,$vote)
	{
		$model=$this->loadModel($id);

		$this->render('viewVoters',array(
			'model'=>$model,
			'vote'=>$vote
		));
	}

	public function actionViewTiedVotes()
	{
		$model=new Ordinances('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ordinances']))
			$model->attributes=$_GET['Ordinances'];

		$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
		//var_dump($user);

		if($user->isPresidingOfficer($user->user_id)){
			$this->render('viewTiedVotes',array(
				'model'=>$model,

			));
		}
		else
			throw new CHttpException(403,'You are not authorized to perform this action.');
	}

	public function actionViewVeto()
	{
		$model=new Ordinances('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ordinances']))
			$model->attributes=$_GET['Ordinances'];
		
		$currUser = Users::model()->findByPk(Yii::app()->user->getState('id'));
		
		if($currUser->isChiefExecutive()){
			$this->render('viewVeto',array(
				'model'=>$model,
			));
		}
		else
			throw new CHttpException(403,'You are not authorized to perform this action.');
	}

	public function actionViewFirst()
	{
		$model=new Ordinances('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ordinances']))
			$model->attributes=$_GET['Ordinances'];
		
		$currUser = Users::model()->findByPk(Yii::app()->user->getState('id'));
		
		if($currUser->isPresidingOfficer()){
			$this->render('viewFirst',array(
				'user'=>$currUser,
				'model'=>$model,
			));
		}
		else
			throw new CHttpException(403,'You are not authorized to perform this action.');
	}

	public function actionPendingCommitteeReport()
	{
		$model=new Ordinances('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ordinances']))
			$model->attributes=$_GET['Ordinances'];

		if($model->isAllowed(Yii::app()->user->getState('id'), "CommitteeReport")){
			$this->render('pendingCommitteeReport',array(
				'model'=>$model,
			));
		}
		else
			throw new CHttpException(403,'You are not authorized to perform this action.');
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Ordinances;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ordinances']))
		{
			$version = $model->getV($model->ord_id);
			if($version == NULL) $version = 1;
			else{
				$version = $version;
			}
			
			$path = Yii::app()->basePath . '/../uploads';
			if (!is_dir($path)) {
				mkdir($path);
			}
			
			$model->attributes=$_POST['Ordinances'];
			
			$model->setAttribute('ord_id', uniqid('ss_', true));
			$model->setAttribute('ord_no', $model->getOrdinanceNumber());
			$date = new dateTime($model->ord_creation_date);
			$model->setAttribute('ord_creation_date', $date->format('Y-m-d H:m:s'));
			
			if(empty($model->ord_effectivity_date))
				unset($model->ord_effectivity_date);
			if(empty($model->ord_approval_date))
				unset($model->ord_approval_date);
			
			$model->setOrdinanceNumber(date('Y'));
			$model->ord_file_id = CUploadedFile::getInstance($model, 'ord_file_id');
			
			if($model->ord_file_id != null){

				$newid = '/' . time() . '_' . $model->ord_file_id . '.pdf';
				$model->ord_file_id->saveAs($path . $newid);
				$model->ord_file_id = $newid;
				var_dump($model->attributes);
			}
			if(!empty($model->ord_committee_report_file_id)){
				$model->ord_committee_report_file_id = CUploadedFile::getInstance($model, 'ord_committee_report_file_id');

				$newid = '/' . time() . '_' . $model->ord_committee_report_file_id . '.pdf';
				$model->ord_committee_report_file_id->saveAs($path . $newid);
				$model->ord_committee_report_file_id = $newid;

				$model->assignCommitteeReport($newid, $model->ord_id);
			}
			
			if($model->save()){
			
				$this->redirect(array('view','id'=>$model->ord_id));
				
				$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
					
					$log = new Logs();
					$log->setAttributes(array(
						'log_id' => uniqid('ss_', true),
						'log_userid' => $user->user_id,
						'log_username' => $user->user_username,
						'log_activity' => 'Created Ordinance '.$model->ord_name,
						'log_date' => date('Y-m-d H:m:s')
					));
					
					$log->save();				
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Proposes a new ordinance.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionPropose()
	{
		$model=new Ordinances;
		$lc=new Localcommittees;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$path = Yii::app()->basePath . '/../uploads';
        if (!is_dir($path)) {
            mkdir($path);
        }

		if(isset($_POST['Ordinances']))
		{
			$model=new Ordinances;
			$date = new DateTime();

			$model->attributes = $_POST['Ordinances'];
			$model->setAttributes(array(
				'ord_id' => uniqid('ss_', true),
				'ord_authors_id' => Yii::app()->user->getState('id'),
				'ord_creation_date' => $date->format('Y-m-d H:i:s'),
				'ord_status' => 'Proposed to Sangguniang Bayan',
				'ord_approval_status' => 'Proposed',
				'ord_no' => $model->getOrdinanceNumber()
			));
				$model->setOrdinanceNumber(date('Y'));
				$model->ord_file_id = CUploadedFile::getInstance($model, 'ord_file_id');

			if($model->validate()){
				$newid = '/' . time() . '_' . $model->ord_file_id . '.pdf';
				$model->ord_file_id->saveAs($path . $newid);
				$model->ord_file_id = $newid;

				if($model->validate() && $model->save()){
				
					$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
					
					$log = new Logs();
					$log->setAttributes(array(
						'log_id' => uniqid('ss_', true),
						'log_userid' => $user->user_id,
						'log_username' => $user->user_username,
						'log_activity' => 'Proposed ordinance '.$model->ord_title,
						'log_date' => date('Y-m-d H:m:s')
					));
					
					$log->save();
				
					$this->redirect(array('view','id'=>$model->ord_id));
				}
			}
		}

		$this->render('propose',array(
			'model'=>$model,
			'lc_list'=>$lc,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		$path = Yii::app()->basePath . '/../uploads';
        if (!is_dir($path)) {
            mkdir($path);
        }
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ordinances']))
		{
			$model->attributes=$_POST['Ordinances'];
			//var_dump($_POST['Ordinances']['ord_authors_id']);
			
			if(empty($model->ord_creation_date))
				$model->ord_creation_date = null;
			if(empty($model->ord_approval_date))
				$model->ord_approval_date = null;
			if(empty($model->ord_effectivity_date))
				$model->ord_effectivity_date = null;
			
			$model->ord_file_id = CUploadedFile::getInstance($model, 'ord_file_id');

			$newid = '/' . time() . '_' . $model->ord_file_id . '.pdf';
			$model->ord_file_id->saveAs($path . $newid);
			$model->ord_file_id = $newid;

			if($model->save()){
				$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
					
					$log = new Logs();
					$log->setAttributes(array(
						'log_id' => uniqid('ss_', true),
						'log_userid' => $user->user_id,
						'log_username' => $user->user_username,
						'log_activity' => 'Updated ordinance '.$model->ord_title,
						'log_date' => date('Y-m-d H:m:s')
					));
					
					$log->save();
				
				$this->redirect(array('view','id'=>$model->ord_id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
					
		$log = new Logs();
		$log->setAttributes(array(
			'log_id' => uniqid('ss_', true),
			'log_userid' => $user->user_id,
			'log_username' => $user->user_username,
			'log_activity' => 'Deleted ordinence '.$this->loadModel($id)->ord_title,
			'log_date' => date('Y-m-d H:m:s')
		));
		
		$log->save();
		
		$this->loadModel($id)->delete();
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Ordinances', array(
			'criteria'=>array(
				'order' => 'ord_creation_date DESC',
			),
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		
		$user = Users::model()->findByPk(Yii::app()->user->getState('id'));
		$model=new Ordinances('search');
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Ordinances'])){
			$model->attributes=$_GET['Ordinances'];
		}
		$this->render('admin',array(
			'model'=>$model,
			'user'=>$user
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Ordinances the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Ordinances::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Ordinances $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ordinances-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
