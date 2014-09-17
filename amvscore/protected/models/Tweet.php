<?php

/**
 * This is the model class for table "tweet".
 *
 * The followings are the available columns in table 'tweet':
 * @property string $id
 * @property string $created_at
 * @property string $text
 * @property string $user_id
 * @property string $contest_id
 * @property string $amv_id
 * @property string $rating
 * @property string $needs_validation
 *
 * The followings are the available model relations:
 * @property Contest[] $contests
 * @property Amv $amv
 * @property Contest $contest
 * @property TweetUser $user
 */
class Tweet extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tweet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, created_at, text, user_id, contest_id, amv_id, rating', 'required'),
			array('id, user_id, contest_id, amv_id', 'length', 'max'=>20),
			array('text', 'length', 'max'=>150),
			array('rating', 'length', 'max'=>2),
			array('needs_validation', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, created_at, text, user_id, contest_id, amv_id, rating, needs_validation', 'safe', 'on'=>'search'),
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
			'contests' => array(self::HAS_MANY, 'Contest', 'last_parsed_tweet_id'),
			'amv' => array(self::BELONGS_TO, 'Amv', 'amv_id'),
			'contest' => array(self::BELONGS_TO, 'Contest', 'contest_id'),
			'user' => array(self::BELONGS_TO, 'TweetUser', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'created_at' => 'Created At',
			'text' => 'Tweet',
			'user_id' => 'User',
			'contest_id' => 'Contest',
			'amv_id' => 'Amv',
			'rating' => 'Rating',
			'needs_validation' => "Needs Validation",
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
		$criteria->compare('t.created_at',$this->created_at,true);
		$criteria->compare('t.text',$this->text,true);
		$criteria->compare('t.user_id',$this->user_id,true);
		$criteria->compare('t.contest_id',$this->contest_id,true);
		$criteria->compare('t.amv_id',$this->amv_id,true);
		$criteria->compare('t.rating',$this->rating,true);
		$criteria->compare('t.needs_validation',$this->rating,true);		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tweet the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
