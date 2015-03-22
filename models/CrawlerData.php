<?php
/**
 * @author Frank Gehann <fg@randomlol.de>
 * @link https://github.com/Tak0r/TwitterContestScore
 * @license Beerware
 * @package Models
 */

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%crawler_data}}".
 *
 * @property string $id
 * @property string $contest_id
 * @property string $data
 * @property string $parsed_at
 * @property string $create_time
 * @property string $update_time
 *
 * @property Contest $contest
 */
class CrawlerData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%crawler_data}}';
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
            [['contest_id'], 'required'],
            [['contest_id'], 'integer'],
            [['data'], 'string'],
            [['parsed_at', 'create_time', 'update_time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'contest_id' => Yii::t('app', 'Contest'),
            'data' => Yii::t('app', 'Data'),
            'parsed_at' => Yii::t('app', 'Parsed At'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContest()
    {
        return $this->hasOne(Contest::className(), ['id' => 'contest_id']);
    }
}
