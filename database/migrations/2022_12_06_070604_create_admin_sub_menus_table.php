<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminSubMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_sub_menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("admin_id")->nullable();
            $table->foreign("admin_id")->references("id")->on("admins")->onDelete('cascade');
            $table->unsignedBigInteger("menu_id")->nullable();
            $table->foreign("menu_id")->references("id")->on("menus")->onDelete('cascade');
            $table->unsignedBigInteger("admin_menu_id")->nullable();
            $table->foreign("admin_menu_id")->references("id")->on("admin_menus")->onDelete('cascade');
            $table->unsignedBigInteger("sub_menu_id")->nullable();
            $table->foreign("sub_menu_id")->references("id")->on("sub_menus")->onDelete('cascade');
            $table->boolean('permission')->default(0);
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
        Schema::dropIfExists('admin_sub_menus');
    }
}
