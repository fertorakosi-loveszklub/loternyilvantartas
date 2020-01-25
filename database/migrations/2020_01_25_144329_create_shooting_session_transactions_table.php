<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShootingSessionTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shooting_session_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('shooting_session_id');
            $table->unsignedBigInteger('caliber_id');
            $table->bigInteger('quantity');

            $table->foreign('shooting_session_id')
                ->references('id')
                ->on('shooting_sessions')
                ->onDelete('cascade');

            $table->foreign('caliber_id')
                ->references('id')
                ->on('calibers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shooting_session_transactions');
    }
}
