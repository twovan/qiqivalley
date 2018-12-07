<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkLogsTable extends Migration
{
    /**
     * Run the migrations.
     * 工作打卡记录表
     * @return void
     */
    public function up()
    {
        Schema::create('work_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('barber_id')->comment('理发师');
            $table->integer('store_id')->comment('门店');
            $table->timestamp('start_at')->nullable()->comment('上班打卡时间');
            $table->timestamp('end_at')->nullable()->comment('下班打卡时间');
            $table->string('start_img',100)->nullable()->comment('上班打卡图片');
            $table->string('end_img', 100)->nullable()->comment('下班打卡图片');
            $table->tinyInteger('status')->default(0)->comment('1上班，2下班');
            $table->timestamps();
            $table->index(['status','store_id','barber_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_logs');
    }
}
