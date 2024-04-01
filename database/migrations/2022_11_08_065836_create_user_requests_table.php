<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_requests', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->references("id")->on("users")->onDelete('cascade');
            $table->unsignedBigInteger("vendor_id");
            $table->foreign("vendor_id")->references("id")->on("users")->onDelete('cascade');
            $table->unsignedBigInteger("coupon_id");
            $table->foreign("coupon_id")->references("id")->on("coupons")->onDelete('cascade');
            $table->text('mrp_price')->nullable();
            $table->text('offer_price')->nullable();
            $table->enum('status', ['user_redeem', 'vendor_redeem'])->nullable()->default('user_redeem');
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
        Schema::dropIfExists('user_requests');
    }
}
