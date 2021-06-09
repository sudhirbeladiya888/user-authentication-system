<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('username',20)->comment('users unique user name');
            $table->string('avatar')->nullable()->comment('users profile pic 256x256 px');
            $table->string('email')->nullable()->unique();
            $table->enum('user_role',['admin','user'])->default('user')->comment('users role');
            $table->enum('status',['active','deactivated','suspended'])->default('deactivated');
            $table->string('password');
            $table->timestamp('registered_at')->nullable();
            $table->ipAddress('register_ip')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
