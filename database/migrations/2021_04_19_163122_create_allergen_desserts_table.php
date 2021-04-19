<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllergenDessertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('allergen_dessert')) {
            Schema::create('allergen_dessert', function (Blueprint $table) {
                $table->id();
                $table->foreignId('allergen_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
                $table->foreignId('dessert_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('allergen_dessert');
    }
}
