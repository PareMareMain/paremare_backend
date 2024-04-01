<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("sender_id")->nullable();
            $table->foreign("sender_id")->references("id")->on("users")->onDelete('cascade');
            $table->unsignedBigInteger("receiver_id")->nullable();
            $table->foreign("receiver_id")->references("id")->on("users")->onDelete('cascade');
            $table->unsignedBigInteger('module_id')->nullable();
            $table->string('title')->nullable();
            $table->string('notification_type')->nullable();
            $table->text('message')->nullable();
            $table->boolean('read_status')->default(0);
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
        Schema::dropIfExists('notifications');
    }
}
