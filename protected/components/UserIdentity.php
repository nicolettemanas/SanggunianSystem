<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{	
		$sql = "Select * from users;";
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$users=$command->queryAll();
		
		foreach($users as $user){
			if($user['user_username'] === $this->username){
				if($user['user_usertype'] == 'General Public')
					return !self::ERROR_PASSWORD_INVALID;
				$this->errorCode=$user['user_password'] !== md5($this->password)?self::ERROR_PASSWORD_INVALID:self::ERROR_NONE;
				$this->setState('role', $user['user_usertype']);
				$this->setState('id', $user['user_id']);
			}
		}
		return !$this->errorCode;
		
	}
}