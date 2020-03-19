<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoteRegistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('note_regists', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('pgm_div',15)->nullable()->comment('메뉴 구분');
          $table->unsignedBigInteger('brand_id')->comment('브랜드 코드');
          $table->string('emp_id',10)->comment('작성한 사용자');
          $table->unsignedInteger('note_type')->nullable()->comment('작성유형');
          $table->string('map_name',20)->nullable()->comment('project_map의 namespace');
          $table->string('use_type',20)->default('　')->nullable()->comment('사용군');
          $table->string('prd_type',20)->default('　')->nullable()->comment('제품군');
          $table->unsignedInteger('column_index')->nullable()->comment('0부터 순서대로 열번호 증가');
          $table->unsignedTinyInteger('first_div')->default('0')->comment('1:최초작성 0:기본값');
          $table->text('content')->comment('내용');
          $table->softDeletes();
          $table->timestamps();


          $table->foreign('brand_id')->references('id')->on('brand_masters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('note_regists');
    }
}
