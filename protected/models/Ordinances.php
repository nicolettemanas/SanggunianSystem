<?php

/**
 * This is the model class for table "ordinances".
 *
 * The followings are the available columns in table 'ordinances':
 * @property string $ord_id
 * @property string $ord_title
 * @property string $ord_description
 * @property string $ord_authors_id
 * @property string $ord_file_id
 * @property string $ord_creation_date
 * @property string $ord_effectivity_date
 * @property string $ord_approval_date
 * @property string $ord_status
 * @property string $ord_approval_status
 * @property string $ord_committee_id
 * @property string $ord_committee_report_file_id
 * @property string $ord_voting_id
 * @property string $ord_ordtype
 * @property string $ord_comments_id
 *
 * The followings are the available model relations:
 * @property ChiefExecVetos[] $chiefExecVetoses
 */
class Ordinances extends CActiveRecord
{

	public $sql_getCommittees = 'SELECT lc_name, lc_id from local_committees;';
	public $ord_second_reading_action;
	public $ord_date;
	public $ord_new_file_id;
	public $ord_hearing_venue;
	public $ord_hearing_time_from;
	public $ord_hearing_time_to;
	public $ord_reading_date_from;
	public $ord_reading_date_to;
	public $ord_vote;
	public $ord_auth_last;
	public $ord_auth_middle;
	public $ord_auth_first;
	public $comm_id;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ordinances';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ord_id, ord_title, ord_description, ord_authors_id, ord_file_id, ord_status, ord_approval_status, ord_ordtype, ord_creation_date', 'required'),

			array('ord_description, ord_id, ord_authors_id, ord_effectivity_date, ord_creation_date, ord_file_id, ord_status, ord_approval_status, ord_ordtype, ord_committee_report_file_id, ord_no, ord_approval_date, ord_auth_last, ord_auth_first, ord_auth_middle, comm_id', 'safe'),

			array('ord_id, ord_authors_id, ord_file_id, ord_committee_id, ord_voting_id, ord_comments_id', 'length', 'max'=>64),
			array('ord_title', 'length', 'max'=>256),
			array('ord_committee_id', 'required', 'on'=>'firstReading'),
			array('ord_title', 'unique', 'message'=>'This title is already taken.'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ord_title, ord_description, ord_creation_date, ord_effectivity_date, ord_approval_date, ord_status, ord_approval_status, ord_voting_id, ord_ordtype', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'chiefExecVetoses' => array(self::HAS_MANY, 'ChiefExecVetos', 'vet_ordid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ord_id' => 'Ordinance ID',
			'ord_title' => 'Title',
			'ord_description' => 'Description',
			'ord_authors_id' => 'Author',
			'ord_file_id' => 'File',
			'ord_creation_date' => 'Creation Date',
			'ord_effectivity_date' => 'Effectivity Date',
			'ord_approval_date' => 'Approval Date',
			'ord_status' => 'Status',
			'ord_approval_status' => 'Approval Status',
			'ord_committee_id' => 'Committee',
			'ord_committee_report_file_id' => 'Committee Report File',
			'ord_voting_id' => 'Voting',
			'ord_ordtype' => 'Ordinance Type',
			'ord_comments_id' => 'Comments',
			'ord_second_reading_action' => 'Second Reading Action',
			'ord_reading_date_from' => 'Starting Reading date',
			'ord_reading_date_to' => 'Deadline of Reading',
			'ord_auth_last' => 'Author Last name',
			'ord_auth_middle' => 'Author Middle name',
			'ord_auth_first' => 'Author First name',
			'comm_id' => 'Committee',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ord_title',$this->ord_title,true);
		$criteria->compare('ord_description',$this->ord_description,true);

		if(!empty($this->ord_creation_date)){
			//date('Y-m-d', strtotime(date('Y-m-d'). ' + 10 days'))
			$date = date("Y-m-d H:m:s",strtotime($this->ord_creation_date)); // get proper Y-m-d
			$criteria->compare('ord_creation_date ', '<= '.$date,true);
		}

		if(!empty($this->ord_approval_date)){
			$date = date("Y-m-d H:m:s",strtotime($this->ord_approval_date)); // get proper Y-m-d
			$criteria->compare('ord_approval_date ', '<= '.$date,true);
		}

		if(!empty($this->ord_auth_last)){
			$criteria->addCondition("ord_authors_id in (select user_id from users where LOWER(user_lastname) like '%".strtolower($this->ord_auth_last)."%')", "AND");
		}

		if(!empty($this->ord_auth_first)){
			$criteria->addCondition("ord_authors_id in (select user_id from users where LOWER(user_firstname) like '%".strtolower($this->ord_auth_first)."%')", "AND");
		}

		if(!empty($this->ord_auth_middle)){
			$criteria->addCondition("ord_authors_id in (select user_id from users where LOWER(user_middlename) like '%".strtolower($this->ord_auth_middle)."%')", "AND");
		}

		if(!empty($this->comm_id)){
			$criteria->addCondition("ord_committee_id in (select lc_id from local_committees where LOWER(lc_name) like '%".strtolower($this->comm_id)."%')", "AND");
		}

		if(!empty($this->ord_status))
			$criteria->compare('LOWER(ord_status)',strtolower($this->ord_status),true);

		if(!empty($this->ord_approval_status))
			$criteria->compare('LOWER(ord_approval_status)',strtolower($this->ord_approval_status),true);


		if(!empty($this->ord_ordtype))
			$criteria->compare('LOWER(ord_ordtype)',strtolower($this->ord_ordtype),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getOrdinancesForStatus($status)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->condition = "ord_status = '$status'";

		if($status == "1st Reading"){
			$criteria->condition = "ord_status = '$status' and ord_committee_id in (
				select lc_id from local_committees where lc_secretary_id = '".Yii::app()->user->getState('id')."'
			)";
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));

	}

	public function getTiedVotings()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->condition = "(ord_status = 'Voting (Final voting)' or ord_status = 'Voting (Veto)') and ord_id in (select vot_ord_id from votings where vot_votstatus = 'Tie')";

		//var_dump($criteria);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));

	}
	public function getVotings()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->condition = "(ord_status = 'Voting (Final voting)' or ord_status = 'Voting (Veto)')";

		//var_dump($criteria);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));

	}

	public function getVotingDeadline(){
		$voting = Votings::model()->findByPk($this->ord_voting_id);

		$date = new DateTime($voting['vot_deadline']);
		$str = $date->format('M d, Y');

		if($voting != NULL)
			return $str;

		return null;

	}
	public function getVotingStart(){
		$voting = Votings::model()->findByPk($this->ord_voting_id);

		$date = new DateTime($voting['vot_start']);
		$str = $date->format('M d, Y');

		if($voting != NULL)
			return $str;

		return null;

	}

	public function getDisproved()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria=new CDbCriteria;
		$criteria->compare('ord_approval_status','Disproved');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));

	}

	public function getApproved()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria=new CDbCriteria;
		$criteria->compare('ord_approval_status','Approved');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));

	}

	public function getVoters($bool){
		$connection = Yii::app()->db;
		$voting = Votings::model()->findByPk($this->ord_voting_id);
		if($bool == 1)
			$vot = 'In favor';
		else if($bool == 0)
			$vot = 'Not in favor';
		else
			$vot = 'Abstain/Absent';

		if($voting != null){
			if($voting->vot_prev_status == null){

				$sql = "SELECT CONCAT(user_lastname, ', ', user_firstname, ' ', user_middlename) as user_name FROM users
						WHERE user_id IN
						(SELECT vot_userid FROM vot_users
							WHERE vot_id = '$this->ord_voting_id' AND vot_vote = '$vot')
						;";
			}
			else
				$sql = "SELECT CONCAT(user_lastname, ', ', user_firstname, ' ', user_middlename) as user_name FROM users
						WHERE user_id IN
						(SELECT vot_userid FROM vot_veto_users
							WHERE vot_id = '$this->ord_voting_id' AND vot_vote = '$vot')
						;";

			$command = $connection->createCommand($sql);

			return $command->queryAll();
		}
		return null;
	}

	public function getVetoVotes($bool){
		$connection = Yii::app()->db;

		$voting = Votings::model()->findByPk($this->ord_voting_id);
		$table = 'vot_veto_users';

		if($bool == 1)
			$sql = "SELECT COUNT(*) FROM $table WHERE vot_id = '$this->ord_voting_id' AND vot_vote = 'In favor';";
		else if($bool == 0)
			$sql = "SELECT COUNT(*) FROM $table WHERE vot_id = '$this->ord_voting_id' AND vot_vote = 'Not in favor';";
			//$sql = "SELECT vot_notinfavor AS count FROM vot_completed WHERE vot_id = '$this->ord_voting_id';";
		else
			$sql = "SELECT COUNT(*) FROM $table WHERE vot_id = '$this->ord_voting_id' AND vot_vote = 'Abstain/Absent';";
			//$sql = "SELECT vot_notinfavor AS count FROM vot_completed WHERE vot_id = '$this->ord_voting_id';";

		$command = $connection->createCommand($sql);
		if($table == 'vot_veto_users')
			return $command->queryAll()[0]['count'];
		return $command->queryAll()[0]['count'];
	}

	public function getVotes($bool){
		$connection = Yii::app()->db;

		$voting = Votings::model()->findByPk($this->ord_voting_id);
		if($voting!=null){
			if($voting->vot_prev_status==null)
				$table = 'vot_users';
			else
				$table = 'vot_veto_users';

			if($bool == 1)
				$sql = "SELECT COUNT(*) FROM $table WHERE vot_id = '$this->ord_voting_id' AND vot_vote = 'In favor';";
			else if($bool == 0)
				$sql = "SELECT COUNT(*) FROM $table WHERE vot_id = '$this->ord_voting_id' AND vot_vote = 'Not in favor';";
				//$sql = "SELECT vot_notinfavor AS count FROM vot_completed WHERE vot_id = '$this->ord_voting_id';";
			else
				$sql = "SELECT COUNT(*) FROM $table WHERE vot_id = '$this->ord_voting_id' AND vot_vote = 'Abstain/Absent';";
				//$sql = "SELECT vot_notinfavor AS count FROM vot_completed WHERE vot_id = '$this->ord_voting_id';";

			$command = $connection->createCommand($sql);
			if($table == 'vot_veto_users')
				return $command->queryAll()[0]['count'].' of veto';
			return $command->queryAll()[0]['count'];
		}
		else return 'N/A';
	}

	public function getAvailableForHearing()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->condition = "ord_status = 'Scheduled for hearing' and ord_id in (select cal_ordid from calendar where cal_eventtype = 'Hearing' and cal_eventdate < '".date('Y-m-d H:m:s')."')";

		//var_dump(date('Y-m-d H:m:s'));
		//var_dump(date('Y-m-d H:m:s'));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getAuthor($id){
		$connection = Yii::app()->db;
		$sql = "SELECT CONCAT(user_lastname, ', ', user_firstname, ' ', user_middlename) AS name FROM users WHERE user_id = (SELECT ord_authors_id FROM ordinances WHERE ord_id = '$id');";

		$command = $connection->createCommand($sql);
		return $command->queryAll()[0]['name'];
	}

	public function getAuthorName($part){
		$connection = Yii::app()->db;
		$sql = "SELECT user_".$part."name AS name FROM users WHERE user_id = (SELECT ord_authors_id FROM ordinances WHERE ord_id = '$this->ord_id');";

		$command = $connection->createCommand($sql);
		//var_dump($command->queryAll());

		return $command->queryAll()[0]['name'];
	}



	public function getCommittee($id){
		if($id != null){
			$connection = Yii::app()->db;
			$sql = "SELECT lc_name FROM local_committees WHERE lc_id = '$id';";

			$command = $connection->createCommand($sql);

			$r = $command->queryAll();

			if(!empty($r))
				return $r[0]['lc_name'];
		}

		return "Not yet set.";
	}

	public function getComments($id){
		$connection = Yii::app()->db;
		$sql = "SELECT * FROM ordinance_comments WHERE ord_id = '$id';";

		$command = $connection->createCommand($sql);

		return $command->queryAll();
	}

	public function assignCommittee($committee_id, $ord_id){
		$connection = Yii::app()->db;
		$sql = "UPDATE ordinances SET ord_committee_id = '$committee_id', ord_status = '1st Reading' WHERE ord_id = '$ord_id';";
		$command = $connection->createCommand($sql);
		$command->queryAll();

		return true;
	}

	public function assignCommitteeReport($committee_file_id, $ord_id){
		$connection = Yii::app()->db;
		$sql = "UPDATE ordinances SET ord_committee_report_file_id = '$committee_file_id', ord_status = '2nd Reading' WHERE ord_id = '$ord_id';";
		$command = $connection->createCommand($sql);
		$command->queryAll();

		return true;
	}

	public function checkProcess($ord_id, $status){
		$connection = Yii::app()->db;
		$sql = "SELECT ord_status FROM ordinances WHERE ord_id = '$ord_id';";
		$command = $connection->createCommand($sql);
		$result = $command->queryAll();

		if($result[0]['ord_status']!=$status)
			return false;
		return true;
	}

	public function correctCommittee($user_id, $committee_id){
		$connection = Yii::app()->db;
		$sql = "SELECT lc_secretary_id FROM local_committees where lc_id = '$committee_id';";
		$command = $connection->createCommand($sql);
		$result = $command->queryAll();

		foreach($result as $user){
			if(in_array($user_id, $user))
				return true;
		}
		return false;
	}

	public function isAllowed($user_id, $action){
		$connection = Yii::app()->db;

		switch($action){
			case "FirstReading":
				$sql = "SELECT sb_id FROM sangguniangbayan WHERE sb_lguposition = 'Chairman' or sb_lguposition = 'Secretary';";
			break;
			case "CommitteeReport":
				$sql = "SELECT lc_secretary_id FROM local_committees;";
			break;
			case "SecondReading":
				$sql = "SELECT sb_id FROM sangguniangbayan WHERE sb_lguposition = 'Chairman' or sb_lguposition = 'Secretary';";
			break;
			case "viewPendingMinutes":
				$sql = "SELECT sb_id FROM sangguniangbayan WHERE sb_lguposition = 'Chairman' or sb_lguposition = 'Secretary';";
			break;
			case "viewAmendments":
				$sql = "SELECT lc_secretary_id FROM local_committees;";
			break;
			case "Votings":
				$sql = "SELECT s.sb_id, p.lgu_id FROM sangguniangbayan s, lgus p where p.lgu_lgutype = 'Presiding Officer';";
			break;
			case "VotingResult":
				$sql = "SELECT lgu_id FROM lgus WHERE lgu_lgutype = 'Presiding Officer';";
			break;
		}
		$command = $connection->createCommand($sql);
		$result = $command->queryAll();


		foreach($result as $user){
			if(in_array($user_id, $user))
				return true;
		}
		return false;
	}

	public function disproveOrdinance(){

		$connection = Yii::app()->db;
		$sql = "UPDATE Ordinances SET
			ord_status = 'Disproved',
			ord_approval_status = 'Disproved'
			WHERE ord_id = '$this->ord_id'";

		$command = $connection->createCommand($sql);
		$command->queryAll();

	}

	public function setOrdinanceNumber($year){

		$connection = Yii::app()->db;
		$sql = "INSERT INTO ordinance_numbers VALUES ($year, ".$this->getOrdinanceNumber_number($year).");";
		$command = $connection->createCommand($sql);
		$result = $command->queryAll();

	}

	public function getOrdinanceNumber_number($year){

		$connection = Yii::app()->db;
		$sql = "SELECT max(ord_no) FROM ordinance_numbers WHERE ord_year = $year;";

		$command = $connection->createCommand($sql);
		$result = $command->queryAll();
		//var_dump($result);
		if($result[0]['max'] == null)
			return '1';
		return $result[0]['max']+1;
	}
	public function getOrdinanceNumber_year($number){

		$connection = Yii::app()->db;
		$sql = "INSERT INTO ordinance_numbers VALUES (".date('Y').", $number);";

		$command = $connection->createCommand($sql);
		$result = $command->queryAll();

	}

	public function getOrdinanceNumber(){

		$connection = Yii::app()->db;
		$sql = "select max(ord_no) from ordinance_numbers where ord_year = '2014';";

		$command = $connection->createCommand($sql);
		$result = $command->queryAll();
		if($result == null)
			return date('Y').'-01';
		else
			return date('Y').'-'.($result[0]['max']+1);
	}

	public function getV($id){

		$connection = Yii::app()->db;
		$sql = "SELECT max(ord_version_no) FROM ordinance_versions where ord_id = '$id';";
		$command = $connection->createCommand($sql);
		$return = $command->queryAll();

		if($return[0]['max'] == null){
			$sql = "INSERT INTO ordinance_versions VALUES (
				'$this->ord_id',
				1,
				'$this->ord_file_id',
				'".date('Y-m-d H:m:s')."'
			);";
			$return = $command->queryAll();
			return '1';
		}
		$temp = $return[0]['max'] +1;
		$sql = "INSERT INTO ordinance_versions VALUES (
				'$this->ord_id',
				$temp,
				'$this->ord_file_id',
				'".date('Y-m-d H:m:s')."'
			);";
		$return = $command->queryAll();
		return $return[0]['max']+1;
	}

	public function revise($newid){
		$version = $this->getV($this->ord_id);
		if($version == NULL) $version = 1;
		else{
			$version = $version;
		}
		$connection = Yii::app()->db;

		$sql = "INSERT INTO ordinance_versions VALUES (
			'$this->ord_id',
			$version,
			'$this->ord_file_id',
			'".date('Y-m-d H:m:s')."'
		);";
		$command = $connection->createCommand($sql);
		$command->queryAll();

		$sql = "UPDATE ordinances
			SET ord_file_id = '$newid'
			WHERE ord_id='$this->ord_id'
		;";
		$command = $connection->createCommand($sql);
		$command->queryAll();
		$sql = "UPDATE ordinances
			SET ord_status = '3rd Reading'
			WHERE ord_id='$this->ord_id'
		;";
		$command = $connection->createCommand($sql);
		$command->queryAll();

	}
	public function scheduleHearing($data){
		$date = new dateTime();

		$connection = Yii::app()->db;
		$sql = "UPDATE Ordinances SET
			ord_status = 'Scheduled for hearing'
			WHERE ord_id = '$this->ord_id'";

		$command = $connection->createCommand($sql);
		$command->queryAll();

		$date = new DateTime($data['ord_date']);
		$time_a = new DateTime($data['ord_hearing_time_from']);
		$time_b = new DateTime($data['ord_hearing_time_to']);

		//CREATE EVENT FOR CALENDAR
		$event = new Calendar();
		$event->setAttributes(array(
			'cal_eventid' => uniqid('ss_', true),
			'cal_eventtitle' => 'Hearing for: '.$this->ord_title,
			'cal_ordid' => $this->ord_id,
			'cal_eventcreated' => $date->format('Y-m-d H:i:s'),
			'cal_eventdispdate' => $data['ord_date'],
			'cal_eventtype' => 'Hearing',
			'cal_eventcontent' => 'A public hearing will be held at '.$data['ord_hearing_venue'].' on '.$date->format('M d, Y').' for the approval of '.$this->ord_title.' for Third reading. ',
			'cal_eventdate' => $data['ord_date'],
			'cal_eventauthorid' => Yii::app()->user->getState('id'),
			'cal_eventtime_from' => $time_a->format("H:m:s"),
			'cal_eventtime_to' => $time_b->format("H:m:s")
		));

		//POST ANNOUNCEMENT
		$announcement = new Announcements('hearing');
		$announcement->setScenario('hearing');
		$announcement->setAttribute('ann_id', uniqid('ss_', true));
		$announcement->setAttribute('ann_body',
			'A public hearing will be held at '
			.$data['ord_hearing_venue'].
			' on '
			.$date->format('M d, Y').
			' ('.$time_a->format("H:m:s").' - '.$time_b->format("H:m:s").')'.
			' for the approval of '.$this->ord_title.' for Third reading.');
		$announcement->setAttribute('ann_author', Yii::app()->user->getState('id'));
		$announcement->setAttribute('ann_creation_date', date('Y-m-d H:m:s'));
		$announcement->setAttribute('ann_title', 'Hearing for Ordinance: '.$this->ord_title);

		if($event->save() && $announcement->save())
			return true;
		return false;
	}

	public function saveMinutes($file_id){
		$connection = Yii::app()->db;
		$sql = "INSERT INTO ordinance_minutes VALUES(
			'$this->ord_id',
			'$file_id',
			'".date('Y-m-d H:m:s')."'
		)";

		$command = $connection->createCommand($sql);
		$command->queryAll();
		$sql = "UPDATE ordinances SET
			ord_status = 'Waiting for Committee Amendments'
			WHERE ord_id = '$this->ord_id'
		;";

		$command = $connection->createCommand($sql);
		$command->queryAll();
	}


	public function get_minutes($ord_id){
		$connection = Yii::app()->db;
		$sql = "SELECT ord_minutes_file_id AS id
			FROM ordinance_minutes
			WHERE ord_id = '$ord_id'
		;";

		$command = $connection->createCommand($sql);

		$result = $command->queryAll();

		if($result != null)
			return $command->queryAll()[0]['id'];
		return null;
	}
	public function scheduleVoting($date_from, $date_to, $ord_id){

		//add voting details
		$voting = new Votings();
		$v_id = uniqid('ss_', true);
		$voting->setAttributes(array(
			    'vot_id' => $v_id,
				'vot_title' => 'Voting: '.$this->ord_title,
				'vot_description' =>  'Voting for: '.$this->ord_title.' ('.$this->ord_status.')',
				'vot_votstatus' => 'Ongoing',
				'vot_start' => $date_from,
				'vot_deadline' => $date_to,
				'vot_ord_id' => $ord_id
		));

		$connection = Yii::app()->db;
		$sql = "UPDATE Ordinances SET
			ord_status = 'Voting (Final voting)',
			ord_voting_id = '$v_id'
			WHERE ord_id = '$this->ord_id'";
		$command = $connection->createCommand($sql);
		$result = $command->queryAll();

		//add event to calendar
		$event = new Calendar();
		$event->setAttributes(array(
			'cal_eventid' => uniqid('ss_', true),
			'cal_eventtitle' => 'Voting for (Third Reading): ".$this->ord_title."',
			'cal_ordid'	=> $this->ord_id,
			'cal_eventcreated' => date('Y-m-d H:i:s'),
			'cal_eventdispdate' => $date_to,
			'cal_eventtype' => 'Voting',
			'cal_eventcontent' => 'Proposed ordinance: '.$this->ord_title.' will undergo Third Reading between dates $date_from and $date_to. The office of Sangguniang Bayan can vote in that time.',
			'cal_eventdate' => $date_from,
			'cal_eventauthorid' => $this->ord_authors_id,
			'cal_eventtime_from' => null,
			'cal_eventtime_to' => null
		));


		$date_str_from = new DateTime($date_from);
		$date_str_to = new DateTime($date_to);
		//POST ANNOUNCEMENT
		$announcement = new Announcements('hearing');
		$announcement->setAttribute('ann_id', uniqid('ss_', true));
		$announcement->setAttribute('ann_body',
			'Proposed ordinance: '.$this->ord_title.' will undergo Third Reading between dates '.$date_str_from->format('M d, Y').' and '.$date_str_to->format('M d, Y').'. The office of Sangguniang Bayan can vote at that time.');
		$announcement->setAttribute('ann_author', $this->ord_authors_id);
		$announcement->setAttribute('ann_creation_date', date('Y-m-d H:m:s'));
		$announcement->setAttribute('ann_title', 'Third Reading: '.$this->ord_title);

		if($announcement->save() && $event->save() && $voting->save())
			return true;
	}

	public function scheduleVetoVoting($date_from, $date_to, $ord_id){

		//add voting details
		$voting = new Votings();
		$v_id = uniqid('ss_', true);
		$voting->setAttributes(array(
			    'vot_id' => $v_id,
				'vot_title' => 'Veto Voting: '.$this->ord_title,
				'vot_description' =>  'Veto Voting for: '.$this->ord_title.' ('.$this->ord_status.')',
				'vot_votstatus' => 'Ongoing',
				'vot_start' => $date_from,
				'vot_deadline' => $date_to,
				'vot_ord_id' => $ord_id,
				'vot_prev_status' => $this->ord_voting_id
		));

		//print_r($voting);

		$connection = Yii::app()->db;
		$sql = "UPDATE Ordinances SET
			ord_status = 'Voting (Veto)',
			ord_voting_id = '$v_id'
			WHERE ord_id = '$this->ord_id'";
		$command = $connection->createCommand($sql);
		$result = $command->queryAll();

		//add event to calendar
		$event = new Calendar();
		$event->setAttributes(array(
			'cal_eventid' => uniqid('ss_', true),
			'cal_eventtitle' => 'Voting for (Veto): ".$this->ord_title."',
			'cal_ordid'	=> $this->ord_id,
			'cal_eventcreated' => date('Y-m-d H:i:s'),
			'cal_eventdispdate' => $date_to,
			'cal_eventtype' => 'Voting',
			'cal_eventcontent' => 'Proposed ordinance: '.$this->ord_title.' has been vetoed by Chief Executive. Members of the sangguniang bayan may override this veto from $date_from and $date_to. Otherwise, the ordinance will be considered as rejected.',
			'cal_eventdate' => $date_from,
			'cal_eventauthorid' => $this->ord_authors_id,
			'cal_eventtime_from' => null,
			'cal_eventtime_to' => null
		));


		$date_str_from = new DateTime($date_from);
		$date_str_to = new DateTime($date_to);
		//POST ANNOUNCEMENT
		$announcement = new Announcements();
		$announcement->setAttribute('ann_id', uniqid('ss_', true));
		$announcement->setAttribute('ann_body',
			'Proposed ordinance: '.$this->ord_title.' has been vetoed by Chief Executive. Members of the sangguniang bayan may override this veto from '.$date_from.' and '.$date_to.'. Otherwise, the ordinance will be considered as rejected.');
		$announcement->setAttribute('ann_author', $this->ord_authors_id);
		$announcement->setAttribute('ann_creation_date', date('Y-m-d H:m:s'));
		$announcement->setAttribute('ann_title', 'Veto: '.$this->ord_title);

		if($announcement->save() && $event->save() && $voting->save())
			return true;
	}

	public function isReadyForVoting(){

		$voting = new Votings();
		$voting = Votings::model()->findByPk($this->ord_voting_id);

		if($voting->vot_start <= date('Y-m-d H:m:s') && date('Y-m-d H:m:s') <= $voting->vot_deadline)
			return true;
		return false;
	}

	public function registerVetoVote($vote){
		$voting = new Votings();
		$voting = Votings::model()->findByPk($this->ord_voting_id);

		$sql =
			"INSERT INTO vot_veto_users VALUES(
			'$voting->vot_id',
			'".Yii::app()->user->getState('id')."',
			'$vote'
			);
		";

		$connection = Yii::app()->db;
		$command = $connection->createCommand($sql);
		$result = $command->queryAll();
	}

	public function registerVote($vote){
		$voting = new Votings();
		$voting = Votings::model()->findByPk($this->ord_voting_id);

		$sql =
			"INSERT INTO vot_users VALUES(
			'$voting->vot_id',
			'".Yii::app()->user->getState('id')."',
			'$vote'
			);
		";

		$connection = Yii::app()->db;
		$command = $connection->createCommand($sql);
		$result = $command->queryAll();
	}

	public function alreadyVoted(){
		if($this->ord_status == 'Voting (Final voting)')
			$sql =" SELECT vot_userid FROM vot_users WHERE vot_id = '$this->ord_voting_id';";
		else if($this->ord_status == 'Voting (Veto)')
			$sql =" SELECT vot_userid FROM vot_veto_users WHERE vot_id = '$this->ord_voting_id';";

		$connection = Yii::app()->db;
		$command = $connection->createCommand($sql);
		$result = $command->queryAll();
		if($result != NULL){
			foreach($result as $voter){
				if(in_array(Yii::app()->user->getState('id'), $voter))
					return true;
			}
		}
		return false;

	}

	public function approve($e_date){

		$connection = Yii::app()->db;

		$sql = "UPDATE ordinances SET
			ord_status = 'Approved and Published',
			ord_approval_status = 'Approved',
			ord_effectivity_date = '$e_date',
			ord_approval_date = '".date('Y-m-d H:m:s')."'
			WHERE ord_id = '$this->ord_id'
			;";

		$command = $connection->createCommand($sql);

		$result = $command->queryAll();

		$announcement = new Announcements();
		$announcement->setAttribute('ann_id', uniqid('ss_', true));
		$announcement->setAttribute('ann_body', "The ordinance proposal entitled '$this->ord_title' by ".$this->getAuthor($this->ord_id)." was recently approved. The ordinance shall take effect more than ten (10) days after its publication.");
		$announcement->setAttribute('ann_author', Yii::app()->user->getState('id'));
		$announcement->setAttribute('ann_title', "Newly approved ordinance: $this->ord_title");
		$announcement->setAttribute('ann_creation_date', date('Y-m-d'));

		$announcement->save();

		return true;
	}

	public function generateResults(){

		$connection = Yii::app()->db;

		$sql = "SELECT COUNT(*) FROM sangguniangbayan;";

		$command = $connection->createCommand($sql);
		$result = $command->queryAll();

		$sb_count = $result[0]['count'];

		$sql = "SELECT sb_id FROM sangguniangbayan;";

		$command = $connection->createCommand($sql);
		$sb_members = $command->queryAll(false);

		$sql = "SELECT vot_userid FROM vot_users WHERE vot_id = '$this->ord_voting_id';";

		$command = $connection->createCommand($sql);
		$voters = $command->queryAll(false);

		//var_dump($sb_members);
		$temp = array();
		foreach($voters as $voter)
			array_push($temp, $voter[0]);

		$voters = $temp;

		$temp = array();
		foreach($sb_members as $member)
			array_push($temp, $member[0]);

		$sb_members = $temp;

		$sql = "SELECT COUNT(*) FROM vot_users WHERE vot_vote = 'In favor' and vot_id = '$this->ord_voting_id';";

		$command = $connection->createCommand($sql);
		$result = $command->queryAll();

		//var_dump($result);
		$positive_count = $result[0]['count'];

		$sql = "SELECT COUNT(*) FROM vot_users WHERE vot_vote = 'Not in favor' and vot_id = '$this->ord_voting_id';";

		$command = $connection->createCommand($sql);
		$result = $command->queryAll();

		//var_dump($result);
		$negative_count = $result[0]['count'];

		//MAJORITY
		if($negative_count + $positive_count > ($sb_count/2)){

			$found = false;
			for($i=0; $i<sizeof($sb_members); $i++){

				$found = false;

				for($j=0; $j<sizeof($voters); $j++){
					if($sb_members[$i] == $voters[$j])
						$found = true;
				}

				if($found == false){
					$sql = "INSERT INTO vot_users VALUES (
						'$this->ord_voting_id',
						'".$sb_members[$i]."',
						'Abstain/Absent'
					);";

					var_dump($sql);
					$command = $connection->createCommand($sql);
					$command->queryAll();
				}
			}

			if($negative_count > $positive_count) $res = 'Defeat';
			else if($negative_count < $positive_count) $res = 'Win';
			else if($negative_count == $positive_count) $res = 'Tie';
			$insert_count = true;
			if($res == 'Win'){

				$sql = "DELETE FROM vot_ongoing WHERE vot_id = '$this->ord_voting_id';";

				$command = $connection->createCommand($sql);
				$result = $command->queryAll();
				//var_dump($sql);

				$sql = "UPDATE ordinances SET
					ord_status = 'Forwarded to Chief Executive'
					WHERE ord_id = '$this->ord_id'
					;";

				$command = $connection->createCommand($sql);

				$result = $command->queryAll();

				/*
				$announcement = new Announcements();
				$announcement->setAttribute('ann_id', uniqid('ss_', true));
				$announcement->setAttribute('ann_body', "The ordinance proposal entitled '$this->ord_title' by ".$this->getAuthor($this->ord_id)." was recently approved. The ordinance shall take effect ten (10) days after its publication.");
				$announcement->setAttribute('ann_author', Yii::app()->user->getState('id'));
				$announcement->setAttribute('ann_title', "Newly approved ordinance: $this->ord_title");
				$announcement->setAttribute('ann_creation_date', date('Y-m-d'));

				$announcement->save();
				*/
				//var_dump($announcement);

				$sql = "UPDATE votings SET
					vot_votstatus = 'Completed'
					WHERE vot_id = '$this->ord_voting_id'
					;";

				$command = $connection->createCommand($sql);
				$result = $command->queryAll();
				//var_dump($sql);
			}
			else if($res == "Defeat"){
				$sql = "DELETE FROM vot_ongoing WHERE vot_id = '$this->ord_voting_id';";

				$command = $connection->createCommand($sql);
				$result = $command->queryAll();
				//var_dump($sql);

				$sql = "UPDATE ordinances SET
					ord_status = 'Disproved',
					ord_approval_status = 'Disproved'
					WHERE ord_id = '$this->ord_id'
					;";

				$command = $connection->createCommand($sql);
				//var_dump($sql);
				$result = $command->queryAll();

				$sql = "UPDATE votings SET
					vot_votstatus = 'Completed'
					WHERE vot_id = '$this->ord_voting_id'
					;";

				$command = $connection->createCommand($sql);
				$result = $command->queryAll();
				//var_dump($sql);
			}
			else if($res == "Tie"){
				$sql = "DELETE FROM vot_ongoing WHERE vot_id = '$this->ord_voting_id';";

				$command = $connection->createCommand($sql);
				$result = $command->queryAll();

				$sql = "UPDATE votings SET
					vot_votstatus = 'Tie'
					WHERE vot_id = '$this->ord_voting_id'
					;";

				$command = $connection->createCommand($sql);
				$result = $command->queryAll();
				$insert_count = false;
			}
			if($insert_count == true){
				$sql = "INSERT INTO vot_completed VALUES(
					'$this->ord_voting_id',
					$positive_count,
					$negative_count,
					'$res'
				);";

				$command = $connection->createCommand($sql);
				$result = $command->queryAll();
			}
			return true;
		}
		return false;
	}


	public function generateVetoResults(){

		$connection = Yii::app()->db;

		$sql = "SELECT COUNT(*) FROM sangguniangbayan;";

		$command = $connection->createCommand($sql);
		$result = $command->queryAll();

		$sb_count = $result[0]['count'];

		$sql = "SELECT sb_id FROM sangguniangbayan;";

		$command = $connection->createCommand($sql);
		$sb_members = $command->queryAll(false);

		$sql = "SELECT vot_userid FROM vot_veto_users WHERE vot_id = '$this->ord_voting_id';";

		$command = $connection->createCommand($sql);
		$voters = $command->queryAll(false);

		//var_dump($sb_members);
		$temp = array();
		foreach($voters as $voter)
			array_push($temp, $voter[0]);

		$voters = $temp;

		$temp = array();
		foreach($sb_members as $member)
			array_push($temp, $member[0]);

		$sb_members = $temp;

		$sql = "SELECT COUNT(*) FROM vot_veto_users WHERE vot_vote = 'In favor' and vot_id = '$this->ord_voting_id';";

		$command = $connection->createCommand($sql);
		$result = $command->queryAll();

		//var_dump($result);
		$positive_count = $result[0]['count'];

		$sql = "SELECT COUNT(*) FROM vot_veto_users WHERE vot_vote = 'Not in favor' and vot_id = '$this->ord_voting_id';";

		$command = $connection->createCommand($sql);
		$result = $command->queryAll();

		//var_dump($result);
		$negative_count = $result[0]['count'];

		//MAJORITY
		if($negative_count + $positive_count >= (($sb_count*2)/3)){

			if($negative_count >= ($sb_count*2)/3) $res = 'Win';
			else $res = 'Defeat';
			$insert_count = true;


			$found = false;
			for($i=0; $i<sizeof($sb_members); $i++){

				$found = false;

				for($j=0; $j<sizeof($voters); $j++){
					if($sb_members[$i] == $voters[$j])
						$found = true;
				}

				if($found == false){
					$sql = "INSERT INTO vot_veto_users VALUES (
						'$this->ord_voting_id',
						'".$sb_members[$i]."',
						'Abstain/Absent'
					);";

					var_dump($sql);
					$command = $connection->createCommand($sql);
					$command->queryAll();
				}
			}

			if($res == 'Win'){

				$sql = "DELETE FROM vot_ongoing WHERE vot_id = '$this->ord_voting_id';";

				$command = $connection->createCommand($sql);
				$result = $command->queryAll();

				$voting = Votings::model()->findByPk($this->ord_voting_id);
				$prev = $voting->vot_prev_status;

				$this->approve(date('Y-m-d', strtotime(date('Y-m-d'). ' + 10 days')));

				$sql = "UPDATE votings SET
					vot_votstatus = 'Completed'
					WHERE vot_id = '$this->ord_voting_id'
					;";

				$command = $connection->createCommand($sql);
				$result = $command->queryAll();
				//var_dump($sql);
			}
			else if($res == "Defeat"){
				$sql = "DELETE FROM vot_ongoing WHERE vot_id = '$this->ord_voting_id';";

				$command = $connection->createCommand($sql);
				$result = $command->queryAll();
				//var_dump($sql);

				$sql = "UPDATE ordinances SET
					ord_status = 'Disproved',
					ord_approval_status = 'Disproved'
					WHERE ord_id = '$this->ord_id'
					;";

				$command = $connection->createCommand($sql);
				//var_dump($sql);
				$result = $command->queryAll();

				$sql = "UPDATE votings SET
					vot_votstatus = 'Completed'
					WHERE vot_id = '$this->ord_voting_id'
					;";

				$command = $connection->createCommand($sql);
				$result = $command->queryAll();
				//var_dump($sql);
			}
			else if($res == "Tie"){
				$sql = "DELETE FROM vot_ongoing WHERE vot_id = '$this->ord_voting_id';";

				$command = $connection->createCommand($sql);
				$result = $command->queryAll();

				$sql = "UPDATE votings SET
					vot_votstatus = 'Tie'
					WHERE vot_id = '$this->ord_voting_id'
					;";

				$command = $connection->createCommand($sql);
				$result = $command->queryAll();
				$insert_count = false;
			}
			if($insert_count == true){
				$sql = "INSERT INTO vot_completed VALUES(
					'$this->ord_voting_id',
					$positive_count,
					$negative_count,
					'$res'
				);";

				$command = $connection->createCommand($sql);
				$result = $command->queryAll();
			}
			return true;
		}
		return false;
	}

	public function reschedule($new_deadline){
		$connection = Yii::app()->db;

		$sql = "UPDATE votings SET
			vot_deadline = '$new_deadline'
			;";

		$command = $connection->createCommand($sql);
		$result = $command->queryAll();

		$date = new dateTime($new_deadline);

		$announcement = new Announcements();
		$announcement->setAttribute('ann_id', uniqid('ss_', true));
		$announcement->setAttribute('ann_body', "Third reading and voting for ordinance '$this->ord_title' by ".$this->getAuthor($this->ord_id)." was extended until ".$date->format('M d, Y').".");
		$announcement->setAttribute('ann_author', Yii::app()->user->getState('id'));
		$announcement->setAttribute('ann_title', "Extended voting: $this->ord_title");
		$announcement->setAttribute('ann_creation_date', date('Y-m-d'));

		$announcement->save();
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Ordinances the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
