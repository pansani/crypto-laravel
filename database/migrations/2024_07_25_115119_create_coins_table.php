<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coins', function (Blueprint $table) {
            $table->id();
            $table->integer('rank');
            $table->string('name');
            $table->string('symbol');
            $table->string('icon');
            $table->float('price');
            $table->float('change24h');
            $table->float('market_cap');
            $table->float('total_volume'); 
            $table->float('ath'); 
            $table->json('chart_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coins');
    }
}

