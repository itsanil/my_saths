<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCombosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('product_combos')) {
            Schema::create('product_combos', function (Blueprint $table) {
                $table->increments('id');
                $table->string('product_combo_name');
                $table->string('photo');
                $table->text('product_list');
                $table->string('combo_price');
                $table->string('status')->default('Active');
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
        Schema::dropIfExists('product_combos');
    }
}
