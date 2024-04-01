<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("vendor_id");
            $table->foreign("vendor_id")->references("id")->on("users")->onDelete('cascade');
            $table->string('name')->nullable();
            $table->double('amount', 15, 2)->nullable()->default(0);
            $table->string('image')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->nullable()->default('Active');
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
        Schema::dropIfExists('products');
    }
}
