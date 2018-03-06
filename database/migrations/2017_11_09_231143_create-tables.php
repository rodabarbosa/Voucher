<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('recipient', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();                        
        });
        
        Schema::create('special_offer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('discount')->default(15);
        });
        
        Schema::create('voucher', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->integer('recipient_id')->nullable();
            $table->integer('special_offer_id')->nullable();            
            $table->timestamp('due_date');
            $table->boolean('used')->default(false);
            $table->timestamp('used_on')->nullable();           

            $table->foreign('recipient_id')->references('id')->on('recipient');
            $table->foreign('special_offer_id')->references('id')->on('special_offer');
        });
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {        
        Schema::drop('recipient');
        Schema::drop('special_offer');
        Schema::drop('voucher');
    }
}
