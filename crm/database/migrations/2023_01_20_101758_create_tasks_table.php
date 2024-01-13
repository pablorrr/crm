<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     *
     *  artisan migrate,artisan migrate:fresh
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->default('desc');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('test')->nullable();
            $table->foreignId('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     *
     * artisan migrate:refresh
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
