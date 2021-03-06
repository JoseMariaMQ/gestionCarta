<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllergenDishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('allergen_dish')) {
            Schema::create('allergen_dish', function (Blueprint $table) {
                $table->id();
                $table->foreignId('allergen_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
                $table->foreignId('dish_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('allergen_dish');
    }
}
