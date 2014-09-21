<?php
/*
 * This is the model class for table "contest".
 * @author Frank Gehann <fg@code-works.de>
 * @copyright Copyright (c) Code Works 2014
 *
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <fg@code-works.de> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return. Frank Gehann
 * ----------------------------------------------------------------------------
 *
 * The followings are the available columns in table 'contest':
 * @property string $id
 * @property string $name
 * @property string $trigger
 * @property string $year
 * @property integer $active
 * @property string $last_parsed_tweet_id
 * @property string $parse_from
 * @property string $parse_to
 *
 * The followings are the available model relations:
 * @property Tweet $lastParsedTweet
 * @property Tweet[] $tweets
 */
class Contest extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contest';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('active', 'numerical', 'integerOnly'=>true),
			array('name, trigger', 'length', 'max'=>255),
			array('year', 'length', 'max'=>4),
			array('last_parsed_tweet_id', 'length', 'max'=>20),
			array('parse_from, parse_to', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, trigger, year, active, last_parsed_tweet_id, parse_from, parse_to', 'safe', 'on'=>'search'),
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
			'lastParsedTweet' => array(self::BELONGS_TO, 'Tweet', 'last_parsed_tweet_id'),
			'tweets' => array(self::HAS_MANY, 'Tweet', 'contest_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'trigger' => 'Trigger',
			'year' => 'Year',
			'active' => 'Active',
			'last_parsed_tweet_id' => 'Last Parsed Tweet',
			'parse_from' => 'Parse From',
			'parse_to' => 'Parse To',
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
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.trigger',$this->name,true);
		$criteria->compare('t.year',$this->year,true);
		$criteria->compare('t.active',$this->active);
		$criteria->compare('t.last_parsed_tweet_id',$this->last_parsed_tweet_id,true);
		$criteria->compare('t.parse_from',$this->parse_from,true);
		$criteria->compare('t.parse_to',$this->parse_to,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Contest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
