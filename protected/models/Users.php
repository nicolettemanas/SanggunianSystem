<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $user_id
 * @property string $user_username
 * @property string $user_password
 * @property string $user_email
 * @property string $user_lastname
 * @property string $user_firstname
 * @property string $user_middlename
 * @property string $user_usertype
 *
 * The followings are the available model relations:
 * @property Lgus[] $lguses
 * @property Sangguniangbayan[] $sangguniangbayans
 * @property Localcommittee[] $localcommittees
 * @property Presidingvotes[] $presidingvotes
 * @property Administrators[] $administrators
 * @property Announcements[] $announcements
 * @property OrdAuthors[] $ordAuthors
 */
class Users extends CActiveRecord
{
	public $new_password;
	public $user_password_repeat;
	public $curr_password;
	public $password_change;
	public $getLGUs = "SELECT concat(user_lastname, ', ', user_firstname, ' ', user_middlename) as user_lastname, user_id from users where user_usertype = 'LGU'";

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	public function getOrdinances($vot){
		$connection = Yii::app()->db;
		if($vot == 1)
			$vote = 'In favor';
		else if($vot == 0)
			$vote = 'Not in favor';
		else
			$vote = 'Abstain/Absent';

		$sql = "select concat(ord_title, '(', ord_approval_status, ')') as ord_title from ordinances where ord_id in (select vot_ord_id from votings where vot_votstatus = 'Completed' and vot_id in (select vot_id from vot_users where vot_userid = '$this->user_id' and vot_vote = '$vote'));";

		$command = $connection->createCommand($sql);
		return $command->queryAll();
	}


	public function getVotings($vot){
		$connection = Yii::app()->db;
		if($vot == 1)
			$vote = 'In favor';
		else if($vot == 0)
			$vote = 'Not in favor';
		else
			$vote = 'Abstain/Absent';

		$sql = "select count(*) from ordinances where ord_id in (select vot_ord_id from votings where vot_votstatus = 'Completed' and vot_id in (select vot_id from vot_users where vot_userid = '$this->user_id' and vot_vote = '$vote'));";

		$command = $connection->createCommand($sql);
		return $command->queryAll()[0]['count'];
	}

	public function getName(){
		$connection = Yii::app()->db;
		$sql = "SELECT concat(user_lastname, ', ', user_firstname, ' ', user_middlename) as name from users where user_id = '$this->user_id'";
		$command = $connection->createCommand($sql);
		return $command->queryAll()[0]['name'];
	}
	
