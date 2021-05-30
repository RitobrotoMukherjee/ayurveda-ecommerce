<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->integer('customer_id')->nullable();
            $table->integer('order_status_id')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('customer_first_name')->nullable();
            $table->string('customer_last_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_mobile')->nullable();
            $table->string('delivery_address_1')->nullable();
            $table->string('delivery_address_2')->nullable();
            $table->string('delivery_city')->nullable();
            $table->string('delivery_district')->nullable();
            $table->string('delivery_state')->nullable();
            $table->integer('delivery_pincode')->nullable();
            $table->float('order_total_amount')->nullable();
            $table->float('order_discount')->nullable();
            $table->float('tax_amount')->nullable();
            $table->float('order_final_amount')->nullable();
            $table->string('payment_type')->default('online');
            $table->string('payment_status')->nullable();
            $table->string('payment_gateway')->nullable();
            $table->string('txn_id')->nullable();
            $table->longText('payment_response')->nullable();
            $table->timestamp('despatched_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
