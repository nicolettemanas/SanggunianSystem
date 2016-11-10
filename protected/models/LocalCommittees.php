<?php

/**
 * This is the model class for table "local_committees".
 *
 * The followings are the available columns in table 'local_committees':
 * @property string $lc_id
 * @property string $lc_name
 * @property string $lc_chariman_id
 * @property string $lc_secretary_id
 * @property string $lc_members_id
 */
class LocalCommittees extends CActiveRecord
{
	public $lc_members;
	public $getLocalCommittees = "Select lc_name, lc_id from local_committees;";
	public $sql = "select concat(user_lastname, ', ', user_firstname, ' ', user_middlename) as user_lastname, user_id from users where user_usertype = 'LGU' and user_id not in (select lc_chariman_id from local_committees union select lc_secretary_id from local_committees union select sb_id from sangguniangbayan where sb_lguposition = 'Chairman' and sb_lguposition = 'Secretary');";
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'local_committees';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lc_id, lc_name, lc_chariman_id', 'required'),
			array('lc_id, lc_name, lc_chariman_id, lc_secretary_id', 'unique'),
			array('lc_id, lc_name, lc_chariman_id, lc_secretary_id', 'length', 'max'=>64),
			array('lc_members', 'search'),
			array('lc_chariman_id', 'compare', 'compareAttribute'=>'lc_secretary_id', 'operator'=>'!=', 'message'=>'Chairman should not be the same as the Secretary'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lc_name', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lc_id' => 'Lc ID',
			'lc_name' => 'Local Committe Name',
			'lc_chariman_id' => 'Chariman',
			'lc_secretary_id' => 'Secretary',
			'lc_members' => 'Members',
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

		$criteria->compare('lc_name',$this->lc_name,true);
		$criteria->compare('lc_chariman_id',$this->lc_chariman_id,true);
		$criteria->compare('lc_secretary_id',$this->lc_secretary_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * saves members of local committees
	*/
	
	public function saveMembers($id, $members_id){
		
		$connection=Yii::app()->db;
		
		if($members_id!=null){
			foreach($members_id as $member){
				$sql = "INSERT INTO lc_members values('$id', '$member');";
				$command = $connection->createCommand($sql);
				$members=$command->queryAll();
			}
		}
	}
	
	public function getUser($id){
		$connection=Yii::app()->db;
		$sql = "SELECT CONCAT(user_lastname, ', ', user_firstname, ' ', user_middlename) as name from users where user_id = '$id';";
		$command = $connection->createCommand($sql);
		
		return $command->queryAll()[0]['name'];		
	}
	
	public function loadMembers($model){
		$connection=Yii::app()->db;
		$members = array();
		
		
		if($model->lc_chariman_id != null){
			$sql = "SELECT concat(user_lastname, ', ', user_firstname, ' ', user_middlename) as name FROM users where user_id = '$model->lc_chariman_id';";
			$command = $connection->createCommand($sql);
			$result=$command->queryAll();
			array_push($members, array('chairman_name'=>$result[0]['name']));
		}
		if($model->lc_secretary_id != null){
			$sql = "SELECT concat(user_lastname, ', ', user_firstname, ' ', user_middlename) as name FROM users where user_id = '$model->lc_secretary_id';";
			$command = $connection->createCommand($sql);
			$result=$command->queryAll();
			array_push($members, array('secretary_name'=>$result[0]['name']));
		}
		
		$sql = "SELECT concat(user_lastname, ', ', user_firstname, ' ', user_middlename) as name FROM users where user_id IN (SELECT lc_member FROM lc_members where lc_id = '$model->lc_id');";
		$command = $connection->createCommand($sql);
		$result=$command->queryAll();
		array_push($members, array('members'=>$result));
		return $members;
	}
	
	public function getMembers($id){
		$connection=Yii::app()->db;
		$sql = "SELECT concat(user_lastname, ', ', user_firstname, ' ', user_middlename) as value FROM users where user_id IN (SELECT lc_member FROM lc_members where lc_id = '$id');";
		$command = $connection->createCommand($sql);
		$result=$command->queryAll();
		
		return $result;
		//array_push($members, array('members'=>$result));
		//return $members;
	}
	
	public function clearUsers($members){
		$connection=Yii::app()->db;
		
		$sql = "DELETE FROM lc_members WHERE lc_id in ('$this->lc_chariman_id', '$this->lc_secretary_id');";
		$command = $connection->createCommand($sql);
		$command->queryAll();
		
		$sql = "DELETE FROM local_committees WHERE lc_id in ('$this->lc_chariman_id', '$this->lc_secretary_id');";
		$command = $connection->createCommand($sql);
		$command->queryAll();
		
		$sql = "DELETE FROM sangguniangbayan WHERE sb_id in ('$this->lc_chariman_id', '$this->lc_secretary_id');";
		$command = $connection->createCommand($sql);
		$command->queryAll();
		
		if($members != null){
			$member_str = "(";
			$i = 0;
			foreach($members as $member){
				if($i==0){
					$member_str .= "'$member'";
					$i++;
				}
				else
					$member_str .= ", '$member'";
			}
			$member_str .= ")";
		
			$sql = "DELETE FROM lc_members WHERE lc_id in $member_str;";
			$command = $connection->createCommand($sql);
			$command->queryAll();
		
			$sql = "DELETE FROM local_committees WHERE lc_id in $member_str;";
			$command = $connection->createCommand($sql);
			$command->queryAll();
		
			$sql = "DELETE FROM sangguniangbayan WHERE sb_id in $member_str;";
			$command = $connection->createCommand($sql);
			$command->queryAll();
		
		}
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LocalCommittees the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
