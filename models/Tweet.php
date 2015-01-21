<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tweet}}".
 *
 * @property string $id
 * @property string $created_at
 * @property string $text
 * @property string $user_id
 * @property string $contest_id
 * @property string $amv_id
 * @property string $rating
 * @property integer $needs_validation
 * @property string $create_time
 * @property string $update_time
 *
 * @property Contest[] $contests
 * @property TweetUser $user
 * @property Contest $contest
 */
class Tweet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tweet}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
               'class' => \yii\behaviors\TimestampBehavior::className(),
               'createdAtAttribute' => 'create_time',
               'updatedAtAttribute' => 'update_time',
               'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'text', 'user_id', 'contest_id', 'amv_id'], 'required'],
            [['created_at', 'create_time', 'update_time'], 'safe'],
            [['user_id', 'contest_id', 'amv_id', 'needs_validation'], 'integer'],
            [['rating'], 'number'],
            [['text'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'text' => Yii::t('app', 'Text'),
            'user_id' => Yii::t('app', 'User ID'),
            'contest_id' => Yii::t('app', 'Contest ID'),
            'amv_id' => Yii::t('app', 'Amv ID'),
            'rating' => Yii::t('app', 'Rating'),
            'needs_validation' => Yii::t('app', 'Needs Validation'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContests()
    {
        return $this->hasMany(Contest::className(), ['last_parsed_tweet_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(TweetUser::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContest()
    {
        return $this->hasOne(Contest::className(), ['id' => 'contest_id']);
    }
}
