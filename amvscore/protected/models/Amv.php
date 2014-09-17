<?php

/**
 * This is the model class for table "amv".
 *
 * The followings are the available columns in table 'amv':
 * @property string $id
 * @property string $contest_id
 * @property string $contest_amv_id
 * @property string $avg_rating
 * @property string $min_rating
 * @property string $max_rating
 * @property string $votes
 *
 * The followings are the available model relations:
 * @property Tweet[] $tweets
 */
class Amv extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'amv';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contest_id, contest_amv_id', 'required'),
			array('contest_id, contest_amv_id, votes', 'length', 'max'=>20),
			array('avg_rating, min_rating, max_rating', 'match', 'pattern'=>'/^[0-9]{1,2}(\.[0-9]{0,2})?$/'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, contest_id, contest_amv_id, avg_rating, min_rating, max_rating, votes', 'safe', 'on'=>'search'),
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
			'tweets' => array(self::HAS_MANY, 'Tweet', 'amv_id'),
			'contest' => array(self::HAS_ONE, 'Contest', array('id'=>'contest_id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'contest_id' => 'Contest',
			'contest_amv_id' => 'AMV ID',
			'avg_rating' => 'Avg Rating',
			'min_rating' => 'Min Rating',
			'max_rating' => 'Max Rating',
			'votes' => 'Votes',
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

		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('t.contest_id',$this->contest_id,true);
		$criteria->compare('t.contest_amv_id',$this->contest_amv_id,true);
		$criteria->compare('t.avg_rating',$this->avg_rating,true);
		$criteria->compare('t.min_rating',$this->min_rating,true);
		$criteria->compare('t.max_rating',$this->max_rating,true);
		$criteria->compare('t.votes',$this->votes,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Amv the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
