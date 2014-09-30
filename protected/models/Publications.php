<?php

/**
 * This is the model class for table "publications".
 *
 * The followings are the available columns in table 'publications':
 * @property string $pub_id
 * @property string $pub_title
 * @property string $pub_fileid
 * @property string $pub_datecreated
 * @property string $pub_dispositiondate
 * @property string $pub_pubtype
 *
 * The followings are the available model relations:
 * @property Announcements[] $announcements
 * @property Ordinances[] $ordinances
 * @property Documentations[] $documentations
 * @property OrdAuthors[] $ordAuthors
 * @property OrdApproved[] $ordApproveds
 * @property OrdDisproved[] $ordDisproveds
 */
class Publications extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'publications';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pub_id, pub_title, pub_datecreated, pub_pubtype', 'required'),
			array('pub_id, pub_title, pub_fileid', 'length', 'max'=>64),
			array('pub_dispositiondate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pub_id, pub_title, pub_fileid, pub_datecreated, pub_dispositiondate, pub_pubtype', 'safe', 'on'=>'search'),
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
			'pub_id' => 'Pub',
			'pub_title' => 'Pub Title',
			'pub_fileid' => 'Pub Fileid',
			'pub_datecreated' => 'Pub Datecreated',
			'pub_dispositiondate' => 'Pub Dispositiondate',
			'pub_pubtype' => 'Pub Pubtype',
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

		$criteria->compare('pub_id',$this->pub_id,true);
		$criteria->compare('pub_title',$this->pub_title,true);
		$criteria->compare('pub_fileid',$this->pub_fileid,true);
		$criteria->compare('pub_datecreated',$this->pub_datecreated,true);
		$criteria->compare('pub_dispositiondate',$this->pub_dispositiondate,true);
		$criteria->compare('pub_pubtype',$this->pub_pubtype,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Publications the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
