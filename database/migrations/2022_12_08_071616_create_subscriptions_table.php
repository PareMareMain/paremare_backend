<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('subscriptions');

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('amount')->nullable();
            $table->integer('post_quantity')->nullable();
            $table->enum('plan_type',['1','2','3'])->comment('1=daily,2=monthly,3=yearly')->default('3');
            $table->integer('status')->default('0')->comment('1=active,0=inactive');
            $table->integer('type')->default('0')->comment('0=customer,1=vendor');
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
        Schema::dropIfExists('subscriptions');
    }
}
