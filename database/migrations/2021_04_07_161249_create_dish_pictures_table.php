<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDishPicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('dish_pictures')) {
            Schema::create('dish_pictures', function (Blueprint $table) {
                $table->id();
                $table->foreignId('dish_id')->unique()->constrained()->onDelete('cascade');
                $table->string('url', 255);
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
        Schema::dropIfExists('dish_pictures');
    }
}
