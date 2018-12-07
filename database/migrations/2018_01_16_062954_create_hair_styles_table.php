<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHairStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hair_styles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20);
            $table->tinyInteger('hair_type')->default(1)->comment('1女，2男，3儿童');
            $table->integer('upload_id')->comment('图片id');
            $table->string('upload_url',100)->comment('图片地址');
            $table->tinyInteger('status')->comment('状态，0禁用，1正常');
            $table->timestamps();
            $table->index(['hair_type','status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hair_styles');
    }
}
