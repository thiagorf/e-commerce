<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoriteItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('favorite_item', function (Blueprint $table) {
        //     //polimorfc ???
        //     $table->id();
        //     $table->foreignId('product_id')
        //             ->references('id')
        //             ->on('products')
        //             ->onDelete('cascade');
        //     $table->foreignId('favorite_id')
        //             ->references('id')
        //             ->on('favorites')
        //             ->onDelete('cascade');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorite_item');
    }
}
