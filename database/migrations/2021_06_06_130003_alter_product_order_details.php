<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProductOrderDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('gst_percentage')->after('discount')->default(0);
        });
        Schema::table('order_details', function (Blueprint $table) {
            $table->integer('gst_percentage')->after('discount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('gst_percentage');
        });
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn('gst_percentage');
        });
    }
}
