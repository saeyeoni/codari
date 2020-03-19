<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_masters', function (Blueprint $table) {
            $table->string('emp_nb', 5)->primary()->comment('사원번호');
            $table->string('emp_nm', 20)->comment('사원이름');
            $table->string('login_pw', 100)->default(bcrypt('1111'))->comment('패스워드');
            $table->string('part', 20)->nullable()->comment('부서');
            $table->string('position', 20)->nullable()->comment('직급');
            $table->tinyInteger('emp_div')->default('0')->comment('재직부분 0:재직중, 1:퇴사');
            $table->tinyInteger('overseas_ny')->default('0')->comment('해외접속가능여부 0:N불가능, 1:Y가능');
            $table->tinyInteger('login_grade')->default('0')->comment('0:일반사용자 1: 관리자');
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
        Schema::dropIfExists('emp_masters');
    }
}
