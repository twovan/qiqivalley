<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     * 用户表
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid',60);
            $table->string('wx_name',30)->nullable()->comment('微信昵称');
            $table->string('wx_avatar',300)->nullable()->comment('微信头像');
            $table->string('phone',20);
            $table->tinyInteger('status')->default(1)->comment('状态，0禁用，1正常');
            $table->tinyInteger('type')->default(0)->comment('0顾客，1理发师');
            $table->string('work_no',10)->nullable()->comment('理发师工号');
            $table->tinyInteger('vip')->default(0)->nullable()->comment('会员');
            $table->date('vip_exp_at')->nullable()->comment('VIP到期时间');
            $table->rememberToken();
            $table->timestamps();
            $table->index(['openid','status','type','vip','phone']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
