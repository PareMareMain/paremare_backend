<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("vendor_id")->nullable();
            $table->foreign("vendor_id")->references("id")->on("users")->onDelete('cascade');
            $table->text('name')->nullable();
            $table->text('image')->nullable();
            $table->enum('is_redirection_available', ['yes', 'no'])->nullable();
            $table->enum('status', ['pending','rejected','approved'])->nullable()->default('pending');
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
        Schema::dropIfExists('banners');
    }
}
