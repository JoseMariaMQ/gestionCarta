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
        if (!Schema::hasTable('dishes')) {
            Schema::create('dishes', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->float('price');
                $table->integer('units')->nullable();
                $table->boolean('extra')->default(false);
                $table->boolean('hidden')->default(false);
                $table->boolean('menu')->default(false);
                $table->float('price_menu')->nullable();
                $table->text('ingredients')->nullable();
                $table->foreignId('section_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('dishes');
    }
}
