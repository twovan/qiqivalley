<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->comment('名称');
            $table->string('name',60)->comment('名称');
            $table->string('remark',100)->nullable()->comment('简介');
            $table->decimal('price',8,2)->comment('价格');
            $table->integer('upload_id')->comment('图片id');
            $table->string('upload_url',100)->comment('图片地址');
            $table->tinyInteger('status')->comment('状态，0禁用，1正常');
            $table->timestamps();
            $table->index(['status','store_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
