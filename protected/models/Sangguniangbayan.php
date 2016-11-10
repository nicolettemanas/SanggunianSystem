<?php

/**
 * This is the model class for table "sangguniangbayan".
 *
 * The followings are the available columns in table 'sangguniangbayan':
 * @property string $sb_id
 * @property string $sb_lguposition
 *
 * The followings are the available model relations:
 * @property Users $sb
 */
class Sangguniangbayan extends CActiveRecord
{

	public $sql = "select concat(user_lastname, ', ', user_firstname, ' ', user_middlename) as user_lastname, user_id from users where user_id not in (select lc_chariman_id from local_committees union select lc_secretary_id from local_committees union select lc_member from lc_members union select sb_id from sangguniangbayan) and user_usertype = 'LGU';";
	public $sql_update = "select concat(user_lastname, ', ', user_firstname, ' ', user_middlename) as user_lastname, user_id from users where user_id in (select sb_id from sangguniangbayan) and user_usertype = 'LGU';";
	
	public $hasVoted;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sangguniangbayan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sb_id, sb_lguposition', 'required'),
			array('sb_id', 'unique'),
			array('sb_id', 'length', 'max'=>64),
			array('sb_lguposition', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sb_lguposition', 'safe', 'on'=>'search'),
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
			'sb' => array(self::BELONGS_TO, 'Users', 'sb_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sb_id' => 'Registered LGUs',
			'sb_lguposition' => 'Sangguniang Bayan Position',
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

		$criteria->compare('sb_id',$this->sb_id,true);
		$criteria->compare('sb_lguposition',$this->sb_lguposition,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function checkPosition($pos){
		$connection=Yii::app()->db;

		$sql = "SELECT * FROM sangguniangbayan where sb_lguposition = '$pos';";
		$command = $connection->createCommand($sql);
		return $command->queryAll()==null?true:false;
	}

	public function getUser($id){
		$connection=Yii::app()->db;

		$sql = "SELECT concat(user_lastname, ', ',user_firstname, ' ', user_middlename) as name FROM users where user_id = '$id';";
		$command = $connection->createCommand($sql);

		return $command->queryAll()[0]['name'];

	}

	public function getSbCount(){
		$connection=Yii::app()->db;

		$sql = "SELECT COUNT(*) FROM sangguniangbayan;";
		$command = $connection->createCommand($sql);

		return $command->queryAll()[0]['count'];

	}

	public function hasVetoVoted($sb_id, $vot_id){
		$connection=Yii::app()->db;

		$sql = "SELECT vot_userid FROM vot_veto_users WHERE vot_id = '$vot_id';";

		$command = $connection->createCommand($sql);

		$users = $command->queryAll();

		if($users != null){
			foreach($users as $user){
				if(in_array($sb_id, $user))
					return 'Voted';
			}
		}
		return 'Not yet voted.';
	}
	public function hasVoted($sb_id, $vot_id){
		$connection=Yii::app()->db;

		$sql = "SELECT vot_userid FROM vot_users WHERE vot_id = '$vot_id';";

		$command = $connection->createCommand($sql);

		$users = $command->queryAll();

		if($users != null){
			foreach($users as $user){
				if(in_array($sb_id, $user))
					return 'Voted';
			}
		}
		return 'Not yet voted.';
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sangguniangbayan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
