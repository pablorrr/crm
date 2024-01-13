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
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');

           // $table->unsignedBigInteger('conversation_id');
            $table->foreign('sender_id')->references('id')->on('users');
            $table->foreign('receiver_id')->references('id')->on('users');
            /**
             * constrianed oznacza klucz ograniczony- jesli usunie pozycje z tabeli nadrzednej to zglosi sie blad
             * zapewnia  spojnosc db
             * https://stackoverflow.com/questions/63280336/is-it-necessary-to-define-foreign-key-constraint-in-laravel-migrations
             */
            //$table->foreignId('conversation_id')->constrained()->after('receiver_id');

            $table->text('body')->nullable();
            $table->boolean('read')->default(0);
            $table->string('type')->nullable();
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
        Schema::dropIfExists('messages');
    }
};
