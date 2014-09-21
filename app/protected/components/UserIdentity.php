<?php
/**
 * UserIdentity
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
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */

class UserIdentity extends CUserIdentity {
	
	/**
	 * @var integer id of logged user
	 */
	private $_id;

	/**
	 * @var string email of logged user
	 */
	private $_email;

	/**
	 * Authenticates username and password
	 * @return boolean CUserIdentity::ERROR_NONE if successful authentication
	 */
	public function authenticate() {
		$attribute = strpos($this->username, '@') ? 'email' : 'username';
		$user = User::model()->find(array('condition' => $attribute . '=:loginname', 'params' => array(':loginname' => $this->username)));

		if ($user === null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} else if (!$user->verifyPassword($this->password)) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		} else {
			$user->regenerateValidationKey();
			$this->_id = $user->id;
			$this->_email = $user->email;
			$this->username = $user->username;
			$this->setState('vkey', $user->validation_key);

			$this->errorCode = self::ERROR_NONE;
		}
		return !$this->errorCode;
	}

	/**
	 * Creates an authenticated user with no passwords for registration
	 * process (checkout)
	 * @param string $username
	 * @return self
	 */
	public static function createAuthenticatedIdentity($id, $username) {
		$identity = new self($username, '');
		$identity->_id = $id;
		$identity->errorCode = self::ERROR_NONE;
		return $identity;
	}

	/**
	 *
	 * @return integer id of the logged user, null if not set
	 */
	public function getId() {
		return $this->_id;
	}

	/**
	 *
	 * @return string email of the logged user, null if not set
	 */
	public function getEmail() {
		return $this->_email;
	}
}