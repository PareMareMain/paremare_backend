<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhoneVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_verifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phone_or_email')->nullale();
            $table->string('otp')->nullale();
            $table->enum('status', ['Verified', 'Pending'])->nullable()->default('Pending');
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
        Schema::dropIfExists('phone_verifications');
    }
}
