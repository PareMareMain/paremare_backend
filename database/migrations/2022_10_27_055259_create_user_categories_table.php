<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("vendor_id");
            $table->foreign("vendor_id")->references("id")->on("users")->onDelete('cascade');
            $table->unsignedBigInteger("category_id");
            $table->string('category_name')->nullable();
            $table->foreign("category_id")->references("id")->on("categories")->onDelete('cascade');
            $table->enum('status', ['active', 'inactive'])->nullable()->default('active');
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
        Schema::dropIfExists('user_categories');
    }
}
