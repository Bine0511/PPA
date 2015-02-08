<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDb extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('moderator', function($table)
		{
			// Creating Columns
			$table->increments('moderator_id');
			$table->string('moderator_name');
			$table->string('moderator_pw');
        	$table->string('remember_token', 100);
			$table->timestamps();
		});

		Schema::create('session', function($table)
		{
			// Creating Columns
			$table->increments('session_id');
			$table->string('session_name');
			$table->string('session_pw');
			$table->integer('session_moderator_id')->unsigned();
			$table->integer('base_story_id')->unsigned();
			$table->timestamps();

			// Defining Foreign Keys
			$table->foreign('session_moderator_id')
			->references('moderator_id')->on('moderator');
		});

		Schema::create('user', function($table)
		{
			// Creating Columns
			$table->increments('user_id');
			$table->string('user_name');
			$table->integer('user_session_id')->unsigned();
        	$table->string('remember_token', 100);
			$table->timestamps();

			// Defining Foreign Keys
			$table->foreign('user_session_id')
			->references('session_id')->on('session');
		});

		Schema::create('userstory', function($table)
		{
			// Creating Columns
			$table->increments('userstory_id');
			$table->integer('userstory_session_id')->unsigned();
			$table->string('userstory_name');
			$table->text('userstory_description');
			$table->string('userstory_average');
			$table->string('userstory_time_average');
			$table->timestamps();

			// Defining Foreign Keys
			$table->foreign('userstory_session_id')
			->references('session_id')->on('session');
		});

		Schema::create('vote', function($table)
		{
			// Creating Columns
			$table->integer('vote_user_id')->unsigned();
			$table->integer('vote_userstory_id')->unsigned();
			$table->integer('vote_session_id')->unsigned();
			$table->string('vote_value');
			$table->timestamps();

			// Defining Foreign Keys
			$table->foreign('vote_user_id')
			->references('user_id')->on('user');
			$table->foreign('vote_userstory_id')
			->references('userstory_id')->on('userstory');
			$table->foreign('vote_session_id')
			->references('session_id')->on('session');
		});

		Schema::create('timevote', function($table)
		{
			// Creating Columns
			$table->integer('timevote_user_id')->unsigned();
			$table->integer('timevote_userstory_id')->unsigned();
			$table->integer('timevote_session_id')->unsigned();
			$table->string('timevote_value');
			$table->timestamps();

			// Defining Foreign Keys
			$table->foreign('timevote_user_id')
			->references('user_id')->on('user');
			$table->foreign('timevote_userstory_id')
			->references('userstory_id')->on('userstory');
			$table->foreign('timevote_session_id')
			->references('session_id')->on('session');
		});

		Schema::table('session', function($table)
		{
			$table->foreign('base_story_id')
			->references('userstory_id')->on('userstory');
		});


		// Defining Primary Keys
		DB::statement('ALTER TABLE vote ADD PRIMARY KEY(vote_user_id,vote_userstory_id,vote_session_id);');
		DB::statement('ALTER TABLE timevote ADD PRIMARY KEY(timevote_user_id,timevote_userstory_id,timevote_session_id);');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('timevote');
		Schema::drop('vote');
		Schema::drop('user');
		Schema::table('session', function($table)
		{
			$table->dropForeign('session_base_story_id_foreign');
		});
		Schema::drop('userstory');
		Schema::drop('session');
		Schema::drop('moderator');
	}

}
