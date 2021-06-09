<?php
/**
 * @Author: Sudhir Beladiya
 * @Last Modified by:   Sudhir
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLogActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('full_path');
            $table->string('name');
            $table->string('mothod')->nullable();
            $table->string('version')->nullable();
            $table->longText('headers')->nullable();
            $table->longText('auth_token')->nullable();
            $table->longText('request')->nullable();
            $table->longText('response')->nullable();
            $table->string('channel')->nullable();
            $table->integer('unix_time');
            $table->text('agent')->nullable();
            $table->ipAddress('remote_ip')->nullable();
            $table->text('remote_location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_activites');
    }
}
