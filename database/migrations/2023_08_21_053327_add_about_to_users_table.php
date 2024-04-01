<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAboutToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->string('instagram', 255)->nullable();
            $table->string('website', 255)->nullable();
            $table->integer('pin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('instagram');
            $table->dropColumn('website');
            $table->dropColumn('pin');
        });
    }
}
