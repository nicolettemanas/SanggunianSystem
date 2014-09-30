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
 * @property Documentations[] $documentations
 * @property Publications $ord
 * @property ChiefExecVetos[] $chiefExecVetoses
 */
class Ordinances extends CActiveRecord
{
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
			array('ord_id, ord_title, ord_description, ord_authors_id, ord_file_id, ord_status, ord_approval_status, ord_committee_id, ord_committee_report_file_id, ord_voting_id, ord_ordtype, ord_comments_id', 'required'),
			array('ord_id, ord_title, ord_authors_id, ord_file_id, ord_committee_id, ord_committee_report_file_id, ord_voting_id, ord_comments_id', 'length', 'max'=>64),
			array('ord_creation_date, ord_effectivity_date, ord_approval_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ord_id, ord_title, ord_description, ord_authors_id, ord_file_id, ord_creation_date, ord_effectivity_date, ord_approval_date, ord_status, ord_approval_status, ord_committee_id, ord_committee_report_file_id, ord_voting_id, ord_ordtype, ord_comments_id', 'safe', 'on'=>'search'),
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
			'documentations' => array(self::HAS_MANY, 'Documentations', 'doc_ordinanceid'),
			'ord' => array(self::BELONGS_TO, 'Publications', 'ord_id'),
			'chiefExecVetoses' => array(self::HAS_MANY, 'ChiefExecVetos', 'vet_ordid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ord_id' => 'Ord',
			'ord_title' => 'Ord Title',
			'ord_description' => 'Ord Description',
			'ord_authors_id' => 'Ord Authors',
			'ord_file_id' => 'Ord File',
			'ord_creation_date' => 'Ord Creation Date',
			'ord_effectivity_date' => 'Ord Effectivity Date',
			'ord_approval_date' => 'Ord Approval Date',
			'ord_status' => 'Ord Status',
			'ord_approval_status' => 'Ord Approval Status',
			'ord_committee_id' => 'Ord Committee',
			'ord_committee_report_file_id' => 'Ord Committee Report File',
			'ord_voting_id' => 'Ord Voting',
			'ord_ordtype' => 'Ord Ordtype',
			'ord_comments_id' => 'Ord Comments',
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

		$criteria->compare('ord_id',$this->ord_id,true);
		$criteria->compare('ord_title',$this->ord_title,true);
		$criteria->compare('ord_description',$this->ord_description,true);
		$criteria->compare('ord_authors_id',$this->ord_authors_id,true);
		$criteria->compare('ord_file_id',$this->ord_file_id,true);
		$criteria->compare('ord_creation_date',$this->ord_creation_date,true);
		$criteria->compare('ord_effectivity_date',$this->ord_effectivity_date,true);
		$criteria->compare('ord_approval_date',$this->ord_approval_date,true);
		$criteria->compare('ord_status',$this->ord_status,true);
		$criteria->compare('ord_approval_status',$this->ord_approval_status,true);
		$criteria->compare('ord_committee_id',$this->ord_committee_id,true);
		$criteria->compare('ord_committee_report_file_id',$this->ord_committee_report_file_id,true);
		$criteria->compare('ord_voting_id',$this->ord_voting_id,true);
		$criteria->compare('ord_ordtype',$this->ord_ordtype,true);
		$criteria->compare('ord_comments_id',$this->ord_comments_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
