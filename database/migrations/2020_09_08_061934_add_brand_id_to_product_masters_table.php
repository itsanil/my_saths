<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBrandIdToProductMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('password_resets')) {
        Schema::table('product_masters', function (Blueprint $table) {
            $table->integer('brand_id')->nullable()->unsigned()->index();

            $table->foreign('brand_id')
            ->references('id')->on('brands')
            ->onDelete('cascade');
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
        Schema::table('product_masters', function (Blueprint $table) {
            //
        });
    }
}
