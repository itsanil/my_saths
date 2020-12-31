<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('customer_discounts')) {
            Schema::create('customer_discounts', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('customer_id');
                $table->integer('voucher_id');
                $table->integer('order_id');
                $table->timestamps();

                $table->foreign('customer_id')
                ->references('id')->on('customers')
                ->onDelete('cascade');

                $table->foreign('voucher_id')
                ->references('id')->on('vouchers')
                ->onDelete('cascade');

                $table->foreign('order_id')
                ->references('id')->on('orders')
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
        Schema::dropIfExists('customer_discounts');
    }
}
