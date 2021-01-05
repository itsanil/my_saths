<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignPerksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('campaign_perks')) {
            Schema::create('campaign_perks', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('campaign_id')->nullable()->unsigned()->index();
                $table->integer('perk_type');
                $table->string('perk_title');
                $table->string('perk_description');
                $table->string('amount');
                $table->string('max_perks');
                $table->string('estimated_date');
                $table->string('shipping_address');
                $table->string('perk_photo');
                $table->timestamps();

                $table->foreign('campaign_id')
                ->references('id')->on('campaigns')
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
        Schema::dropIfExists('campaign_perks');
    }
}
