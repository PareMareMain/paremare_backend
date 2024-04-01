<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("vendor_id");
            $table->foreign("vendor_id")->references("id")->on("users")->onDelete('cascade');
            $table->string('coupon_code')->nullable()->comment('coupon generate randomly');
            $table->text('tag_name')->nullable()->comment('tag on top like 40% off');
            $table->string('buy_items')->nullable()->comment('No of buy items only for buy and get free items');
            $table->string('free_items')->nullable()->comment('No of free items only for buy and get free items');
            $table->integer('total_limit')->nullable();
            $table->integer('limit_per_user')->nullable();
            $table->double('discount', 15, 2)->nullable()->default(0)->comment('amount or percentage will store');
            $table->enum('coupon_type', ['general', 'individual'])->nullable()->default('general')->comment('manage with type');
            $table->string('offer_type')->nullable()->comment('like buy 1 get 1');
            $table->text('what_inside')->nullable()->comment('sort description');
            $table->text('how_to_redeem')->nullable()->comment('instructions points');
            $table->date('end_date')->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
