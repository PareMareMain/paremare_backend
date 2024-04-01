<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_reasons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("vendor_id")->nullable();
            $table->foreign("vendor_id")->references("id")->on("users")->onDelete('cascade');
            $table->unsignedBigInteger("coupon_id")->nullable();
            $table->foreign("coupon_id")->references("id")->on("coupons")->onDelete('cascade');
            $table->text('reason')->nullable();
            $table->text('resolve_answer')->nullable();
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
        Schema::dropIfExists('coupon_reasons');
    }
}
