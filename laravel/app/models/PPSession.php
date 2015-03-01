<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class PPSession extends Eloquent implements UserInterface{
	//, RemindableInterface 

	protected $fillable = [ 'session_ID', 'session_name', 'session_pw', 'session_moderator_ID', 'session_basestory_id' ];
	
	public $timestamps = false;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	protected $hidden = ['session_pw'];
	protected $table = 'session';
    protected $primaryKey = "session_ID";
    public static $rules = array(
        'session_name' => 'required',
        'session_pw' => 'required'
    ); 

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier(){
		return $this->session_ID;
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword(){
		return $this->session_pw;
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
/*	public function getReminderEmail(){
		return $this->email;
	}*/

}