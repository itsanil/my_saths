<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('password_resets')) {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');//mandotory
            $table->string('img')->nullable();//optional
            $table->integer('product_source_id')->nullable()->unsigned()->index();
            $table->string('bulk_sale_price');
            $table->string('sale_price');
            $table->string('purchase_qty');
            $table->string('purchase_price');
            $table->string('order_date');
            $table->string('transport_expence');
            $table->string('order_amount');
            $table->integer('status');//mandotory
            $table->timestamps();

            $table->foreign('product_source_id')
            ->references('id')->on('product_sources')
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
        Schema::dropIfExists('products');
    }
}
