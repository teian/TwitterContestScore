<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%crawler_profile}}".
 *
 * @property string $id
 * @property string $name
 * @property string $regex_entry
 * @property string $regex_rating
 * @property integer $is_default
 * @property string $create_time
 * @property string $update_time
 *
 * @property Contest[] $contests
 */
class CrawlerProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%crawler_profile}}';
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
            [['name'], 'required'],
            [['regex_entry', 'regex_rating'], 'string'],
            [['is_default'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 255]
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
            'regex_entry' => Yii::t('app', 'Regex Entry'),
            'regex_rating' => Yii::t('app', 'Regex Rating'),
            'is_default' => Yii::t('app', 'Is Default'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContests()
    {
        return $this->hasMany(Contest::className(), ['crawler_profile_id' => 'id']);
    }
}
