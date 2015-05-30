<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::dropIfExists('users');
        Schema::dropIfExists('organizations');
        Schema::dropIfExists('activities');

        Schema::create('organizations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('description')->default('');
            $table->enum('status', array('active', 'disabled'))->default('active');
            $table->string('address')->default('');
            $table->string('email')->default('');
            $table->string('website')->default('');
            $table->string('phone', 10)->default('');
            $table->string('facebook_url', 10)->default('');
            $table->text('profile_picture')->default('');
            $table->text('comment')->default('');
            $table->timestamps();
        });

        Schema::create('activities', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('org_id')->unsigned()->nullable();
            $table->string('name');
            $table->text('description')->default('');
            $table->string('address')->default('Kathmandu 44600, Nepal');
            $table->timestamps();

            $table->foreign('org_id')->references('id')->on('organizations')->onDelete('cascade');
        });

        Schema::create('users', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('password', 60);
            $table->enum('roles', array('admin', 'user'))->default('user');
            $table->dateTime('last_login')->nullable();
            $table->dateTime('last_logout')->nullable();
            $table->string('last_ip')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->integer('org_id')->unsigned()->nullable();

            $table->foreign('org_id')->references('id')->on('organizations')->onDelete('cascade');
        });

    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('activities');
        Schema::drop('organizations');
        Schema::drop('users');
	}

}
