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
 * This is the model class for table "{{%entry}}".
 *
 * @property string $id
 * @property string $name
 * @property string $contest_id
 * @property string $contest_entry_id
 * @property string $avg_rating
 * @property string $min_rating
 * @property string $max_rating
 * @property string $votes
 * @property string $create_time
 * @property string $update_time
 *
 * @property Contest $contest
 */
class Entry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%entry}}';
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
            [['contest_id', 'contest_entry_id'], 'required'],
            [['contest_id', 'contest_entry_id', 'votes'], 'integer'],
            [['avg_rating', 'min_rating', 'max_rating'], 'match', 'pattern'=>'/^[0-9]{1,2}(\.[0-9]{0,2})?$/'],
            [['sum_rating'], 'match', 'pattern'=>'/^[0-9]{1,8}(\.[0-9]{0,2})?$/'],
            [['create_time', 'update_time'], 'safe'],
            [['contest_id', 'contest_entry_id'], 'unique', 'targetAttribute' => ['contest_id', 'contest_entry_id'], 'message' => 'The combination of Contest ID and Contest Entry ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'contest_id' => Yii::t('app', 'Contest'),
            'contest_entry_id' => Yii::t('app', 'Entry'),
            'avg_rating' => Yii::t('app', 'Avg Rating'),
            'min_rating' => Yii::t('app', 'Min Rating'),
            'max_rating' => Yii::t('app', 'Max Rating'),         
            'votes' => Yii::t('app', 'Votes'),
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
