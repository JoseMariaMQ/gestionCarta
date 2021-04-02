<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dishes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->float('price');
            $table->integer('units')->nullable();
            $table->boolean('extra')->default(0);
            $table->boolean('hidden')->default(0);
            $table->boolean('menu')->default(0);
            $table->float('price_menu')->nullable();
            $table->text('ingredients')->nullable();
            $table->string('picture', 255)->nullable();
            $table->foreignId('section_id')->constrained()->onDelete('cascade');

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
        Schema::dropIfExists('dishes');
    }
}
