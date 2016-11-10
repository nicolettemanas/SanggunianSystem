<?php

/**
 * This is the model class for table "localcommittee".
 *
 * The followings are the available columns in table 'localcommittee':
 * @property string $lc_id
 * @property string $lc_lguposition
 * @property string $lc_committeename
 *
 * The followings are the available model relations:
 * @property Users $lc
 */
class Localcommittee extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'localcommittee';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lc_id, lc_committeename', 'required'),
			array('lc_committeename', 'length', 'max'=>64),
			array('lc_lguposition', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lc_lguposition, lc_committeename', 'safe', 'on'=>'search'),
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
			'lc' => array(self::BELONGS_TO, 'Users', 'lc_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lc_id' => 'Lc',
			'lc_lguposition' => 'Local Committee Position',
			'lc_committeename' => 'Local Committee Name',
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

		$criteria->compare('lc_id',$this->lc_id,true);
		$criteria->compare('lc_lguposition',$this->lc_lguposition,true);
		$criteria->compare('lc_committeename',$this->lc_committeename,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function saveLocalCommittee($position, $id, $user){
		$connection=Yii::app()->db;
	
		$sql = "UPDATE TABLE local_committees SET lc_$position_id = '$user' where lc_id = $id;";
		$command = $connection->createCommand($sql);
		$members=$command->queryAll();
	}
		
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Localcommittee the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
