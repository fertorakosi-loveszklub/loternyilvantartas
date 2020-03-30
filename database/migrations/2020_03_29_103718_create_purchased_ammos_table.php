<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasedAmmosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchased_ammo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('caliber_id');
            $table->integer('quantity');

            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('caliber_id')->references('id')->on('calibers')->onDelete('cascade');

            $table->unique(['member_id', 'caliber_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchased_ammo');
    }
}
