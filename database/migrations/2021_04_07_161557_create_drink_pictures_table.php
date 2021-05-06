<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrinkPicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('drink_pictures')) {
            Schema::create('drink_pictures', function (Blueprint $table) {
                $table->id();
                $table->foreignId('drink_id')->unique()->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('drink_pictures');
    }
}
