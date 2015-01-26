<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Mod extends Eloquent implements UserInterface, RemindableInterface {
	
	public $timestamps = false;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'moderator';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['moderator_pw'];

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier(){
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword(){
		return $this->moderator_pw;
	}

	public function getRememberToken(){
		return $this->remember_token;
	}

	public function setRememberToken($value){
    	$this->remember_token = $value;
  	}
  
  	public function getRememberTokenName(){
    	return "remember_token";
  	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail(){
		return $this->email;
	}

}