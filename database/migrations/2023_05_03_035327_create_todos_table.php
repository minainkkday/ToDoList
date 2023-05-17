<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//this is used when you create a table
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            //migrateRefresh
            //$table->user_id(); //sth like this
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id');
            $table->string('name'); //I added the name column
            //Schema hasTable
            //think either I wanna get email or userid
            // $table->string('account');
            $table->text('description'); //I added the description column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todos');
    }
};
