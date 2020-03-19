<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoteHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('note_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('note_id')->comment("노트id");
            $table->text('content')->comment("노트 내용");
            $table->timestamps();
            $table->foreign('note_id')->references('id')->on('note_regists');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('note_histories');
    }
}
