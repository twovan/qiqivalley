<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_no',20)->unique()->comment('订单号');
            $table->string('queue_no',10)->comment('排队号');
            $table->integer('customer_id');
            $table->integer('barber_id')->nullable();
            $table->integer('store_id');
            $table->integer('service_id');
            $table->string('pay_type');
            $table->decimal('pay_fee')->nullable();
            $table->string('img_url',300)->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamp('pay_at')->nullable();
            $table->tinyInteger('status')->comment('状态，-1未支付，1待服务，2待评价，3已完成');
            $table->timestamps();
            $table->index('customer_id');
            $table->index('barber_id');
            $table->index('store_id');
            $table->index('status');
            $table->index('service_id');
            $table->index('pay_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
