<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePgmPermitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pgm_permits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pgm_id',20)->comment("프로그램아이디");
            $table->string('emp_id',5)->comment("사원번호");
            $table->string('permit',8)->comment("프로그램 권한 true/false");
            $table->string('edit_permit',8)->comment("수정권한 true/false");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pgm_permits');
    }
}
