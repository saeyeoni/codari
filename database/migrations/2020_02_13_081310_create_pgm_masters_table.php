<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePgmMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pgm_masters', function (Blueprint $table) {
          $table->string('m_pgm_id',10)->primary()->comment('프로그램 아이디');
          $table->string('m_pgm_nm',20)->comment('프로그램 명');
          $table->string('m_pgm_icon',20)->nullable()->comment('프로그램 아이콘');
          $table->string('pgm_div', 15)->comment('대메뉴ID');
          $table->string('pgm_src', 30)->comment('메뉴 경로');

          $table->integer('sort_num')->nullable()->comment('프로그램 순번');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pgm_masters');
    }
}
