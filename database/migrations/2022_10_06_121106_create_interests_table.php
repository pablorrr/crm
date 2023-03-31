<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description');
            $table->integer('sum');
            $table->string('currency');
            $table->enum('reckoning',
                ['jednorazowo', 'na godzine', 'na tydzien', 'na miesiac'])->default('jednorazowo');
            $table->enum('category', ['express', 'standard', 'strategia'])->default('express');
            $table->foreignId('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('interests');
        Schema::enableForeignKeyConstraints();

    }
};
