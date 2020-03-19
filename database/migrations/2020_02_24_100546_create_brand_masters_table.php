<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_masters', function (Blueprint $table) {
            $table->bigIncrements('id')->comment("브랜드마스터 기본키");
            $table->string('nm',30)->comment("브랜드명");
            $table->unsignedTinyInteger('use_yn')->default('0')->comment("사용유무 0:사용 1:미사용");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brand_masters');
    }
}
