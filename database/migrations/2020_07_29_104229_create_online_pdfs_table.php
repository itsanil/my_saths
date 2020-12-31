<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlinePdfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('password_resets')) {
            Schema::create('pdfs', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedBigInteger('user_id');
                $table->string('whatsapp_no');
                $table->text('product_description');
                $table->string('store_name');
                $table->string('contact_no');
                $table->string('background_photo')->nullable();
                $table->string('background_color')->nullable();
                $table->string('sub_title');
                $table->text('store_photo');
                $table->text('store_description');
                $table->text('offer_details')->nullable();
                $table->string('delivery_charge')->nullable();
                $table->string('delivery_time')->nullable();
                $table->string('delivery_holiday')->nullable();
                $table->string('delivery_address')->nullable();
                $table->timestamps();

                $table->foreign('user_id')
                ->references('id')->on('users')
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
        Schema::dropIfExists('pdfs');
    }
}
