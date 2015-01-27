<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Mod extends Eloquent implements UserInterface, RemindableInterface {
	protected $fillable = ['moderator_id','moderator_name','moderator_pw'];
	
	public $timestamps = false;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	protected $hidden = ['moderator_pw'];
	protected $table = 'moderator';
    protected $primaryKey = "moderator_id";
    public static $rules = array(
        'moderator_name' => 'required',
        'moderator_pw' => 'required'
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