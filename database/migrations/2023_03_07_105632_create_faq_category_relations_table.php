<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqCategoryRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq_category_relations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("category_id")->foreign("category_id")->references("id")->on("faq_categories")->onDelete('cascade');
            $table->unsignedBigInteger("faq_id")->foreign("faq_id")->references("id")->on("faqs")->onDelete('cascade');
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
        Schema::dropIfExists('faq_category_relations');
    }
}
