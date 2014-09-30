<?php

/**
 * This is the model class for table "votings".
 *
 * The followings are the available columns in table 'votings':
 * @property string $vot_id
 * @property string $vot_title
 * @property string $vot_description
 * @property string $vot_votstatus
 * @property string $vot_deadline
 */
class Votings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'votings';
	}

	public function getSangguniangBayan(){

		$connection = Yii::app()->db;
		$sql = "SELECT CONCAT(user_lastname, ', ', user_firstname, ' ', user_middlename) AS name FROM users
			WHERE user_id IN (SELECT sb_id FROM sangguniangbayan);
		";

		$command = $connection->createCommand($sql);

		var_dump($command->queryAll());
		return '1';//$command->queryAll();

	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vot_id, vot_title, vot_description, vot_votstatus, vot_deadline', 'required'),
			array('vot_id, vot_title, vot_description, vot_votstatus, vot_deadline, vot_start, vot_ord_id, vot_prev_status', 'safe'),
			array('vot_id, vot_title', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('vot_id, vot_title, vot_description, vot_votstatus, vot_deadline', 'safe', 'on'=>'search'),
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
			'vot_id' => 'Vot',
			'vot_title' => 'Vot Title',
			'vot_description' => 'Vot Description',
			'vot_votstatus' => 'Vot Votstatus',
			'vot_deadline' => 'Vot Deadline',
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

		$criteria->compare('vot_id',$this->vot_id,true);
		$criteria->compare('vot_title',$this->vot_title,true);
		$criteria->compare('vot_description',$this->vot_description,true);
		$criteria->compare('vot_votstatus',$this->vot_votstatus,true);
		$criteria->compare('vot_deadline',$this->vot_deadline,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Votings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
