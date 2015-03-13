<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
	
	protected $fillable = [ 'user_ID', 'user_name', 'user_session_ID', 'user_session_pw' ];
	
	public $timestamps = false;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $hidden = ['user_session_pw'];
	protected $table = 'user';
    protected $primaryKey = "user_ID";
    public static $rules = array(
        'user_name' => 'required',
        'user_session_ID' => 'required',
        'user_session_pw' => 'required'
    ); 


	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier(){
		return $this->user_ID;
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword(){
		return $this->user_session_pw;
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