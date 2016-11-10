<?php

/**
 * This is the model class for table "announcements".
 *
 * The followings are the available columns in table 'announcements':
 * @property string $ann_id
 * @property string $ann_body
 * @property string $ann_author
 * @property string $ann_title
 *
 * The followings are the available model relations:
 * @property Users $annAuthor
 */
class Announcements extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'announcements';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ann_id, ann_body, ann_author, ann_title, ann_creation_date', 'required'),
			array('ann_id, ann_author', 'length', 'max'=>64),
			array('ann_title', 'length', 'max'=>256),
			array('ann_id, ann_body, ann_author, ann_title, ann_creation_date', 'safe', 'on' => 'hearing'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ann_id, ann_body, ann_author, ann_title', 'safe', 'on'=>'search'),
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
			'annAuthor' => array(self::BELONGS_TO, 'Users', 'ann_author'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ann_id' => 'Ann',
			'ann_body' => 'Announcement',
			'ann_author' => 'Author',
			'ann_title' => 'Title',
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

		$criteria->compare('ann_id',$this->ann_id,true);
		$criteria->compare('ann_body',$this->ann_body,true);
		$criteria->compare('ann_author',$this->ann_author,true);
		$criteria->compare('ann_title',$this->ann_title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getAuthor($id){
		$connection=Yii::app()->db;
		
		$sql = "SELECT concat(user_lastname, ', ', user_firstname, ' ', user_middlename) as name FROM users where user_id in (select ann_author from announcements where ann_id = '$id');";
		$command = $connection->createCommand($sql);
		
		return $command->queryAll()[0]['name'];
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Announcements the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
