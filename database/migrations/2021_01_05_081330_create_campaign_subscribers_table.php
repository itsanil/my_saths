<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	if (!Schema::hasTable('campaign_subscribers')) {
	        Schema::create('campaign_subscribers', function (Blueprint $table) {
	            $table->increments('id');
                $table->integer('campaign_id')->nullable()->unsigned()->index();
                $table->integer('user_id')->nullable()->unsigned()->index();
                $table->timestamps();

                $table->foreign('campaign_id')
                ->references('id')->on('campaign')
                ->onDelete('cascade');

                $table->foreign('user_id')
                ->references('id')->on('user')
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
        Schema::dropIfExists('campaign_subscribers');
    }
}
