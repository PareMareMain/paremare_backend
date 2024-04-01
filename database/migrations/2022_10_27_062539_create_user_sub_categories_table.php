<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sub_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("vendor_id");
            $table->foreign("vendor_id")->references("id")->on("users")->onDelete('cascade');
            $table->unsignedBigInteger("category_id");
            $table->foreign("category_id")->references("id")->on("categories")->onDelete('cascade');
            $table->unsignedBigInteger("sub_category_id");
            $table->foreign("sub_category_id")->references("id")->on("sub_categories")->onDelete('cascade');
            $table->unsignedBigInteger("user_category_id");
            $table->foreign("user_category_id")->references("id")->on("user_categories")->onDelete('cascade');
            $table->string('sub_category_name')->nullable();
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
        Schema::dropIfExists('user_sub_categories');
    }
}
