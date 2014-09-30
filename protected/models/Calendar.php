<?php

/**
 * This is the model class for table "calendar".
 *
 * The followings are the available columns in table 'calendar':
 * @property string $cal_eventid
 * @property string $cal_eventtitle
 * @property string $cal_ordid
 * @property string $cal_eventcreated
 * @property string $cal_eventdispdate
 * @property string $cal_eventtype
 * @property string $cal_eventcontent
 * @property string $cal_eventdate
 * @property string $cal_eventauthorid
 * @property string $cal_eventtime_from
 * @property string $cal_eventtime_to
 */
class Calendar extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'calendar';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cal_eventid, cal_eventtitle, cal_eventcreated, cal_eventcontent, cal_eventdate, cal_eventauthorid', 'required'),
			array('cal_eventid, cal_eventtitle, cal_eventcreated, cal_eventcontent, cal_eventdate, cal_eventauthorid', 'safe'),
			array('cal_eventid, cal_ordid, cal_eventtype, cal_eventauthorid', 'length', 'max'=>64),
			array('cal_eventdispdate, cal_eventtime_from, cal_eventtime_to', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cal_eventid, cal_eventtitle, cal_ordid, cal_eventcreated, cal_eventdispdate, cal_eventtype, cal_eventcontent, cal_eventdate, cal_eventauthorid, cal_eventtime_from, cal_eventtime_to', 'safe', 'on'=>'search'),
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
			'cal_eventid' => 'Cal Eventid',
			'cal_eventtitle' => 'Cal Eventtitle',
			'cal_ordid' => 'Cal Ordid',
			'cal_eventcreated' => 'Cal Eventcreated',
			'cal_eventdispdate' => 'Cal Eventdispdate',
			'cal_eventtype' => 'Cal Eventtype',
			'cal_eventcontent' => 'Cal Eventcontent',
			'cal_eventdate' => 'Cal Eventdate',
			'cal_eventauthorid' => 'Cal Eventauthorid',
			'cal_eventtime_from' => 'Cal Eventtime From',
			'cal_eventtime_to' => 'Cal Eventtime To',
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

		$criteria->compare('cal_eventid',$this->cal_eventid,true);
		$criteria->compare('cal_eventtitle',$this->cal_eventtitle,true);
		$criteria->compare('cal_ordid',$this->cal_ordid,true);
		$criteria->compare('cal_eventcreated',$this->cal_eventcreated,true);
		$criteria->compare('cal_eventdispdate',$this->cal_eventdispdate,true);
		$criteria->compare('cal_eventtype',$this->cal_eventtype,true);
		$criteria->compare('cal_eventcontent',$this->cal_eventcontent,true);
		$criteria->compare('cal_eventdate',$this->cal_eventdate,true);
		$criteria->compare('cal_eventauthorid',$this->cal_eventauthorid,true);
		$criteria->compare('cal_eventtime_from',$this->cal_eventtime_from,true);
		$criteria->compare('cal_eventtime_to',$this->cal_eventtime_to,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Calendar the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
