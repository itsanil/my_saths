<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('password_resets')) {
        Schema::create('promotions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_id')->nullable()->unsigned()->index();
            $table->string('promo_name');
            $table->string('banner_url');
            $table->string('link')->nullable();
            $table->string('start_date');
            $table->string('end_date');
            $table->string('status')->default('Active');
            $table->timestamps();

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
        Schema::dropIfExists('promotions');
    }
}
