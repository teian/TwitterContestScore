<?php
/**
 * Loginform Model.
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
 * The followings are the available attribiutes
 * @property string $username
 * @property string $password
 * @property string $email
 * @property integer $rememberMe
 * @property string $verifyCode
 * @property object $_identity
 * @property object $_user
 */

class LoginForm extends CFormModel {

	// maximum number of login attempts before display captcha
	const MAX_LOGIN_ATTEMPTS = 3;

	public $username;
	public $password;
	public $email;
	public $rememberMe;
	public $verifyCode;
	private $_identity;
	private $_user = null;

	/**
	 * Model rules
	 * @return array
	 */
	public function rules() {
		return array(
			array('username, password, email', 'required'),
			array('username', 'length', 'max' => 45),
			array('password', 'length', 'max' => 50, 'min' => 8),
			array('verifyCode','required','on'=>'requireCaptcha'),     
			array('verifyCode', 'validateCaptcha'),
			array('password', 'authenticate'),
			array('rememberMe', 'boolean'),
			array('email', 'email'),
			array('email', 'length', 'max' => 254),
		);
	}

	/**
	 * Returns attribute labels
	 * @return array
	 */
	public function attributeLabels() {
		return array(
			'username' => Yii::t('user', 'Username or Email'),
			'rememberMe' => Yii::t('user', 'Remember me next time'),
		);
	}

	/**
	 * Authenticates user input against DB
	 * @param $attribute
	 * @param $params
	 */
	public function authenticate($attribute, $params) {
		if (!$this->hasErrors()) 
		{
			$this->_identity = new UserIdentity($this->username, $this->password);
			if (!$this->_identity->authenticate()) 
			{				
				if (($user = $this->user) !== null && $user->login_attempts < 100)
				{
					$user->saveAttributes(array('login_attempts' => $user->login_attempts + 1));
				}

				$this->addError('username', Yii::t('errors', 'Incorrect username and/or password.'));
				$this->addError('password', Yii::t('errors', 'Incorrect username and/or password.'));
			} 
			else 
			{
				$this->user->saveAttributes(array('login_attempts' => 0));
			}
		}
	}

	/**
	 * Validates captcha code
	 * @param $attribute
	 * @param $params
	 */
	public function validateCaptcha($attribute, $params) {
		if ($this->getRequireCaptcha())
		{
			CValidator::createValidator('captcha', $this, $attribute, $params)->validate($this);
		}
	}

	/**
	 * Login
	 * @return bool
	 */
	public function login() {
		if ($this->_identity === null) 
		{
			$this->_identity = new UserIdentity($this->username, $this->password);
			$this->_identity->authenticate();
		}
		
		if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) 
		{
			$duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
			Yii::app()->user->login($this->_identity, $duration);

			// Require new Password? Then redirect to Profile!
			if($this->user->requires_new_password)
			{
				Yii::app()->user->returnUrl = CHtml::normalizeUrl(array('user/updateprofile', 'id'=>Yii::app()->user->id));
			}

			return true;
		}
	}

	/**
	 * Returns
	 * @return null
	 */
	public function getUser() {
		if ($this->_user === null) 
		{
			$attribute = strpos($this->username, '@') ? 'email' : 'username';
			$this->_user = User::model()->find(array('condition' => $attribute . '=:loginname', 'params' => array(':loginname' => $this->username)));
		}
		return $this->_user;
	}

	/**
	 * Returns whether it requires captcha or not
	 * @return bool
	 */
	public function getRequireCaptcha() {
		return ($user = $this->user) !== null && $user->login_attempts >= self::MAX_LOGIN_ATTEMPTS;
	}

}
