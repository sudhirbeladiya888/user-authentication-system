<?php
/**
 * @Author: Sudhir Beladiya
 * @Last Modified by:   Sudhir
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEmailVerification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_verifications', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->integer('code')->comment('6 DIGIT verification code');
            $table->string('token')->comment('Verification token');
            $table->timestamp('expires_at')->comment('verification code valid till time');
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
        Schema::dropIfExists('email_varifications');
    }
}
