<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorChangeRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('vendor_change_requests')) {

            Schema::create('vendor_change_requests', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('user_id');
                $table->string('field_name');
                $table->string('new_value')->nullable();
                $table->tinyInteger('is_approved')->nullable()->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_change_requests');
    }
}
