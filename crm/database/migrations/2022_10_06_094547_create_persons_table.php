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
        Schema::create('persons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('surname')->unique();
            $table->string('email')->unique();
            //todo usinac nullable
            $table->integer('phone')->nullable();
            $table->string('photo', 2048)->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('interest_id')->nullable();

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
        Schema::dropIfExists('persons');
        Schema::enableForeignKeyConstraints();

    }
};
