<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticaleCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articale_category', function (Blueprint $table) {
            $table->foreignId('category_id')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('articale_id')
            ->onUpdate('cascade')
            ->onDelete('cascade');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articale_category');
    }
}
