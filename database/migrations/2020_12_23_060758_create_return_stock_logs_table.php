<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnStockLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('return_stock_logs')) {
            Schema::create('return_stock_logs', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('purchase_order_no');
                $table->integer('product_id')->nullable()->unsigned()->index();
                $table->integer('purchase_qtys');
                $table->integer('return_qty');
                $table->string('return_date');
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
        Schema::dropIfExists('return_stock_logs');
    }
}
