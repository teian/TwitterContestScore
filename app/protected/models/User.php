<?php
/**
 * This is the model class for table "user".
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
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property string $username
 * @property integer $login_attempts
 * @property string $validation_key
 * @property string $password_strategy
 * @property boolean $requires_new_password
 */
class User extends CActiveRecord
{
	const STATUS_NOACTIVE=0;
	const STATUS_ACTIVE=1;
	const STATUS_BANNED=-1;

	/**
	 * @var string attribute used for new passwords on user's edition
	 */
	public $newPassword;

	/**
	 * @var string attribute used to confirmation fields
	 */
	public $passwordConfirm;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Customer the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * Behaviors
	 * @return array
	 */
	public function behaviors()
	{
		return array(
			"APasswordBehavior" => array(
				"class" => "APasswordBehavior",
				"defaultStrategyName" => "bcrypt",
				"strategies" => array(
					"bcrypt" => array(
						"class" => "ABcryptPasswordStrategy",
						"workFactor" => 14
					),
					"legacy" => array(
						"class" => "ALegacyMd5PasswordStrategy",
					)
				),
			)
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username,email', 'required'),
			array('newPassword', 'required', 'on'=>'requireNewPassword'), 
			array('password', 'required', 'on' => 'create'),
			array('email', 'required', 'on' => 'checkout'),
			array('email', 'unique', 'on' => 'checkout', 'message' => Yii::t('alerts', 'Email has already been taken.')),
			array('email', 'email'),
			array('username', 'length', 'max' => 45, 'min' => 3),
			array('username, email', 'unique'),
			array('passwordConfirm', 'compare', 'compareAttribute' => 'newPassword', 'message' => Yii::t('alerts', "Passwords don't match")),
			array('newPassword', 'length', 'max' => 50, 'min' => 8),			
			array('email', 'length', 'max' => 254),
			array('password, salt', 'length', 'max' => 255),			
			array('requires_new_password, login_attempts', 'numerical', 'integerOnly' => true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.

			array('id, password, salt, password_strategy , requires_new_password , email, super_admin', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => Yii::t('labels', 'Username'),
			'password' => Yii::t('labels', 'Password'),
			'newPassword' => Yii::t('labels', 'New Password'),
			'passwordConfirm' => Yii::t('labels', 'Confirm password'),
			'requires_new_password' => Yii::t('labels', 'Require new Password'),
			'email' => Yii::t('labels', 'Email'),
		);
	}

	/**
	 * Helper property function
	 * @return string the full name of the customer
	 */
	public function getFullName()
	{

		return $this->username;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.username', $this->username, true);
		$criteria->compare('t.password', $this->password, true);
		$criteria->compare('t.email', $this->email, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Makes sure usernames are lowercase
	 * Check if password has changed
	 * (emails by standard can have uppercase letters)
	 * @return parent::beforeValidate
	 */
	public function beforeValidate()
	{
		if (!empty($this->username))
			$this->username = strtolower($this->username);

		// Check for new Password!
		if(!empty($this->newPassword))
		{
			$this->password = $this->newPassword;
			$this->requires_new_password = 0;
		}

		return parent::beforeValidate();
	}

	/**
	 * Returns whether it requires a new password or not
	 * @return bool
	 */
	public function getRequireNewPassword() {
		return $this->requires_new_password;
	}

	/**
	 * Generates a new validation key (additional security for cookie)
	 */
	public function regenerateValidationKey()
	{
		$this->saveAttributes(array(
			'validation_key' => md5(mt_rand() . mt_rand() . mt_rand()),
		));
	}
}