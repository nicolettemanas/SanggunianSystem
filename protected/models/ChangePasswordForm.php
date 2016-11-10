<?php

/**
 * ChangePasswordForm class.
 * ChangePasswordForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ChangePasswordForm extends CFormModel
{
	public $currPassword;
	public $newPassword;
	public $repeatNewPassword;

	private $_user;

	/**
	 * Declares the validation rules.
	 * The rules state that all fields are required
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('currPassword, newPassword, repeatNewPassword', 'required'),
			// password needs to be authenticated
			array('currPassword', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'currPassword'=>'Current password',
			'newPassword'=>'New password',
			'repeatNewPassword'=>'Repeat new password'
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function comparePassword($attribute,$params)
	{
		if(md5($currPassword) != $this->_user->password)
		{
			$this->addError($attribute,'Incorrect password.');
		}
	}

	public function init()
	{
		$this->_user = Users::model()->findByAttributes( array( 'user_username'=>Yii::app()->User->name ) );
	}
	
	public function changePassword()
	{
		$this->_user->user_password = $this->newPassword;
		if( $this->_user->save() )
		  return true;
		return false;
	}
}