	public function removeLGURoles(){
		$connection = Yii::app()->db;

		$sql = "UPDATE users SET user_usertype = 'General Public' WHERE user_id = '$this->user_id'";
		$command = $connection->createCommand($sql);
		$command->queryAll();
	
		$tables = array('administrators'=>'admn_id', 'lc_members'=>'lc_id', 'lgus'=>'lgu_id', 'local_committees'=>'lc_chariman_id', 'local_committees'=>'lc_secretary_id', 'sangguniangbayan'=>'sb_id');
		
		foreach($tables as $k => $v){
			$sql = "DELETE FROM ".$k." where ".$v." = '$this->user_id'";
			$command = $connection->createCommand($sql);
			$command->queryAll();
		}		
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, user_username, user_password, user_password_repeat, user_email, user_lastname, user_firstname, user_middlename, user_usertype', 'required', 'on' => 'create'),
			array('user_id, user_username, user_email, user_lastname, user_firstname, user_middlename, user_usertype', 'required', 'on' => 'update'),
			array('user_id, user_username, user_password, user_email, user_lastname, user_firstname, user_middlename', 'length', 'max'=>64, 'min'=>2),
			array('user_password', 'compare', 'on' => 'create'),
			array('user_email', 'email'),
			array('user_id, user_username, user_email', 'unique'),
			array('user_password_repeat', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_username, user_email, user_lastname, user_firstname, user_middlename, user_usertype', 'safe', 'on'=>'search'),
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
			'lguses' => array(self::HAS_MANY, 'Lgus', 'lgu_id'),
			'sangguniangbayans' => array(self::HAS_MANY, 'Sangguniangbayan', 'sb_id'),
			'localcommittees' => array(self::HAS_MANY, 'Localcommittee', 'lc_id'),
			'presidingvotes' => array(self::HAS_MANY, 'Presidingvotes', 'po_id'),
			'administrators' => array(self::HAS_MANY, 'Administrators', 'admn_id'),
			'announcements' => array(self::HAS_MANY, 'Announcements', 'ann_author'),
			'ordAuthors' => array(self::HAS_MANY, 'OrdAuthors', 'ord_author'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{

		return array(
			'user_id' => 'User',
			'user_username' => 'User Username',
			'user_password' => 'User Password',
			'user_email' => 'User Email',
			'user_lastname' => 'User Lastname',
			'user_firstname' => 'User Firstname',
			'user_middlename' => 'User Middlename',
			'user_usertype' => 'User Usertype',
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('user_username',$this->user_username,true);
		$criteria->compare('user_email',$this->user_email,true);
		$criteria->compare('user_lastname',$this->user_lastname,true);
		$criteria->compare('user_middlename',$this->user_middlename,true);
		$criteria->compare('user_firstname',$this->user_firstname,true);
		$criteria->compare('user_usertype',$this->user_usertype,true);

		//$criteria->compare('user_usertype',$this->user_usertype,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getSangguniangBayan()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->condition = 'user_id in (select sb_id from sangguniangbayan)';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function isSbSec($id){
		$connection = Yii::app()->db;
		$sql = "Select sb_id from sangguniangbayan where sb_lguposition = 'Secretary';";

		$command = $connection->createCommand($sql);

		$return = $command->queryAll();

		if($return != null)
			return $command->queryAll()[0]['sb_id']==$id;
		return false;
	}

	public function isCommitteeSec($id){
		$connection = Yii::app()->db;
		$sql = "Select lc_secretary_id from local_committees;";

		$command = $connection->createCommand($sql);
		$sec = $command->queryAll();
		foreach($sec as $s){
			if(in_array($id, $s))
				return true;
		}
		return false;
	}

	public function isSbMember($id){
		$connection = Yii::app()->db;
		$sql = "Select sb_id from sangguniangbayan;";

		$command = $connection->createCommand($sql);
		$sec = $command->queryAll();
		foreach($sec as $s){
			if(in_array($id, $s))
				return true;
		}
		return false;
	}

	public function setChiefExecutive($user_id){
		$connection = Yii::app()->db;
		
		$sql = "SELECT lgu_id FROM lgus WHERE lgu_lgutype = 'Presiding Officer';";

		$command = $connection->createCommand($sql);
		$po = $command->queryAll();
		
		if(!empty($po))
			if($po[0]['lgu_id'] == $user_id)
				return false;
		
		$sql = "DELETE FROM lgus WHERE lgu_lgutype = 'Chief Executive';";

		$command = $connection->createCommand($sql);
		$command->queryAll();

	
		$sql = "INSERT INTO lgus VALUES ('$user_id', 'Chief Executive');";

		$command = $connection->createCommand($sql);
		$command->queryAll();

		$sql = "DELETE FROM sangguniangbayan WHERE sb_id = '$user_id';";
		$command = $connection->createCommand($sql);
		$command->queryAll();

		$sql = "DELETE FROM local_committees WHERE lc_id = '$user_id';";
		$command = $connection->createCommand($sql);
		$command->queryAll();

		return true;		
	}


	public function setPresidingOfficer($user_id){
		$connection = Yii::app()->db;
		
		$sql = "SELECT lgu_id FROM lgus WHERE lgu_lgutype = 'Chief Executive';";

		$command = $connection->createCommand($sql);
		$ce = $command->queryAll();
		
		if(!empty($ce))
			if($ce[0]['lgu_id'] == $user_id)
				return false;

		$sql = "DELETE FROM lgus WHERE lgu_lgutype = 'Presiding Officer';";

		$command = $connection->createCommand($sql);
		$command->queryAll();
		
		$sql = "INSERT INTO lgus VALUES ('$user_id', 'Presiding Officer');";

		$command = $connection->createCommand($sql);
		$command->queryAll();

		$sql = "DELETE FROM sangguniangbayan WHERE sb_id = '$user_id';";
		$command = $connection->createCommand($sql);
		$command->queryAll();

		$sql = "DELETE FROM local_committees WHERE lc_id = '$user_id';";
		$command = $connection->createCommand($sql);
		$command->queryAll();
		
		return true;
	}


	public function isChiefExecutive(){
		$sql =
			"SELECT lgu_id FROM lgus WHERE lgu_lgutype = 'Chief Executive';
		";

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

	public function isAdministrator(){
		$sql =
			"SELECT user_id FROM users WHERE user_usertype = 'Administrator';
		";

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

	public function isPresidingOfficer(){
		$sql =
			"SELECT lgu_id FROM lgus WHERE lgu_lgutype = 'Presiding Officer';
		";

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

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
