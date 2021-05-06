<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDessertPicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('dessert_pictures')) {
            Schema::create('dessert_pictures', function (Blueprint $table) {
                $table->id();
                $table->foreignId('dessert_id')->unique()->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('dessert_pictures');
    }
}
