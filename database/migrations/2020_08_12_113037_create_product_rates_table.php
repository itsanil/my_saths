<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('password_resets')) {
        Schema::create('product_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->nullable()->unsigned()->index();
            $table->string('purchase_qty');
            $table->string('purchase_price');
            $table->string('transport_expence');
            $table->string('order_amount');
            $table->string('bulk_sale_price');
            $table->string('sale_price');
            $table->timestamps();

            $table->foreign('product_id')
            ->references('id')->on('products')
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
        Schema::dropIfExists('product_rates');
    }
}
